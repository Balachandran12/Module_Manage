<?php

namespace App\Tables\Columns;
use Livewire\Component;
use Filament\Tables\Columns\Column;

class Copy extends Column
{
    protected string $view = 'tables.columns.copy';

    public function random(){
        dd(1);
    }

}
