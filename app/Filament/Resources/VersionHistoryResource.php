<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VersionHistoryResource\Pages;
use App\Filament\Resources\VersionHistoryResource\RelationManagers;
use App\Models\ModuleManagement;
use App\Models\VersionHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VersionHistoryResource extends Resource
{
    protected static ?string $model = ModuleManagement::class;

    protected static ?string $navigationLabel = 'Version History';

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Version Histor';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('module.name')->label('Module')->searchable()->sortable(),
                TextColumn::make('version')->label('Version')->searchable()->sortable(),
                TextColumn::make('released_date')->date()->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListVersionHistories::route('/'),
            // 'create' => Pages\CreateVersionHistory::route('/create'),
            'edit' => Pages\EditVersionHistory::route('/{record}/edit'),
        ];
    }
}
