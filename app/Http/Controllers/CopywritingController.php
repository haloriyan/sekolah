<?php

namespace App\Http\Controllers;

use App\Models\Copywriting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CopywritingController extends Controller
{
    public function update(Request $request) {
        $toUpdate = $request->to_update;

        foreach ($toUpdate as $item) {
            $contentKey = $item."_content";
            $imageKey = $item."_image";
            $content = $request->{$contentKey};

            $data = Copywriting::where('key', $item);
            $copy = $data->first();
            
            $willUpdate = ['content' => $content];

            if ($request->hasFile($imageKey)) {
                $image = $request->file($imageKey);
                $imageFileName = $image->getClientOriginalName();
                $willUpdate['image'] = $imageFileName;
                if ($copy->image != null) {
                    $deleteOld = Storage::delete('public/storage/copywriting_images/' . $copy->image);
                }
                $image->move(
                    public_path('storage/copywriting_images'),
                    $imageFileName
                );
            }

            $data->update($willUpdate);
        }

        return redirect($request->r)->with([
            'message' => $request->message,
        ]);
    }
}
