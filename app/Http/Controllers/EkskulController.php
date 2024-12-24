<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EkskulController extends Controller
{
    public function create(Request $request) {
        return view('admin.master.ekskul.create');
    }
    public function store(Request $request) {
        $saveData = Gallery::create([
            'type' => 'ekstrakurikuler',
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
                public_path('storage/foto_ekskul'),
                $fileName
            );
        }
        
        return redirect()->route('admin.master.ekskul')->with([
            'message' => "Berhasil menambahkan ekstrakurikuler baru"
        ]);
    }
    public function edit($id) {
        $data = Gallery::where('id', $id);
        $ekskul = $data->with(['images'])->first();

        return view('admin.master.ekskul.edit', [
            'ekskul' => $ekskul,
        ]);
    }
    public function update($id, Request $request) {
        $data = Gallery::where('id', $id);
        $ekskul = $data->with(['images'])->first();

        $data->update([
            'title' => $request->title,
            'description' => $request->content,
        ]);

        if ($request->imgToDelete != "") {
            $imagesToDelete = explode("||", $request->imgToDelete);
            foreach ($imagesToDelete as $item) {
                $img = GalleryImage::where('id', $item);
                $image = $img->first();
                $deleteFile = Storage::delete('public/foto_ekskul/' . $image->filename);
                $img->delete();
            }
        }

        $images = $request->file('images');
        foreach ($images as $img) {
            $fileName = rand(1111, 999)."_".$img->getClientOriginalName();

            $saveImage = GalleryImage::create([
                'gallery_id' => $ekskul->id,
                'filename' => $fileName,
                'mediaType' => $img->getClientMimeType(),
            ]);

            $img->move(
                public_path('storage/foto_ekskul'),
                $fileName
            );
        }

        return redirect()->route('admin.master.ekskul')->with([
            'message' => "Berhasil mengubah data ekstrakurikuler"
        ]);
    }
    public function delete(Request $request) {
        $data = Gallery::where('id', $request->id);
        $ekskul = $data->with(['images'])->first();

        $deleteData = $data->delete();
        foreach ($ekskul->images as $img) {
            $deleteFile = Storage::delete('public/storage/foto_ekskul/' . $img->filename);
        }

        return redirect()->route('admin.master.ekskul')->with([
            'message' => "Berhasil menghapus data ekstrakurikuler"
        ]);
    }
}
