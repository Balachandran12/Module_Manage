<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ModuleCharts extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'moduleCharts';
    protected static ?int $sort = 3;
    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Total Number Of Customer';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    public $months;
    protected function getOptions(): array
    {
        $this->months = [];
        $now = Carbon::now();
        for ($i = 11; $i >= 0; $i--) {
            $this->months[] = $now->copy()->subMonths($i)->format('M');
        }
        // dd($this->months);
        // $sixMonthsAgo = Carbon::now()->subMonths(6);
        $candidateData = Customer::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('count(*) as count'),
        )

            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            // ->pluck('count')
            ->toArray();
        $data=[];
        // dd($candidateData);
            if (count($candidateData) > 0) {
                for ($i = 11; $i >= 0; $i--) {
                foreach ($candidateData as $monthCount) {
                    if ($now->copy()->subMonths($i)->format('n') == $monthCount['month']) {
                        $Countdata = $monthCount['count'];
                        break;
                    } else {
                        $Countdata = 0;
                    }
                }
                $data[]=$Countdata;
            }
        }
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
                'width' => 500,
            ],
            'series' => [
                [
                    'name' => 'Customer',
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $this->months,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'categories' => [0, 5, 10, 15, 20, 25, 30],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 5,
                    'horizontal' => false,
                ],
            ],
        ];
    }
}