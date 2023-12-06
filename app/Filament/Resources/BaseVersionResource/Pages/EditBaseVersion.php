<?php

namespace App\Filament\Resources\BaseVersionResource\Pages;

use App\Filament\Resources\BaseVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBaseVersion extends EditRecord
{
    protected static string $resource = BaseVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
