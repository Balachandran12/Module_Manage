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
use App\Models\ModuleManagement;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager as RelationManagersRelationManager;
use Filament\Tables\Columns\TextColumn;

class PaymentHistoriesRelationManager extends RelationManagersRelationManager
{
    protected static string $relationship = 'paymentHistories';

    public function form(Form $form): Form
    {
        return $form
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
                    ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('ModuleManagements.module.name')->label('Module Name')->searchable()->sortable(),
                TextColumn::make('payment_id')->label('Payment ID')->searchable()->sortable(),
                TextColumn::make('payment_date')
                    ->label('Payment date')
                    ->date()->searchable()
                    ->sortable(),
                TextColumn::make('amount')->money('USD')->label('Amount')->searchable()->sortable(),
                TextColumn::make('provider')->label('Provider')->searchable()->sortable(),
                TextColumn::make('method')->label('Method')

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
