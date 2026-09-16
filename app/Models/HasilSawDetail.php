<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilSawDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_id',
        'varian_roti_id',
        'nilai_preferensi',
        'ranking',
        'rekomendasi',
        'catatan',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function varianRoti()
    {
        return $this->belongsTo(VarianRoti::class);
    }
}
