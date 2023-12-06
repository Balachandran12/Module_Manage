<?php

namespace App\Filament\Resources\VersionHistoryResource\Pages;

use App\Filament\Resources\VersionHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVersionHistory extends EditRecord
{
    protected static string $resource = VersionHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
