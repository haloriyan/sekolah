<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Guru;
use App\Models\News;
use App\Models\Slideshow;
use App\Models\Unduhan;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public $datas = [];

    public function __construct()
    {
        if (env('APP_INSTALLED') != true) {
            return redirect()->route('install', 'start');
        }

        $jurusans = Gallery::where('type', 'jurusan')->get();
        $sarprases = Gallery::where('type', 'sarpras')->get();
        $ekskuls = Gallery::where('type', 'ekstrakurikuler')->get();

        $this->datas = [
            'jurusans' => $jurusans,
            'sarprases' => $sarprases,
            'ekskuls' => $ekskuls,
        ];
    }

    public function index() {
        if (env('APP_INSTALLED') != true) {
            return redirect()->route('install', 'start');
        }
        $slides = Slideshow::orderBy('priority', 'DESC')->orderBy('updated_at', 'DESC')->get();
        $galleries = GalleryImage::whereHas('gallery', function ($q) {
            $q->where('type', 'galeri');
        })->take(20)->get();

        $galleries = generateMasonry($galleries, 4);

        return view('index', [
            'datas' => $this->datas,
            'slides' => $slides,
            'galleries' => $galleries,
        ]);
    }
    public function jurusan($slug) {
        $jurusan = Gallery::where([
            ['type', 'jurusan'],
            ['slug', $slug]
        ])->with(['images'])->first();

        return view('jurusan', [
            'jurusan' => $jurusan,
            'datas' => $this->datas,
            'isWhiteHero' => true,
        ]);
    }
    public function sarpras($slug) {
        $sarpras = Gallery::where([
            ['type', 'sarpras'],
            ['slug', $slug]
        ])->with(['images'])->first();

        return view('sarpras', [
            'sarpras' => $sarpras,
            'datas' => $this->datas,
            'isWhiteHero' => true,
        ]);
    }
    public function ekskul($slug) {
        $ekskul = Gallery::where([
            ['type', 'ekstrakurikuler'],
            ['slug', $slug]
        ])->with(['images'])->first();

        return view('ekskul', [
            'ekskul' => $ekskul,
            'datas' => $this->datas,
            'isWhiteHero' => true,
        ]);
    }
    public function news() {
        return view('news', [
            'datas' => $this->datas,
        ]);
    }
    public function readNews($slug) {
        $data = News::where('slug', $slug);
        $news = $data->with(['admin'])->first();
        $data->increment('hit');

        return view('read', [
            'news' => $news,
            'datas' => $this->datas,
        ]);
    }
    public function sambutanKepsek() {
        return view('sambutanKepsek', [
            'datas' => $this->datas,
        ]);
    }
    public function visiMisi() {
        return view('visiMisi', [
            'datas' => $this->datas,
        ]);
    }
    public function sejarah() {
        return view('sejarah', [
            'datas' => $this->datas,
        ]);
    }
    public function gtk(Request $request) {
        $filter = [];
        if ($request->q != "") {
            array_push($filter, ['name', 'LIKE', '%'.$request->q.'%']);
        }
        $gurus = Guru::where($filter)->orderBy('created_at', 'DESC')->paginate(20);

        return view('gtk', [
            'datas' => $this->datas,
            'gurus' => $gurus,
            'request' => $request,
        ]);
    }
    public function galeri() {
        $galleries = Gallery::where('type', 'galeri')->orderBy('created_at', 'DESC')->with(['images'])->paginate(10);

        return view('galeri', [
            'datas' => $this->datas,
            'galleries' => $galleries,
        ]);
    }
    public function galeriDetail($slug) {
        $gallery = Gallery::where('slug', $slug)->with(['images'])->first();

        return view('galeriDetail', [
            'datas' => $this->datas,
            'gallery' => $gallery,
        ]);
    }
    public function alumni(Request $request) {
        $filter = [];
        if ($request->q != "") {
            array_push($filter, ['name', 'LIKE', '%'.$request->q.'%']);
        }
        $alumnis = Alumni::where($filter)->orderBy('created_at', 'DESC')->paginate(25);

        return view('alumni', [
            'datas' => $this->datas,
            'alumnis' => $alumnis,
            'request' => $request,
        ]);
    }
    public function unduhan(Request $request) {
        $filter = [];
        if ($request->q != "") {
            array_push($filter, ['title', 'LIKE', '%'.$request->q.'%']);
        }
        $files = Unduhan::where($filter)->orderBy('created_at', 'DESC')->paginate(25);

        return view('unduhan', [
            'datas' => $this->datas,
            'request' => $request,
            'files' => $files,
        ]);
    }
}
