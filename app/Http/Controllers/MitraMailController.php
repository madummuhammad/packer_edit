<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Mail\MitraMail;
use Illuminate\Support\Facades\Mail;

class MitraMailController extends Controller
{
    public function index(request $request)
    {
        $phone_number=preg_replace('/^0/','', $request->phone);

        $number='62'.$phone_number;

        $details = [
            'Nama' => $request->name,
            'Nomor_hp' => $number,
            'Alamat_gudang' => $request->warehouse_address,
            'Luas_gudang' => $request->warehouse_area,
            'Fasilitas_gudang' => $request->warehouse_facility,
            'Akses_kendaraan' => $request->warehouse_vehicle,
            'Tipe_gudang' => $request->warehouse_type,
            'Bebas_banjir' => $request->is_flood_free,
            'Bebas_parkir' => $request->is_parking_free,
            'Kepemilikan_gudang' => $request->warehouse_ownership
        ];

        if ($request->warehouse_facility==null OR $request->warehouse_vehicle==null OR $request->warehouse_type==null OR $request->is_flood_free==null OR $request->is_parking_free==null OR $request->warehouse_ownership==null) {
            $request->session()->flash('error', 'Gagal mengirim email!! Data harus diisi semua..');
            return redirect('/mitra-gudang');
        } else {
            Mail::to("gudangsolusibersama@gmail.com")->send(new MitraMail($details));
            $request->session()->flash('message', 'Data Kamu udah kami terima, akan kami hubungi segera, Mohon tunggu sebentar..');
            return redirect('/mitra-gudang');
        }

    }
}
