<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_periode',
        'bulan',
        'tahun',
        'status',
        'catatan_manajemen',
        'tanggal_validasi',
    ];

    protected $casts = [
        'tanggal_validasi' => 'datetime',
    ];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilSawDetails()
    {
        return $this->hasMany(HasilSawDetail::class)->orderBy('ranking', 'asc');
    }
}
