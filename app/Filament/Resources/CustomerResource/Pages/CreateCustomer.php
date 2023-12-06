<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\PurchasedModule;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    public $length =25;
    
    protected function afterCreate(): void
    {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $this->length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
        $record = $this->getRecord();
        $license = PurchasedModule::where('customer_id',$record->id)->get();
        $license->each(function($item) use ($randomString) {
            $item->update(['license' => $randomString]);
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
