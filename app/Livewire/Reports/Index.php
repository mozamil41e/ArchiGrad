<?php

namespace App\Livewire\Reports;

use App\Models\Department;
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

    public $threshold = 65;

    private const GRADES = [
        'A' => 95, 'B+' => 85, 'B' => 75,
        'C+' => 65, 'C' => 55, 'F' => 25,
    ];

    private const GRADE_COLORS = [
        'A' => 'bg-blue-100 text-blue-800',
        'B+' => 'bg-green-100 text-green-800',
        'B' => 'bg-teal-100 text-teal-800',
        'C+' => 'bg-yellow-100 text-yellow-800',
        'C' => 'bg-orange-100 text-orange-800',
        'F' => 'bg-red-100 text-red-800',
    ];

    public function resetFilters(): void
    {
        $this->year = $this->department_id = '';
    }

    public static function weightToLetter(?float $w): string
    {
        return match (true) {
            $w === null  => 'N/A',
            $w >= 90     => 'A',
            $w >= 80     => 'B+',
            $w >= 70     => 'B',
            $w >= 60     => 'C+',
            $w >= 50     => 'C',
            default      => 'F',
        };
    }

    public static function gradeColor(string $letter): string
    {
        return self::GRADE_COLORS[$letter] ?? 'bg-gray-100 text-gray-600';
    }

    public function thresholdLabel(): string
    {
        return self::weightToLetter($this->threshold);
    }

    private function applyFilters($query)
    {
        return $query->where('is_archiv', 1)
            ->when($this->year, fn($q) => $q->where('year', $this->year));
    }

    private function avgWeight($grades): ?float
    {
        $weights = $grades->filter()
            ->map(fn($g) => self::GRADES[$g] ?? null)
            ->filter();

        return $weights->isNotEmpty() ? round($weights->avg(), 2) : null;
    }

    #[Computed]
    public function analyticsData(): array
    {
        return Cache::remember(
            'reports_' . md5("{$this->year}|{$this->department_id}|{$this->threshold}"),
            100,
            function () {
                $departments = Department::query()
                    ->when($this->department_id, fn($q) => $q->where('id', $this->department_id))
                    ->whereHas('projects', fn($q) => $this->applyFilters($q), '>=', 30)
                    ->withCount(['projects' => fn($q) => $this->applyFilters($q)])
                    ->with(['projects' => fn($q) => $this->applyFilters($q)->select('department_id', 'grade')])
                    ->get()
                    ->each(function ($dept) {
                        $dept->avg_weight  = $this->avgWeight($dept->projects->pluck('grade'));
                        $dept->avg_letter  = self::weightToLetter($dept->avg_weight);
                        $dept->grade_color = self::gradeColor($dept->avg_letter);
                    });

                $overallWeight = $this->avgWeight(
                    $departments->flatMap(fn($d) => $d->projects->pluck('grade'))
                );
                $overallLetter = self::weightToLetter($overallWeight);

                $sorted  = $departments->sortByDesc(fn($d) => $d->avg_weight ?? -1);
                $topDept = $sorted->first(fn($d) => $d->avg_weight !== null);

                return [
                    'stats' => [
                        'total_projects'  => $departments->sum('projects_count'),
                        'avg_grade_label' => $overallLetter,
                        'avg_grade_color' => self::gradeColor($overallLetter),
                        'top_department'  => $topDept?->name ?? 'N/A',
                        'top_dept_grade'  => $topDept?->avg_letter ?? 'N/A',
                        'top_dept_color'  => $topDept?->grade_color ?? 'bg-gray-100 text-gray-600',
                    ],
                    'departments'      => $sorted,
                    'top_departments'  => $sorted->filter(fn($d) => $d->avg_weight !== null)->take(5),
                    'weak_departments' => $departments
                        ->filter(fn($d) => $d->projects_count > 0 && $d->avg_weight < $this->threshold)
                        ->sortBy('avg_weight'),
                ];
            }
        );
    }

    public function render()
    {
        return view('livewire.reports.index', [
            'data'        => $this->analyticsData(),
            'years'       => range(date('Y'), date('Y') - 19),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}
