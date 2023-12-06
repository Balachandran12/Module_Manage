<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedModule extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'module_management_id', 'version', 'date_of_purchased', 'license'];

    // Enums
    // const LICENSE_STATUS = ['active', 'pending'];

    // Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship with Module
    public function ModuleManagement()
    {
        return $this->belongsTo(ModuleManagement::class,'module_management_id');
    }
}
