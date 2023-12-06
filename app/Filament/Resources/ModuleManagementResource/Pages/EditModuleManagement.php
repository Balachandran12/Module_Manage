<?php

namespace App\Filament\Resources\ModuleManagementResource\Pages;

use App\Filament\Resources\ModuleManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModuleManagement extends EditRecord
{
    protected static string $resource = ModuleManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
