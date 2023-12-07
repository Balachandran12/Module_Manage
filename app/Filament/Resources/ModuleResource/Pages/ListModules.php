<?php

namespace App\Filament\Resources\ModuleResource\Pages;

use App\Filament\Resources\ModuleResource;
use App\Models\ModuleManagement;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModules extends ListRecords
{
    protected static string $resource = ModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add New Module')->createAnother(false)->after(function($record,$data){
                ModuleManagement::create([
                    'modules_id' =>$record->id,
                    'version' =>$data['version'],
                    'base_versions_id'=>$data['base_versions_id'],
                    'released_date'=>$data['released_date'],
                    'change_log'=>$data['change_log'],
                ]);
            }),
        ];
    }
}
