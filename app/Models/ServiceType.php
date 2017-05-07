<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 */
class ServiceType extends Model
{
    protected $table = 'service_types';

    public $timestamps = false;

    protected $fillable = [
        'description',
    ];

    protected $guarded = [];

    public function getServicesListAttribute($value)
    {
        $services = ServiceType::orderBy('description')->get();
        return $services;
    }
}