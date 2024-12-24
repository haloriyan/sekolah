<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SarprasController extends Controller
{
    public function create(Request $request) {
        return view('admin.master.sarpras.create');
    }
    public function store(Request $request) {
        $saveData = Gallery::create([
            'type' => 'sarpras',
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->content,
        ]);

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $img) {
                $fileName = rand(1111, 999)."_".$img->getClientOriginalName();

                $saveImage = GalleryImage::create([
                    'gallery_id' => $saveData->id,
                    'filename' => $fileName,
                    'mediaType' => $img->getClientMimeType(),
                ]);

                $img->move(
                    public_path('storage/foto_sarpras'),
                    $fileName
                );
            }
        }
        
        return redirect()->route('admin.master.sarpras')->with([
            'message' => "Berhasil menambahkan sarana prasarana baru"
        ]);
    }
    public function edit($id) {
        $data = Gallery::where('id', $id);
        $sarpras = $data->with(['images'])->first();

        return view('admin.master.sarpras.edit', [
            'sarpras' => $sarpras,
        ]);
    }
    public function update($id, Request $request) {
        $data = Gallery::where('id', $id);
        $sarpras = $data->with(['images'])->first();

        $data->update([
            'title' => $request->title,
            'description' => $request->content,
        ]);

        if ($request->imgToDelete != "") {
            $imagesToDelete = explode("||", $request->imgToDelete);
            foreach ($imagesToDelete as $item) {
                $img = GalleryImage::where('id', $item);
                $image = $img->first();
                $deleteFile = Storage::delete('public/foto_sarpras/' . $image->filename);
                $img->delete();
            }
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $img) {
                $fileName = rand(1111, 999)."_".$img->getClientOriginalName();

                $saveImage = GalleryImage::create([
                    'gallery_id' => $sarpras->id,
                    'filename' => $fileName,
                    'mediaType' => $img->getClientMimeType(),
                ]);

                $img->move(
                    public_path('storage/foto_sarpras'),
                    $fileName
                );
            }
        }

        return redirect()->route('admin.master.sarpras')->with([
            'message' => "Berhasil mengubah data sarana prasarana"
        ]);
    }
    public function delete(Request $request) {
        $data = Gallery::where('id', $request->id);
        $sarpras = $data->with(['images'])->first();

        $deleteData = $data->delete();
        foreach ($sarpras->images as $img) {
            $deleteFile = Storage::delete('public/storage/foto_sarpras/' . $img->filename);
        }

        return redirect()->route('admin.master.sarpras')->with([
            'message' => "Berhasil menghapus data sarana prasarana"
        ]);
    }
}
