<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarianRoti extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_varian',
        'kategori',
        'harga_jual',
        'estimasi_keuntungan',
        'foto',
        'deskripsi',
    ];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilSawDetails()
    {
        return $this->hasMany(HasilSawDetail::class);
    }
}
