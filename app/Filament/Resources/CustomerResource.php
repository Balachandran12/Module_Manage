<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Filament\Resources\CustomerResource\RelationManagers\PaymentHistoriesRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers\PurchasedModulesRelationManager;
use App\Models\BaseVersion;
use App\Models\Customer;
use App\Models\Module;
use App\Models\ModuleManagement;
use App\Models\PurchasedModule;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                ->schema([
                    TextInput::make('name')->label('Name')->required(),
                    TextInput::make('company_name')->label('Company name')->required(),
                    Select::make('base_versions_id')->label('Version')->options(
                        BaseVersion::pluck('name','id')
                    )->required(),
                    TextInput::make('email_address')->email()->label('Email address')->required(),
                ])->columns(2)
                ->columnSpan(['lg' => fn (?Customer $record) => $record === null ? 2 : 1]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('date_of_purchased')
                            ->label('Last Purchased at')
                            ->content(function($record){
                                $rean =  PurchasedModule::where('customer_id',$record->id)->latest()->first();
                                // dd($rean);
                                if($rean == null){
                                    return 0;
                                }
                                else{
                                    return $rean->date_of_purchased;
                                }
                            }),
                        Placeholder::make('is_active')->label('Status')->content(function($record){
                            $status =  Customer::find($record->id);
                            if($status->is_active == 1){
                                return 'Active';
                            }
                            else{
                                return 'Inactive';
                            }
                        }),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Customer $record) => $record === null),
                


                Section::make('Purchased Modules')
                ->hiddenOn('edit')
                ->relationship('purchasedModules')
                ->schema([
                    Select::make('module_management_id')->label('Module Name')->options(
                        // Module::pluck('name', 'id')
                        ModuleManagement::with('module')->get()->unique('modules_id')->pluck('module.name','id')

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
                    DatePicker::make('date_of_purchased')->label('Purchased date')->required(),
                    // TextInput::make('license'),
                ])->columns(2),
                Section::make('Payment History')
                ->relationship('paymentHistories')
                ->hiddenOn('edit')
                ->schema([
                    Select::make('module_management_id')->options(
                        ModuleManagement::with('module')->get()->unique('modules_id')->pluck('module.name','id')
                    )->required()->label('Module Name'),
                    TextInput::make('payment_id')->label('Payment ID')->required(),
                    DatePicker::make('payment_date')->label('Payment Date')->required(),
                    TextInput::make('amount')->numeric()->label('Amount')->required(),
                    TextInput::make('provider')->label('Provider')->required(),
                    Select::make('method')->required()
                            ->options([
                                'cash' => 'cash',
                                'card' => 'card',
                            ])
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('email_address')->label('Email address'),
                TextColumn::make('baseVersions.name')->label('Version'),
                TextColumn::make('')->label('Date of purchased')->date()->default(function($record){
                   $rean =  PurchasedModule::where('customer_id',$record->id)->latest()->first();
                   if($rean == null){
                    return null;
                   }
                   else{
                    return $rean->date_of_purchased;
                   }
                }),
                ToggleColumn::make('is_active')->label('Is Active')
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
            
            RelationGroup::make('', [
                PurchasedModulesRelationManager::class,
                PaymentHistoriesRelationManager::class,
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
