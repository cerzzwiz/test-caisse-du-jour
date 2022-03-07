<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOperation extends Model
{
    use HasFactory;

    public $fillable = [
        'designation',
        'action'
    ];

    CONST ACTIONS = [
        1 => 'Ajoute à la caisse',
        2 => 'Retire de la caisse'
    ];
}
