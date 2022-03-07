<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SaisieDetail;
use App\Models\TypeOperation;

class Saisie extends Model
{
    use HasFactory;

    public $fillable = [
        'type_operation_id',
        'date',
        'comment'
    ];

    public function typeOperation()
    {
        return $this->belongsTo(TypeOperation::class, 'type_operation_id', 'id');
    }

    public function saisieDetail()
    {
        return $this->hasMany(SaisieDetail::class);
    }

    public function saisieDetailBillets()
    {
        return $this->hasMany(SaisieDetail::class)->where('block_type', 1);
    }

    public function saisieDetailPieces()
    {
        return $this->hasMany(SaisieDetail::class)->where('block_type', 2);
    }

    public function saisieDetailCentimes()
    {
        return $this->hasMany(SaisieDetail::class)->where('block_type', 3);
    }

    public function getTotalAttribute()
    {
        $total = 0;
        $saisieDetailBillets = $this->saisieDetailBillets()->get();
        if ($saisieDetailBillets) {
            foreach ($saisieDetailBillets as $detailBillet) {
                $total += ($detailBillet->nominal * $detailBillet->quantity);
            }
        }

        $saisieDetailPieces = $this->saisieDetailPieces()->get();
        if ($saisieDetailPieces) {
            foreach ($saisieDetailPieces as $detailPiece) {
                $total += ($detailPiece->nominal * $detailPiece->quantity);
            }
        }

        $saisieDetailCentimes = $this->saisieDetailCentimes()->get();
        if ($saisieDetailCentimes) {
            foreach ($saisieDetailCentimes as $detailCentime) {
                $total += ($detailCentime->nominal * $detailCentime->quantity / 100);
            }
        }

        return $total;
    }

    public function getTypeAttribute()
    {
        return TypeOperation::ACTIONS[$this->typeOperation->action];
    }
}
