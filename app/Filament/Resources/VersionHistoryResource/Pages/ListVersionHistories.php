<?php

namespace App\Filament\Resources\VersionHistoryResource\Pages;

use App\Filament\Resources\VersionHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVersionHistories extends ListRecords
{
    protected static string $resource = VersionHistoryResource::class;
    
    protected static ?string $title = 'Version History';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
