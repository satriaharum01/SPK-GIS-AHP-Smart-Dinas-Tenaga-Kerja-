<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;
use App\Models\PilihanKriteria;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class RangkingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //Start Controller Function
        $this->view = 'admin/rangking/index';
        $this->page = '/admin/rangking';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Rekomendasi Perbaikan Jalan';
        $this->data['path'] = url('/file');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/rangking/index', $this->data);
    }


    public function json()
    {
        $data = Alternatif::select('*')
            ->get();

        $kriteria = Kriteria::select('*')->orderby('urutan_order', 'ASC')->get();

        $count = count($kriteria);
        foreach($data as $row) {
            $row->nilai = 0;
            $cek = NilaiAlternatif::select('*')->where('id_alternatif', $row->id_alternatif)->first();
            if(!empty($cek)) {
                foreach($kriteria as $low) {
                    $max = PilihanKriteria::select('*')->where('id_kriteria', $low->id_kriteria)->max('nilai');
                    $min = PilihanKriteria::select('*')->where('id_kriteria', $low->id_kriteria)->min('nilai');
                    $nilai = NilaiAlternatif::select('*')->where('id_kriteria', $low->id_kriteria)->where('id_alternatif', $row->id_alternatif)->first();
                    if(!empty($nilai)) {
                        $row->{'C'.$low->urutan_order} = ($nilai->nilai - $min) / ($max - $min);
                    } else {
                        $row->{'C'.$low->urutan_order} = ($max - $min) / ($max - $min);
                    }
                }
            }

            foreach($kriteria as $low) {
                $row->nilai = $row->nilai + ($low->bobot * $row->{'C'.$low->urutan_order});
            }
            if($row->nilai != 0){
            $row->nilai = number_format($row->nilai,4);}
        }

        $hasil = $data->toArray();

        array_multisort(array_column($hasil, 'nilai'), SORT_DESC, $hasil);

        $i = 1;
        foreach($hasil as $row) {
            $hasil[$i - 1]['rank'] = $i;
            $i++;
        }

        array_multisort(array_column($hasil, 'id_alternatif'), SORT_DESC, $hasil);
        //return $hasil;
        return Datatables::of($hasil)
            ->addIndexColumn()
            ->make(true);
    }


    public function is_null($variable)
    {
        if($variable != '') {
            return $variable;
        } else {
            return 'Data Tidak Ditemukan';
        }
    }
}
