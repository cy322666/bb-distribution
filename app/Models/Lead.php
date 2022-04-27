<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для хранения хуков по созданию сделок в amoCRM
 */
class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'contact_id',
        'created',
        'responsible_user_id',
        'contact_responsible_user_id',
        'contact_created',
        'is_test',
        'tags',
        'status',
    ];
}