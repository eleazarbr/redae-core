<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'tax_id',
        'billing_address_json',
        'country',
    ];

    protected $casts = [
        'billing_address_json' => 'array',
    ];
}
