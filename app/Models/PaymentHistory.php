<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'module_management_id', 'payment_id', 'payment_date', 'amount', 'provider', 'method'];

    // Enums
    const PAYMENT_METHOD = ['cash', 'card'];

    // Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    // Relationship with Module
    public function ModuleManagements()
    {
        return $this->belongsTo(ModuleManagement::class,'module_management_id');
    }
}
