<?php

namespace App\Filament\Widgets;

use App\Models\Module;
use App\Models\PurchasedModule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ModuleCustomer extends ApexChartWidget
{
  /**
     * Chart Id
     *
     * @var string
     */
    protected static ?int $sort = 2;

    protected static string $chartId = 'modulePurchaseChart';
    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'ModulePurchaseChart';
    public ?string $filter = '0';
    protected function getFilters(): ?array
    {
        $modules[0] = 'Select an Option';
        $modul = Module::all();
        foreach($modul as $value){
            $modules[$value->id] = $value->name;
        }
        // dd($modules);
        return $modules;
    }
    public $months;
    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    public $activeFilter;
    protected function getOptions(): array
    {
        
        $activeFilter = $this->filter;
        $this->months = [];
        $now = Carbon::now();
        for ($i = 11; $i >= 0; $i--) {
            $this->months[] = $now->copy()->subMonths($i)->format('M');
        }
        // dd($this->months);
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        // $candidateData = PurchasedModule::WhereHas('ModuleManagement',function($query){
        //     $query->where('modules_id',1);
        // })->get();
        $candidateData = PurchasedModule::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('count(*) as count'),
        )
        ->WhereHas('ModuleManagement',function($query) use ($activeFilter){
            $query->where('modules_id',$activeFilter);
        })
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            // ->pluck('count')
            ->toArray();
            // dd($candidateData);
        $data=[];
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
                    'name' => 'BasicBarChart',
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

