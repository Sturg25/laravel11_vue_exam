<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Todo extends Model
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'todo';

    protected $fillable = [
        'user_id',
        'description',
        'status',
    ];
}
