<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function store(Request $request) {
        $photo = $request->file('photo');
        $photoFileName = $photo->getClientOriginalName();

        $saveData = Guru::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'nip' => $request->nip,
            'gtk' => $request->gtk,
            'photo' => $photoFileName,
        ]);

        $photo->move(
            public_path('storage/foto_gtk'),
            $photoFileName,
        );

        return redirect()->route('admin.master.guru')->with([
            'message' => "Berhasil menambahkan data GTK"
        ]);
    }
    public function update(Request $request) {
        $data = Guru::where('id', $request->id);
        $guru = $data->first();

        $toUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'gtk' => $request->gtk,
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFileName = $photo->getClientOriginalName();
            if ($guru->photo != null) {
                $deleteOldPhoto = Storage::delete('public/foto_gtk/' . $guru->photo);
            }
            $toUpdate['photo'] = $photoFileName;
            $photo->move(
                public_path('storage/foto_gtk'),
                $photoFileName,
            );
    
        }

        $updateData = $data->update($toUpdate);

        return redirect()->route('admin.master.guru')->with([
            'message' => "Berhasil mengubah data GTK"
        ]);
    }
    public function delete(Request $request) {
        $data = Guru::where('id', $request->id);
        $guru = $data->first();
        
        $deleteData = $data->delete();
        if ($guru->photo != null) {
            $deleteOldPhoto = Storage::delete('public/foto_gtk/' . $guru->photo);
        }

        return redirect()->route('admin.master.guru')->with([
            'message' => "Berhasil menghapus data GTK"
        ]);
    }
}
