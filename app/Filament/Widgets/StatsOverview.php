<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Module;
use App\Models\PaymentHistory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $module = Module::all();
        $count = Customer::all();
        $paymemt = PaymentHistory::all();
        $sum =0;
        foreach($paymemt as $paymemts){
            $sum += $paymemts->amount;
        }
        return [
            Stat::make('Revenue Generated', '$'.$sum),
            Stat::make('Total Number Of Customer', count($count)),
            Stat::make('Total Number Of Modules', count($module)),
        ];
    }
}
