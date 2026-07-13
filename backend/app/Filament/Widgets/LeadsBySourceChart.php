<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadsBySourceChart extends ChartWidget
{
    protected static ?string $heading = 'Leads by Source';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $leadsBySource = Lead::query()
            ->selectRaw("
                CASE
                    WHEN source IS NULL OR source = '' THEN 'Unknown'
                    ELSE source
                END AS lead_source,
                COUNT(*) AS total
            ")
            ->groupBy('lead_source')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => $leadsBySource
                        ->pluck('total')
                        ->map(fn ($total) => (int) $total)
                        ->all(),
                ],
            ],

            'labels' => $leadsBySource
                ->pluck('lead_source')
                ->map(fn ($source) => ucfirst(
                    str_replace(['-', '_'], ' ', $source)
                ))
                ->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
