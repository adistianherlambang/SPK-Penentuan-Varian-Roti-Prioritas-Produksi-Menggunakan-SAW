<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_id',
        'varian_roti_id',
        'kriteria_id',
        'nilai',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function varianRoti()
    {
        return $this->belongsTo(VarianRoti::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
