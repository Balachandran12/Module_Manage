<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseVersion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'update_date', 'change_log'];

    public function modules()
    {
        return $this->hasMany(Module::class, 'base_versions_id');
    }
    public function customer()
    {
        return $this->hasMany(Customer::class, 'base_versions_id');
    }
}
