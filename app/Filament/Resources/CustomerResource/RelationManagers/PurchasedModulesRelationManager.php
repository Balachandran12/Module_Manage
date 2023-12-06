<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RelationManagers\RelationManager;
use App\Models\Module;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager as RelationManagersRelationManager;
use Illuminate\Support\Collection;
use App\Models\ModuleManagement;
use App\Models\PurchasedModule;
use App\Tables\Columns\Copy;
use Filament\Forms\Get;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PurchasedModulesRelationManager extends RelationManagersRelationManager
{
    protected static string $relationship = 'purchasedModules';

    public function aftersave(){
        dd(1);
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                    Select::make('module_management_id')->options(
                        function($record){
                            $purchasedModules = PurchasedModule::where('customer_id', $this->ownerRecord->id)
                    ->with('ModuleManagement')
                    ->get();

                        $purchasedModuleManagementIds = $purchasedModules->pluck('module_management_id')->unique();
                        $purchasedModulesIds = $purchasedModules->map(function ($purchasedModule) {
                            return $purchasedModule->ModuleManagement->modules_id;
                        })->unique();
                        return  ModuleManagement::with('module')
                        ->whereNotIn('id', $purchasedModuleManagementIds) // Exclude based on ModuleManagement IDs
                        ->whereNotIn('modules_id', $purchasedModulesIds) // Exclude based on Modules IDs
                        ->get()
                        ->unique('modules_id')
                        ->pluck('module.name', 'id');
                        }
                    )->live()->required(),  
                    Select::make('version')->required()->options(function (Get $get){
                        if($get('module_management_id')){
                        $ranom = ModuleManagement::find($get('module_management_id'));
                        if ($ranom) {
                            // $ranom = $ranom->pluck('modules_id');
                          return  ModuleManagement::query()
                            ->where('modules_id', $ranom->modules_id)
                            ->pluck('version', 'id');
                        }
                    }
                    }
                ),
                    DatePicker::make('date_of_purchased')->label('Date of purchased')->required(),
                    // TextInput::make('license'),
            ]);
    }
    public $length =25;
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('ModuleManagement.module.name')->label('Module Name'),
                SelectColumn::make('version')->label('Version')->options(function($record){
                    PurchasedModule::find($record->id);
                    $random = PurchasedModule::with('ModuleManagement')->find($record->id);
                   $data = ModuleManagement::where('modules_id',$random->ModuleManagement->modules_id)->pluck('version','id');
                   return $data;
                }
                ),
                Tables\Columns\TextColumn::make('date_of_purchased')
                    ->label('Purchased Date')
                    ->date()
                    ->sortable(),
            // Tables\Columns\TextColumn::make('license')->label('License')
            // ->state(function (Model $record) {
            //     return 'ji';
            // })->copyable()
            // ->copyMessage('Copied')
            // ->copyMessageDuration(1500),
            Copy::make('license')->view('tables.columns.copy')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->after(function ($record) {
                    // dd($record->id);
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $this->length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                $license = PurchasedModule::find($record->id);
                $license->update([
                    'license' => $randomString,
                ]);
                }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([

            ]);
    }
    protected static function afterCreate($record): void
    {
        Log::info('afterCreate called for record: ' . $record->id);
        // Your custom logic
    }
}
