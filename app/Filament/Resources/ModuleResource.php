<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleResource\Pages;
use App\Filament\Resources\ModuleResource\RelationManagers;
use App\Models\BaseVersion;
use App\Models\Module;
use App\Models\ModuleManagement;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Actions\Action as ActionsAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action as TablesActionsAction;

class ModuleResource extends Resource
{
    protected static ?string $model = Module::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Module')->unique(),
                TextInput::make('version')->label('Version')->required(),
                Select::make('base_versions_id')->required()->label('Minimum version')->options( BaseVersion::pluck('name','id') ),
                DatePicker::make('released_date')->required()->label('Released Date')->minDate(Carbon::now()),
                Textarea::make('change_log')->required()->label('Description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Module')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                
            ])
            // ->headerActions([
            //     TablesActionsAction ::make('New module')->form([
            //         Grid::make(2)
            //     ->schema([
            //         TextInput::make('name')->label('Module')->unique(),
            //         TextInput::make('version')->label('Version')->required(),
            //         Select::make('base_versions_id')->required()->label('Minimum version')->options( BaseVersion::pluck('name','id') ),
            //         DatePicker::make('released_date')->required()->label('Released Date')->minDate(Carbon::now()),
            //         Textarea::make('change_log')->required()->label('Description'),
            //     ])
            //     ])->action(function ($data,$record): void {
            //         $module = Module::create([
            //             'name' => $data['name'],
            //         ]);
            //         ModuleManagement::create([
            //             'modules_id' =>$module->id,
            //             'version' =>$data['version'],
            //             'base_versions_id'=>$data['base_versions_id'],
            //             'released_date'=>$data['released_date'],
            //             'change_log'=>$data['change_log'],
            //         ]);
            //     }),
            // ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModules::route('/'),
            // 'create' => Pages\CreateModule::route('/create'),
            // 'edit' => Pages\EditModule::route('/{record}/edit'),
        ];
    }
}
