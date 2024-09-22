<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 'pengaduan';
    protected $primaryKey = 'id';
    protected $fillable = ['pelapor','deskripsi','foto','id_jalan'];

    public function cari_jalan()
    {
        return $this->belongsTo('App\Models\Alternatif', 'id_jalan', 'id_alternatif')->withDefault([
            'nama_alternatif' => 'Null ! Cek Data',
            'ruas_jalan' => 'Null ! Cek Data'
        ]);
    }

}
