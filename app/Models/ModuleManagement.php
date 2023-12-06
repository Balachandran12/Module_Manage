<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleManagement extends Model
{
    use HasFactory;

    protected $fillable = ['modules_id', 'version', 'base_versions_id', 'released_date', 'change_log'];

    // Relationship with BaseVersion
    public function baseVersion()
    {
        return $this->belongsTo(BaseVersion::class, 'base_versions_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'modules_id');
    }

    // Relationship with PurchasedModules
    public function purchasedModules()
    {
        return $this->hasMany(PurchasedModule::class);
    }
    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class);
    }
}
