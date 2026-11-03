<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // EKLENEN KISIM: Hangi sütunların dışarıdan doldurulabileceğini belirtiyoruz
    protected $fillable = [
        'key',
        'value',
    ];
}