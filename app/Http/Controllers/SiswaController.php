<?php

namespace App\Http\Controllers;

use App\siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Siswa::count();
        $siswa = array();
        foreach (Siswa::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id"          => $p->id,
                "nis"               => $p->nis,
                "nama_siswa"        => $p->nama_siswa,
                "kelas"             => $p->kelas,
                "created_at"        => $p->created_at,
                "updated_at"        => $p->updated_at
            ];
            array_push($siswa, $item);
        }
        $data["siswa"] = $siswa;
        $data["status"]=1;
        return response($data);
    }

    public function store(Request $request)
    {
        $siswa = new siswa([
            'nis'         => $request->nis,
            'nama_siswa'  => $request->nama_siswa,
            'kelas'       => $request->kelas,
        ]);
        $siswa->save();
        return response($siswa);
    }

    public function show($id)
    {
        $siswa = Siswa::where('id', $id)->get();
        $dataSiswa = array();
        foreach ($siswa as $p) {
            $item = [
                "id"           => $p->id,
                "nis"          => $p->nis,
                "nama_siswa"   => $p->nama_siswa,
                "kelas"        => $p->kelas,
                // "poin"         => $p->poins,
            ];
            array_push($dataSiswa, $item);
      }
      $data["siswa"] = $dataSiswa;
      $data["status"] = 1;
      return response($data);
    }

    public function update($id, Request $request)
    {
        $siswa = Siswa::where('id', $request->id)->first();

        $siswa->nis           = $request->nis;
        $siswa->nama_siswa    = $request->nama_siswa;
        $siswa->kelas         = $request->kelas;
        $siswa->updated_at    = now()->timestamp;
        $siswa->save();

        return response()->json([
            'status' => '1',
            'message'=> 'Data Siswa Berhasil Diubah'
        ]);
    }

    public function destroy($id)
    {
        $siswa = Siswa::where('id', $id)->first();
        $siswa->delete();

        return response()->json([
            'status'  => '1',
            'message' => 'Delete Data Berhasil'
        ]);
    }
}
