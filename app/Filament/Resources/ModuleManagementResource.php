<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleManagementResource\Pages;
use App\Filament\Resources\ModuleManagementResource\RelationManagers;
use App\Models\ModuleManagement;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class ModuleManagementResource extends Resource
{
    protected static ?string $model = ModuleManagement::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Module Management';
    // public $values=[];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('modules_id')->relationship('module','name')->label('Module name')->required(),
                TextInput::make('version')->label('Version')->required()->rules([
                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get){
                        if($get('modules_id')){
                        $values=[];
                        $ranom = ModuleManagement::Where('modules_id',$get('modules_id'))->get();
                        // dd($ranom,$get('version'));
                        foreach($ranom as $value){
                            array_push($values,$value->version);
                        }
                        if(in_array($get('version'),$values)){
                            $fail("The Version is already here.");
                        }
                        // if ($ranom->version == $get('version')) {
                        // }
                    }
                    }
                ])->hiddenOn('edit'),
                TextInput::make('version')->label('Version')->required()->hiddenOn('create'),
                Select::make('base_versions_id')->required()->relationship('baseVersion','name')->label('Minimum version'),
                DatePicker::make('released_date')->required()->label('Released Date'),
                Textarea::make('change_log')->required()->label('Change log'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
             ->modifyQueryUsing(function (Builder $query) {
                $query->from(
                    ModuleManagement::selectRaw('modules_id, MAX(created_at) as latest')
                        ->groupBy('modules_id')
                        ->toBase(), 'latest_records')
                ->join('module_management', function ($join) {
                    $join->on('latest_records.modules_id', '=', 'module_management.modules_id')
                         ->on('latest_records.latest', '=', 'module_management.created_at');
                })
                ->get();
            // dd($newestModuleRecords);
                // $datapush=[];
                // foreach($query->get() as $modeldata){
                //     array_push($datapush,$modeldata->modules_id);
                //     $uniqueArray = array_unique($datapush);
                // }
                // $new=[];
                // foreach($uniqueArray as $value){
                //     $newestModuleRecord= ModuleManagement::where('modules_id', $value)
                //             ->orderBy('created_at', 'desc')
                //             ->first();
                //             // dd($newestModuleRecord);
                //             array_push($new,$newestModuleRecord);
                // }
                // dd($new);
                
            })
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
