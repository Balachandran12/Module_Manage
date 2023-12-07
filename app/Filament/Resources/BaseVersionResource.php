<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BaseVersionResource\Pages;
use App\Filament\Resources\BaseVersionResource\RelationManagers;
use App\Models\BaseVersion;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BaseVersionResource extends Resource
{
    protected static ?string $model = BaseVersion::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Base version')->unique(),
                DatePicker::make('update_date')->label('Update date'),
                Textarea::make('change_log')->label('Change log')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Base version'),
                TextColumn::make('update_date')->label('Update date'),
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
            'index' => Pages\ListBaseVersions::route('/'),
            // 'create' => Pages\CreateBaseVersion::route('/create'),
            // 'edit' => Pages\EditBaseVersion::route('/{record}/edit'),
        ];
    }
}
