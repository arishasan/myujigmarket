<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Session;

class DashboardModel extends Model
{
    use HasFactory;

    static function getChartJmlTransaksi($tahun, $bulan){

        $begin = date('Y-m-01', strtotime($tahun.'-'.$bulan));
        $end = date('Y-m-t', strtotime($tahun.'-'.$bulan));

        $begin = new DateTime( $begin );
        $end = new DateTime( $end );

        $temporary = array();

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            
            $tgl = $i->format("Y-m-d");
            $hari = $i->format("d");
            $wei = $i->format("m-Y");
            
            $push = array(
                'label' => $hari,
                'jml' => TransaksiModel::where('tgl_transaksi', $tgl)->count()
            );

            array_push($temporary, $push);
            
        }

        return $temporary;

    }

    static function getChartMetodeBayar($tahun, $bulan){

        $temporary = array();
        
        $push = array(
            'label' => 'TRANSFER',
            'jml' => TransaksiModel::where(DB::raw('MONTH(tgl_transaksi)'), $bulan)->where(DB::raw('YEAR(tgl_transaksi)'), $tahun)->where('metode_bayar', 'TRANSFER')->count(),
        );
        array_push($temporary, $push);

        $push = array(
            'label' => 'COD',
            'jml' => TransaksiModel::where(DB::raw('MONTH(tgl_transaksi)'), $bulan)->where(DB::raw('YEAR(tgl_transaksi)'), $tahun)->where('metode_bayar', 'COD')->count(),
        );
        array_push($temporary, $push);

        $push = array(
            'label' => 'DATANG_LANGSUNG',
            'jml' => TransaksiModel::where(DB::raw('MONTH(tgl_transaksi)'), $bulan)->where(DB::raw('YEAR(tgl_transaksi)'), $tahun)->where('metode_bayar', 'DATANG_LANGSUNG')->count(),
        );
        array_push($temporary, $push);

        return $temporary;

    }

}
