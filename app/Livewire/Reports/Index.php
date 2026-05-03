<?php

namespace App\Livewire\Reports;

use App\Models\Department;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    #[Url(history: true)]
    public $year = '';

    #[Url(history: true)]
    public $department_id = '';

    /**
     * Numeric weight threshold — departments averaging below this are "weak".
     * Scale: A=95, B+=85, B=75, C+=65, C=55, F=25
     * Default 65 = below C+ is considered weak.
     */
    public $threshold = 65;

    /**
     * Map letter grades to a representative numeric weight for ranking.
     */
    private const GRADE_WEIGHTS = [
        'A'  => 95,
        'B+' => 85,
        'B'  => 75,
        'C+' => 65,
        'C'  => 55,
        'F'  => 25,
    ];



    public function resetFilters()
    {
        $this->year          = '';
        $this->department_id = '';
    }

    /**
     * Convert a numeric average weight back to its representative letter grade.
     */
    public static function weightToLetter(?float $weight): string
    {
        if ($weight === null) return 'N/A';
        if ($weight >= 90) return 'A';
        if ($weight >= 80) return 'B+';
        if ($weight >= 70) return 'B';
        if ($weight >= 60) return 'C+';
        if ($weight >= 50) return 'C';
        return 'F';
    }

    /**
     * Return a Tailwind badge class for a given letter grade.
     */
    public static function gradeColor(string $letter): string
    {
        return match ($letter) {
            'A'     => 'bg-blue-100 text-blue-800',
            'B+'    => 'bg-green-100 text-green-800',
            'B'     => 'bg-teal-100 text-teal-800',
            'C+'    => 'bg-yellow-100 text-yellow-800',
            'C'     => 'bg-orange-100 text-orange-800',
            'F'     => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * Return the threshold as a letter grade label for display.
     */
    public function thresholdLabel(): string
    {
        return self::weightToLetter($this->threshold);
    }

    #[Computed]
    public function analyticsData()
    {
        $cacheKey = 'reports_analytics_' . md5(serialize([
            'year'          => $this->year,
            'department_id' => $this->department_id,
            'threshold'     => $this->threshold,
        ]));

        return Cache::remember($cacheKey, 100, function () {
            // Eager-load departments with their project grades (string values), filtered by is_archiv=1
            $departments = Department::query()
            ->when($this->department_id, fn($q) => $q->where('id', $this->department_id))

            ->whereHas('projects', function ($q) {
                $q->where('is_archiv', 1)
                ->when($this->year, fn($q) => $q->where('year', $this->year));
            }, '>=', 30)


            ->withCount(['projects' => function ($q) {
                $q->where('is_archiv', 1)
                  ->when($this->year, fn($q) => $q->where('year', $this->year));
            }])
            ->with(['projects' => function ($q) {
                $q->where('is_archiv', 1)
                  ->when($this->year, fn($q) => $q->where('year', $this->year))
                  ->select('department_id', 'grade'); // only what we need
            }])
            ->get();

            // Compute per-department average weight from letter grades
            $departments->each(function ($dept) {
                $weights = $dept->projects
                    ->pluck('grade')
                    ->filter()                            // remove nulls/empty
                    ->map(fn($g) => self::GRADE_WEIGHTS[$g] ?? null)
                    ->filter();                           // remove unknown grades

                $dept->avg_weight  = $weights->isNotEmpty() ? round($weights->avg(), 2) : null;
                $dept->avg_letter  = self::weightToLetter($dept->avg_weight);
                $dept->grade_color = self::gradeColor($dept->avg_letter);
            });

            // Overall stats across all filtered departments
            $allWeights = $departments->flatMap(
                fn($d) => $d->projects->pluck('grade')->filter()->map(fn($g) => self::GRADE_WEIGHTS[$g] ?? null)->filter()
            );

            $overallWeight = $allWeights->isNotEmpty() ? round($allWeights->avg(), 2) : null;
            $overallLetter = self::weightToLetter($overallWeight);

            $totalProjects = $departments->sum('projects_count');

            // Sort: departments with grades first (desc), departments with no projects last
            $sorted  = $departments->sortByDesc(fn($d) => $d->avg_weight ?? -1);
            $topDept = $sorted->first(fn($d) => $d->avg_weight !== null);

            return [
                'stats' => [
                    'total_projects'  => $totalProjects,
                    'avg_grade_label' => $overallLetter,
                    'avg_grade_color' => self::gradeColor($overallLetter),
                    'top_department'  => $topDept ? $topDept->name : 'N/A',
                    'top_dept_grade'  => $topDept ? $topDept->avg_letter : 'N/A',
                    'top_dept_color'  => $topDept ? $topDept->grade_color : 'bg-gray-100 text-gray-600',
                ],
                'departments'      => $sorted,
                'top_departments'  => $sorted->filter(fn($d) => $d->avg_weight !== null)->take(5),
                'weak_departments' => $departments->filter(
                    fn($d) => $d->projects_count > 0
                           && $d->avg_weight !== null
                           && $d->avg_weight < $this->threshold
                )->sortBy('avg_weight'),
            ];
        });
    }

    public function render()
    {
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 19);

        return view('livewire.reports.index', [
            'data'        => $this->analyticsData(),
            'years'       => $years,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}
