<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для сбора статистики по распределениям.
 * Используется в StatisticService как источник данных
 */
class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'count_distributions',
    ];
}
