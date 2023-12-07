<?php

namespace App\Filament\Resources\BaseVersionResource\Pages;

use App\Filament\Resources\BaseVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBaseVersions extends ListRecords
{
    protected static string $resource = BaseVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Base Version')->createAnother(false),
        ];
    }
}
