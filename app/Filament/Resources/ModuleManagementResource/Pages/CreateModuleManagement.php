<?php

namespace App\Filament\Resources\ModuleManagementResource\Pages;

use App\Filament\Resources\ModuleManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateModuleManagement extends CreateRecord
{
    protected static string $resource = ModuleManagementResource::class;

    protected ?string $heading = 'Update Module Management';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
