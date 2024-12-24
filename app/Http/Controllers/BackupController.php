<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Copywriting;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Guru;
use App\Models\News;
use App\Models\Slideshow;
use App\Models\Unduhan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupController extends Controller
{
    public $metadata;

    public function __construct()
    {
        $this->metadata = [
            [
                'path' => public_path("backup/gurus.json"),
                'model' => new Guru(),
            ],
            [
                'path' => public_path("backup/alumnis.json"),
                'model' => new Alumni(),
            ],
            [
                'path' => public_path("backup/unduhans.json"),
                'model' => new Unduhan(),
            ],
            [
                'path' => public_path("backup/news.json"),
                'model' => new News(),
            ],
            [
                'path' => public_path("backup/slideshow.json"),
                'model' => new Slideshow(),
            ],
            [
                'path' => public_path("backup/copywritings.json"),
                'model' => new Copywriting(),
            ],
            [
                'path' => public_path("backup/galleries.json"),
                'model' => new Gallery(),
            ],
            [
                'path' => public_path("backup/gallery_images.json"),
                'model' => new GalleryImage(),
            ],
        ];
    }
    public function backup() {

        foreach ($this->metadata as $data) {
            if (!file_exists(public_path("backup"))) {
                File::makeDirectory(
                    public_path("backup")
                );
            }

            File::put($data['path'], $data['model']->all()->toJson());
        }

        $zip = new ZipArchive;
        $zipFilePath = public_path('backup/storage.zip');
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Add files to the zip archive
            $files = File::allFiles(public_path('storage'));
            foreach ($files as $file) {
                // $zip->addFile($file->getRealPath(), $file->getFilename());
                $relativePath = str_replace(public_path('storage') . '/', '', $file->getPathname());
                $zip->addFile($file->getRealPath(), $relativePath);
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        $back = new ZipArchive;
        $backupFilePath = public_path('backup-' . Carbon::now()->format('Y-m-d-H-i-s') . ".zip");
        if ($back->open($backupFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = File::allFiles(public_path('backup'));
            foreach ($files as $file) {
                $back->addFile($file->getRealPath(), $file->getFilename());
            }
            $back->close();
        }

        File::deleteDirectory(public_path('backup'));

        return response()->download($backupFilePath)->deleteFileAfterSend(true);
    }
    public function restore(Request $request) {
        $zipFile = $request->file('file');
        $extractionPath = public_path('backup');

        $zip = new ZipArchive;
        if ($zip->open($zipFile->getRealPath()) === true) {
            $zip->extractTo($extractionPath);
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to open the ZIP file'], 500);
        }

        if (!file_exists(public_path('backup/storage'))) {
            File::makeDirectory(public_path('backup/storage'), 0755);
        }
        $storageExtractionPath = public_path('backup/storage/');
        $storageZipFile = public_path('backup/storage.zip');
        $storageZip = new ZipArchive;
        if ($storageZip->open($storageZipFile) === true) {
            $storageZip->extractTo($storageExtractionPath);
            $storageZip->close();
        }

        File::copyDirectory(
            public_path('backup/storage'),
            storage_path('app/public')
        );

        foreach (array_reverse($this->metadata) as $data) {
            if ($data['model']->all()->count() > 0) {
                $data['model']->truncate();
            }
        }
        foreach ($this->metadata as $data) {
            $collections = json_decode(file_get_contents($data['path']), true);
            $data['model']->insert($collections);
        }

        return redirect()->route('admin.settings.backup')->with([
            'message' => "Data berhasil dipulihkan"
        ]);
    }
}
