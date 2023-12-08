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
            // dd($paymemts->amount);
            $sum += $paymemts->amount;
        }
        return [
            Stat::make('Total Revenue', '$'.$sum),
            Stat::make('Total customer', count($count)),
            Stat::make('Total Modules', count($module)),
        ];
    }
}
