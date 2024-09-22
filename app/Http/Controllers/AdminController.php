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

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
        $this->data['title'] = 'Dashboard Admin';
        $this->data['path'] = url('/file');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['c_alternatif'] = $this->c_alternatif();
        $this->data['c_nama'] = $this->c_nama();
        $this->data['c_atas'] = $this->c_atas();
        $this->data['c_bawah'] = $this->c_bawah();
        $this->data['title'] = 'Dashboard Admin';

        return view('admin/dashboard/index', $this->data);
    }

    public function alternatif()
    {
        $this->data[ 'title' ] = 'Data Jalan';
        $this->data[ 'link' ] = '/admin/alternatif';
        $this->page = '/admin/alternatif';
        $this->data['page'] = $this->page;
        return view('admin/alternatif/index', $this->data);
    }

    public function kriteria()
    {
        $this->data[ 'title' ] = 'Data Kriteria';
        $this->data[ 'link' ] = '/admin/kriteria';
        $this->page = '/admin/kriteria';
        $this->data['page'] = $this->page;
        return view('admin/kriteria/index', $this->data);
    }

    public function subkriteria($id)
    {
        $load = Kriteria::find($id);
        $this->data[ 'title' ] = 'Data Sub Kriteria ' . $load->nama;
        $this->data[ 'link' ] = '/admin/kriteria/subkriteria';
        $this->page = '/admin/kriteria/subkriteria';
        $this->data['page'] = $this->page;
        $this->data[ 'load' ] = $load;

        return view('admin/kriteria/detail', $this->data);
    }

    public function nilai_alternatif()
    {
        $kriteria = Kriteria::select('*')->get();
        $load = array();
        $this->data[ 'title' ] = 'Data Nilai Alternatif';
        $this->data[ 'link' ] = '/admin/nilai';
        $this->page = '/admin/nilai';
        $this->data['page'] = $this->page;
        $this->data['kriteria'] = $kriteria;
        foreach($kriteria as $row) {
            $this->data['C'.$row->urutan_order] = array();
        }
        foreach($kriteria as $row) {
            $subkriteria = PilihanKriteria::select('*')
            ->where('id_kriteria', $row->id_kriteria)
            ->orderBy('nilai', 'DESC')
            ->get();
            $load[] = $subkriteria;
        }
        if(count($load) == '6') {
            $this->data['C1'] = $load[0];
            $this->data['C2'] = $load[1];
            $this->data['C3'] = $load[2];
            $this->data['C4'] = $load[3];
            $this->data['C5'] = $load[4];
            $this->data['C6'] = $load[5];
        } else {
            echo '<script>alert("Data Sub Kriteria Tidak Lengkap")</script>';
        }

        return view('admin/nilai/index', $this->data);
    }

    public function rangking()
    {
        $this->data[ 'title' ] = 'Data Rangking';
        $this->data[ 'link' ] = '/admin/rangking';
        $this->page = '/admin/rangking';
        $this->data['page'] = $this->page;
        return view('admin/rangking/index', $this->data);
    }

    public function robot()
    {
        $id_alternatif = 30;

        $data = array(
            '2',
            '3',
            '2',
            '2',
            '1'
        );

        $temp = array();
        $kriteria = Kriteria::select('*')->get();
        $i = 0;
        foreach($kriteria as $arr) {
            $temp[]['id_kriteria'] = $arr->id_kriteria;
        }

        $temp[0]['nilai'] = $data[0];
        $temp[1]['nilai'] = $data[1];
        $temp[2]['nilai'] = $data[2];
        $temp[3]['nilai'] = $data[3];
        $temp[4]['nilai'] = $data[4];

        for($i = 0;$i < count($kriteria);$i++) {
            $insert = [
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $temp[$i]['id_kriteria'],
                'nilai' => $temp[$i]['nilai'],
                'updated_at' => now()
            ];
            $load = NilaiAlternatif::select('*')
                    ->where('id_kriteria', $temp[$i]['id_kriteria'])
                    ->where('id_alternatif', $id_alternatif)->first();
            if(empty($load)) {
                DB::table('nilai_alternatif')->insert($insert);
            } else {
                $rows = NilaiAlternatif::find($load->id_nilai_alternatif);
                $rows->update($insert);
            }
        }

        return print_r($data);
    }

    public function c_alternatif()
    {
        $data = Alternatif::select('*')->get()->count();

        return $data;
    }


    public function c_nama()
    {
        $data = $this->json();

        if(empty($data)) {
            return 'Tidak Ada';
        }
        return $data[0]['nama_alternatif'];
    }

    public function c_atas()
    {
        $data = $this->json();

        if(empty($data)) {
            return 'Tidak Ada';
        }
        return $data[0]['nilai'];
    }

    public function c_bawah()
    {
        $data = $this->json();
        $result = end($data);

        if(empty($data)) {
            return 'Tidak Ada';
        }
        return $result['nilai'];
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
        }

        $hasil = $data->toArray();

        array_multisort(array_column($hasil, 'nilai'), SORT_DESC, $hasil);

        return $hasil;
    }
}
