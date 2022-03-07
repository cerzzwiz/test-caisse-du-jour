<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Saisie;

class SaisieDetail extends Model
{
    use HasFactory;

    public $fillable = [
        'saisie_id',
        'nominal',
        'quantity',
        'block_type'
    ];

    public function saisie()
    {
        return $this->belongsTo(Saisie::class);
    }
}
