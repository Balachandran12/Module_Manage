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
use Filament\Forms\Get;



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
                // ->rules([
                //     fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get){
                //         // dd($get('modules_id'),$get('version'));
                //         if($get('modules_id')){
                //         $ranom = ModuleManagement::find($get('modules_id'));
                //         if ($ranom->version == $get('version')) {
                //             $fail("The Version is already here.");
                //         }
                //     }
                //     }
                // ]),
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
            'index' => Pages\ListModules::route('/'),
            // 'create' => Pages\CreateModule::route('/create'),
            // 'edit' => Pages\EditModule::route('/{record}/edit'),
        ];
    }
}
