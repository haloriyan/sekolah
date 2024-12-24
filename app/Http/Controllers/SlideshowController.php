<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    public function priority($id, $action) {
        $data = Slideshow::where('id', $id);
        $slide = $data->first();

        if ($action == "increase") {
            $data->increment('priority');
        } else {
            if ($slide->priority > 0) {
                $data->decrement('priority');
            } else {
                $data->update(['priority' => 0]);
            }
        }

        return redirect()->route('admin.settings.slideshow');
    }
    public function store(Request $request) {
        $image = $request->file('image');
        $imageFileName = rand(1111, 9999)."_".$image->getClientOriginalName();

        $saveData = Slideshow::create([
            'image' => $imageFileName,
            'title' => $request->title,
            'description' => $request->description,
            'link_one' => $request->link_one,
            'link_two' => $request->link_two,
            'priority' => 0,
        ]);

        $image->move(
            public_path('storage/slideshow_images'),
            $imageFileName
        );

        return redirect()->route('admin.settings.slideshow')->with([
            'message' => "Berhasil menambahkan slide baru"
        ]);
    }
    public function update(Request $request) {
        $data = Slideshow::where('id', $request->id);
        $slide = $data->first();
        $toUpdate = [
            'title' => $request->title,
            'description' => $request->description,
            'link_one' => $request->link_one,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFileName = rand(1111, 9999)."_".$image->getClientOriginalName();
            $toUpdate['image'] = $imageFileName;
            $deleteOld = Storage::delete('public/storage/slideshow_images/' . $slide->image);
            $image->move(
                public_path('storage/slideshow_images'),
                $imageFileName
            );
        }

        $updateData = $data->update($toUpdate);

        return redirect()->route('admin.settings.slideshow')->with([
            'message' => "Berhasil mengubah slide"
        ]);
    }
    public function delete(Request $request) {
        $data = Slideshow::where('id', $request->id);
        $slide = $data->first();

        $deleteData = $data->delete();
        $deleteFile = Storage::delete('public/storage/slideshow_images/' . $slide->image);

        return redirect()->route('admin.settings.slideshow')->with([
            'message' => "Berhasil menghapus slide"
        ]);
    }
}
