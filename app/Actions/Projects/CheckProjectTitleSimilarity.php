<?php

namespace App\Actions\Projects;

use App\Models\Project;
use Carbon\Carbon;

class CheckProjectTitleSimilarity
{
    private const THRESHOLD = 95;
    private const LOOKBACK_YEARS = 2;

    /**
     * @return array<int, array{existing_title: string, similarity: float}>
     */
    public function search(string $title): array
    {
        $similar = [];

        foreach ($this->recentTitles() as $existingTitle) {
            similar_text($title, $existingTitle, $percent);

            if ($percent >= self::THRESHOLD) {
                $similar[] = [
                    'existing_title' => $existingTitle,
                    'similarity' => round($percent, 2),
                ];
            }
        }

        return $similar;
    }

    private function recentTitles(): array
    {
        return Project::where('year', '>=', Carbon::now()->year - self::LOOKBACK_YEARS)
            ->pluck('title')
            ->all();
    }
}
