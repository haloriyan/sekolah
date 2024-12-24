<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    public function store(Request $request) {
        $toSave = [
            'name' => $request->name,
            'contact' => $request->contact,
            'angkatan' => $request->angkatan,
            'tahun_lulus' => $request->tahun_lulus,
            'melanjutkan' => $request->melanjutkan,
            'pekerjaan' => $request->pekerjaan,
            'perusahaan' => $request->perusahaan,
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFileName = $photo->getClientOriginalName();
            $photo->move(
                public_path('storage/foto_alumni'),
                $photoFileName,
            );
            $toSave['photo'] = $photoFileName;
        }

        $saveData = Alumni::create($toSave);

        return redirect()->route('admin.master.alumni')->with([
            'message' => "Berhasil menambahkan data alumni"
        ]);
    }
    public function update(Request $request) {
        $data = Alumni::where('id', $request->id);
        $alumni = $data->first();

        $toUpdate = [
            'name' => $request->name,
            'contact' => $request->contact,
            'angkatan' => $request->angkatan,
            'tahun_lulus' => $request->tahun_lulus,
            'melanjutkan' => $request->melanjutkan,
            'pekerjaan' => $request->pekerjaan,
            'perusahaan' => $request->perusahaan,
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFileName = $photo->getClientOriginalName();
            if ($alumni->photo != null) {
                $deleteOldPhoto = Storage::delete('public/foto_alumni/' . $alumni->photo);
            }
            $toUpdate['photo'] = $photoFileName;
            $photo->move(
                public_path('storage/foto_alumni'),
                $photoFileName,
            );
    
        }

        $updateData = $data->update($toUpdate);

        return redirect()->route('admin.master.alumni')->with([
            'message' => "Berhasil mengubah data alumni"
        ]);
    }
    public function delete(Request $request) {
        $data = Alumni::where('id', $request->id);
        $alumni = $data->first();
        
        $deleteData = $data->delete();
        if ($alumni->photo != null) {
            $deleteOldPhoto = Storage::delete('public/foto_alumni/' . $alumni->photo);
        }

        return redirect()->route('admin.master.alumni')->with([
            'message' => "Berhasil menghapus data alumni"
        ]);
    }
}
