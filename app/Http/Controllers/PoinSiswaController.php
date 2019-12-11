<?php

namespace App\Http\Controllers;

use App\Poin_Siswa;
use App\Pelanggaran;
use App\User;
use App\Siswa;  
use Illuminate\Http\Request;

class PoinSiswaController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Poin_Siswa::count();
        $poin = array();
        foreach (Poin_Siswa::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id"              => $p->id,
                "id_siswa"        => $p->id_siswa,
                "nis"             => $p->siswas->nis,
                "nama_siswa"      => $p->siswas->nama_siswa,
                "kelas"           => $p->siswas->kelas,
                "id_pelanggaran"  => $p->id_pelanggaran,
                "keterangan"      => $p->keterangan,
                "kategori"        => $p->pelanggarans->kategori,
                "poin_siswa"      => $p->pelanggarans->poin,
                "tanggal"         => $p->tanggal,
            ];
            array_push($poin, $item);
        }
        $data["poin"] = $poin;
        $data["status"] = 1;
        return response($data);
    }

    public function store(Request $request)
    {
        $poin_siswa = new Poin_Siswa([
            'id_siswa' => $request->id_siswa,
            'id_pelanggaran' => $request->id_pelanggaran,
            'tanggal' => now(),
            'keterangan' => $request->keterangan,
        ]);
        $poin_siswa->save();
        return response()->json([
            'status' => '1',
            'message'=> 'Data Poin Pelanggaran Berhasil Ditambahkan'
        ]);
    }

    public function detail($id)
    {
        $data["count"] = Poin_Siswa::count();
        $poin = Poin_Siswa::where('id_siswa', $id)->get();
        $poin_siswa = array();
        foreach ($poin as $p) {
            $item = [
                "id"              => $p->id,
                "id_siswa"        => $p->id_siswa,
                "nis"             => $p->siswas->nis,
                "nama_siswa"      => $p->siswas->nama_siswa,
                "kelas"           => $p->siswas->kelas,
                "id_pelanggaran"  => $p->id_pelanggaran,
                "keterangan"      => $p->keterangan,
                "kategori"        => $p->pelanggarans->kategori,
                "poin_siswa"      => $p->pelanggarans->poin,
                "tanggal"         => $p->tanggal,
            ];
            array_push($poin_siswa, $item);
        }
        $data["poin"] = $poin_siswa;
        $data["status"] = 1;
        return response ($data);
    }

    public function update($id, Request $request)
    {
        $poin = Poin_Siswa::where('id', $id)->first();

        $poin->id_siswa = $request->id_siswa;
        $poin->id_pelanggaran = $request->id_pelanggaran;
        $poin->keterangan = $request->keterangan;
        $poin->updated_at = now()->timestamp;
        $poin->save();

        return response($poin);
    }
    public function find(Request $request) {
        $find = $request->find;
        $db_poin = Poin_siswa::with('pelanggarans')->whereHas('siswas',function ($query) use ($find) {
            $query->where("nama_siswa", "like", "%$find%");});
            $detail = array();
            foreach ($db_poin->get() as $p) {
                $item = [
                    "tanggal"   => $p->tanggal,
                    "nama_pelanggaran" => $p->pelanggarans->nama_pelanggaran,
                    "kategori" => $p->pelanggarans->kategori,
                    "poin" => $p->pelanggarans->poin,
                ];
                array_push($detail, $item);
            }
            $data   = $db_poin->first();
            $nis = $data->siswas->nis;
            $nama_siswa = $data->siswas->nama_siswa;
            $kelas = $data->siswas->kelas;
            $status = 1;
            return response()->json(compact('nis','nama_siswa','kelas','detail'));
    }
    public function destroy($id)
    {
        $poin = Poin_Siswa::where('id', $id)->first();
        $poin->delete();
        return response()->json([
            'status' => '1',
            'message'=> 'Data Poin Pelanggaran Berhasil Dihapus'
        ]);
    }
    public function dashboard() {
        $jumlah_siswa   = Siswa::count();
        $jumlah_petugas = User::count();
        $jumlah_data_pelanggaran = Poin_Siswa::count();
        $pelanggaran_hari_ini   =Poin_Siswa::whereDate('tanggal', '=', date('Y-m-d'))->count();
        return response()->json(compact('jumlah_siswa','jumlah_petugas','jumlah_data_pelanggaran','pelanggaran_hari_ini'));
    }
}
