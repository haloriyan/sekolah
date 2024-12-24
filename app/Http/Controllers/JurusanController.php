<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JurusanController extends Controller
{
    public function create(Request $request) {
        return view('admin.master.jurusan.create');
    }
    public function store(Request $request) {
        $saveData = Gallery::create([
            'type' => 'jurusan',
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->content,
        ]);

        $images = $request->file('images');
        foreach ($images as $img) {
            $fileName = rand(1111, 999)."_".$img->getClientOriginalName();

            $saveImage = GalleryImage::create([
                'gallery_id' => $saveData->id,
                'filename' => $fileName,
                'mediaType' => $img->getClientMimeType(),
            ]);

            $img->move(
                public_path('storage/foto_jurusan'),
                $fileName
            );
        }
        
        return redirect()->route('admin.master.jurusan')->with([
            'message' => "Berhasil menambahkan jurusan baru"
        ]);
    }
    public function edit($id) {
        $data = Gallery::where('id', $id);
        $jurusan = $data->with(['images'])->first();

        return view('admin.master.jurusan.edit', [
            'jurusan' => $jurusan,
        ]);
    }
    public function update($id, Request $request) {
        $data = Gallery::where('id', $id);
        $jurusan = $data->with(['images'])->first();

        $data->update([
            'title' => $request->title,
            'description' => $request->content,
        ]);

        if ($request->imgToDelete != "") {
            $imagesToDelete = explode("||", $request->imgToDelete);
            foreach ($imagesToDelete as $item) {
                $img = GalleryImage::where('id', $item);
                $image = $img->first();
                $deleteFile = Storage::delete('public/foto_jurusan/' . $image->filename);
                $img->delete();
            }
        }

        $images = $request->file('images');
        foreach ($images as $img) {
            $fileName = rand(1111, 999)."_".$img->getClientOriginalName();

            $saveImage = GalleryImage::create([
                'gallery_id' => $jurusan->id,
                'filename' => $fileName,
                'mediaType' => $img->getClientMimeType(),
            ]);

            $img->move(
                public_path('storage/foto_jurusan'),
                $fileName
            );
        }

        return redirect()->route('admin.master.jurusan')->with([
            'message' => "Berhasil mengubah data jurusan"
        ]);
    }
    public function delete(Request $request) {
        $data = Gallery::where('id', $request->id);
        $jurusan = $data->with(['images'])->first();

        $deleteData = $data->delete();
        foreach ($jurusan->images as $img) {
            $deleteFile = Storage::delete('public/storage/foto_jurusan/' . $img->filename);
        }

        return redirect()->route('admin.master.jurusan')->with([
            'message' => "Berhasil menghapus data jurusan"
        ]);
    }
}
