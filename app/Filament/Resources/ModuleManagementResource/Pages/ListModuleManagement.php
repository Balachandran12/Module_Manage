<?php

namespace App\Filament\Resources\ModuleManagementResource\Pages;

use App\Filament\Resources\ModuleManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModuleManagement extends ListRecords
{
    protected static string $resource = ModuleManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Update Module Management'),
        ];
    }

}
