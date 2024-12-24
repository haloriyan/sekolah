<?php

namespace App\Http\Controllers;

use App\Models\Unduhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnduhanController extends Controller
{
    public function store(Request $request) {
        $berkas = $request->file('berkas');
        $berkasFileName = rand(111111, 999999)."_".$berkas->getClientOriginalName();

        $saveData = Unduhan::create([
            'title' => $request->title,
            'description' => $request->description,
            'filename' => $berkasFileName,
            'mimeType' => $berkas->getMimeType(),
            'size' => $berkas->getSize(),
            'view_count' => 0,
            'download_count' => 0,
        ]);

        $berkas->move(
            public_path('storage/berkas'), $berkasFileName,
        );

        return redirect()->route('admin.master.unduhan')->with([
            'message' => "Berhasil menambahkan berkas baru"
        ]);
    }
    public function update(Request $request) {
        $data = Unduhan::where('id', $request->id);
        $file = $data->first();

        $toUpdate = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('berkas')) {
            $berkas = $request->file('berkas');
            $berkasFileName = rand(111111, 999999)."_".$berkas->getClientOriginalName();
            
            $toUpdate['filename'] = $berkasFileName;
            $toUpdate['mimeType'] = $berkas->getMimeType();
            $toUpdate['size'] = $berkas->getSize();

            $deleteOldFile = Storage::delete('public/storage/berkas/' . $file->filename);
            $berkas->move(
                public_path('storage/berkas'), $berkasFileName
            );
        }

        $updateData = $data->update($toUpdate);

        return redirect()->route('admin.master.unduhan')->with([
            'message' => "Berhasil mengubah berkas"
        ]);
    }
    public function delete(Request $request) {
        $data = Unduhan::where('id', $request->id);
        $file = $data->first();

        $deleteData = $data->delete();
        $deleteFile = Storage::delete('public/storage/berkas/' . $file->filename);

        return redirect()->route('admin.master.unduhan')->with([
            'message' => "Berhasil menghapus berkas"
        ]);
    }
    public function download(Request $request) {
        $data = Unduhan::where('id', $request->id);
        $file = $data->first();

        $data->increment('download_count');

        return response()->download(
            public_path('storage/berkas/' . $file->filename)
        );
    }
}
