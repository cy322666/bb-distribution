<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для хранения сотрудников
 */
class Staff extends Model
{
    use HasFactory;

    const STATUS_OFF   = 0;
    const STATUS_PAUSE = 1;
    const STATUS_WORK  = 2;

    protected $fillable = [
        'name',
        'responsible_user_id',
        'status',
    ];
}




