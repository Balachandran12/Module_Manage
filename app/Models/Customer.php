<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company_name', 'base_versions_id', 'email_address','is_active'];

    // Relationship with PurchasedModules
    public function purchasedModules()
    {
        return $this->hasOne(PurchasedModule::class);
    }

    public function baseVersions()
    {
        return $this->belongsTo(BaseVersion::class, 'base_versions_id');
    }
    // Relationship with PaymentHistory
    public function paymentHistories()
    {
        return $this->hasOne(PaymentHistory::class);
    }
}
