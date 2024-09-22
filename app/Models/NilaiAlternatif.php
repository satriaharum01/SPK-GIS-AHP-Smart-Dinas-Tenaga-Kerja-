<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAlternatif extends Model
{
    use HasFactory;
    protected $table = 'nilai_alternatif';
    protected $primaryKey = 'id_nilai_alternatif';
    protected $fillable = ['id_alternatif','id_kriteria','nilai'];

    public function cari_alternatif()
    {
        return $this->belongsTo('App\Models\Alternatif', 'id_alternatif', 'id_alternatif')->withDefault([
            'nama_alternatif' => 'Null ! Cek Data',
            'alamat' => 'Null ! Cek Data'
        ]);
    }

    public function cari_kriteria()
    {
        return $this->belongsTo('App\Models\Kriteria', 'id_kriteria', 'id_kriteria')->withDefault([
            'nama' => 'Null ! Cek Data',
            'bobot' => 'Null ! Cek Data',
            'urutan_order' => 'Null ! Cek Data'
        ]);
    }
}
