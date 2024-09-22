<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;
    protected $table = 'anggaran';
    protected $primaryKey = 'id';
    protected $fillable = ['id_alternatif','tahun','jumlah'];

    public function cari_alternatif()
    {
        return $this->belongsTo('App\Models\Alternatif', 'id_alternatif', 'id_alternatif')->withDefault([
            'nama_alternatif' => 'Null ! Cek Data',
            'alamat' => 'Null ! Cek Data'
        ]);
    }
}
