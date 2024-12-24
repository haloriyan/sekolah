<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function store(Request $request) {
        $saveData = Gallery::create([
            'type' => $request->type,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.master.galeri.detail', $saveData->id);
    }
    public function detail($id) {
        $gallery = Gallery::where('id', $id)->first();
        $images = GalleryImage::where('gallery_id', $gallery->id)->orderBy('created_at', 'DESC')->get();
        
        return view('admin.master.galeri.detail', [
            'gallery' => $gallery,
            'images' => $images,
        ]);
    }
    public function update(Request $request) {
        $toUpdate = [];
        if ($request->title != "") {
            $toUpdate['title'] = $request->title;
        }
        if ($request->description != "") {
            $toUpdate['description'] = $request->description;
        }

        return response()->json(['ok']);
    }
    public function delete(Request $request) {
        $data = Gallery::where('id', $request->id);
        $gallery = $data->with(['images'])->first();

        $deleteData = $data->delete();
        foreach ($gallery->images as $img) {
            $deleteFile = Storage::delete('public/storage/gallery/' . $gallery->id . '/' . $img->filename);
        }
        
        return redirect()->route('admin.master.galeri')->with([
            'message' => "Berhasil menghapus album galeri"
        ]);
    }

    public function storeImage(Request $request) {
        $media = $request->file('media');
        $fileName = $media->getClientOriginalName();
        $galleryID = $request->gallery_id;
        
        $saveData = GalleryImage::create([
            'gallery_id' => $galleryID,
            'filename' => $fileName,
            'mediaType' => $media->getClientMimeType(),
        ]);

        $media->move(
            public_path('storage/gallery/' . $galleryID),
            $fileName,
        );

        return redirect()->route('admin.master.galeri.detail', $galleryID);
    }
    public function deleteImage($galleryID, $imageID) {
        $data = GalleryImage::where('id', $imageID);
        $image = $data->first();
        $deleteData = $data->delete();
        $deleteFile = Storage::delete('public/storage/gallery/' . $galleryID . '/' . $image->filename);
        
        return redirect()->route('admin.master.galeri.detail', $galleryID);
    }
}
