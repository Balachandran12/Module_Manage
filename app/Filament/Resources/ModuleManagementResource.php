<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleManagementResource\Pages;
use App\Filament\Resources\ModuleManagementResource\RelationManagers;
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

class ModuleManagementResource extends Resource
{
    protected static ?string $model = ModuleManagement::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('modules_id')->relationship('module','name')->label('Module Name')->required(),
                TextInput::make('version')->label('Version')->required(),
                Select::make('base_versions_id')->required()->relationship('baseVersion','name')->label('Minimum version'),
                DatePicker::make('released_date')->required()->label('Released Date'),
                Textarea::make('change_log')->required()->label('Description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('module.name')->label('Module')->searchable(),
                TextColumn::make('version')->label('Version')->searchable(),
                TextColumn::make('baseVersion.name')->label('Minimum Version'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListModuleManagement::route('/'),
            'create' => Pages\CreateModuleManagement::route('/create'),
            'edit' => Pages\EditModuleManagement::route('/{record}/edit'),
        ];
    }
}
