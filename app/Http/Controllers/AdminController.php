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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function install() {
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', ['class' => "AdminSeeder"]);
        Artisan::call('db:seed', ['class' => "CopySeeder"]);

        changeEnv('SESSION_DRIVER', 'database');

        return redirect()->route('admin.login');
    }
    public function login(Request $request) {
        if ($request->method() == "POST") {
            $loggingIn = Auth::guard('admin')->attempt([
                'username' => $request->username,
                'password' => $request->password,
            ]);

            if ($loggingIn) {
                $redirectTo = $request->r == "" ? route('admin.dashboard') : $request->r;
                return redirect($redirectTo);
            } else {
                return redirect()->route('admin.login')->withErrors(['Kombinasi username dan password tidak tepat']);
            }
        } else {
            $message = Session::get('message');

            return view('admin.login', [
                'request' => $request,
                'message' => $message,
            ]);
        }
    }
    public function logout() {
        $loggingOut = Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with([
            'message' => "Berhasil logout"
        ]);
    }
    
    public function dashboard(Request $request) {
        $myData = me();
        $guru_count = Guru::all(['id'])->count();
        $jurusan_count = Gallery::where('type', 'jurusan')->get(['id'])->count();
        $ekskul_count = Gallery::where('type', 'ekstrakurikuler')->get(['id'])->count();
        $beritas = News::orderBy('created_at', 'DESC')->take(5)->get();
        $berkas = Unduhan::all(['id'])->count();
        $images = GalleryImage::whereHas('gallery', function ($q) {
            $q->where('type', 'galeri');
        })->take(10)->get();
        $images = generateMasonry($images, 3);

        return view('admin.dashboard', [
            'myData' => $myData,
            'beritas' => $beritas,
            'images' => $images,
            'guru_count' => $guru_count,
            'jurusan_count' => $jurusan_count,
            'ekskul_count' => $ekskul_count,
            'berkas_count' => $berkas,
        ]);
    }
    public function admin(Request $request) {
        $filter = [];
        $message = Session::get('message');
        if  ($request->q != "") {
            array_push($filter, ['name', 'LIKE', '%'.$request->q.'%']);
        }
        $admins = Admin::where($filter)->paginate(15);

        return view('admin.admin', [
            'admins' => $admins,
            'message' => $message,
            'request' => $request,
        ]);
    }
    public function store(Request $request) {
        $saveData = Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => "administrator"
        ]);

        return redirect()->route('admin.admin')->with([
            'message' => "Berhasil menambahkan admin baru"
        ]);
    }
    public function update(Request $request) {
        $me = me();
        $toUpdate = [
            'name' => $request->name,
            'username' => $request->username,
        ];

        if ($request->password != "") {
            $toUpdate['password'] = bcrypt($request->password);
        }

        $updateData = Admin::where('id', $request->id)->update($toUpdate);

        if ($me->id == $request->id && $toUpdate['password']) {
            $loggingOut = Auth::guard('admin')->logout();

            return redirect()->route('admin.login')->with([
                'message' => "Mohon login kembali menggunakan password baru"
            ]);
        }
        
        return redirect()->route('admin.admin')->with([
            'message' => "Berhasil mengubah data admin"
        ]);
    }
    public function delete(Request $request) {
        $deleteData = Admin::where('id', $request->id)->delete();

        return redirect()->route('admin.admin')->with([
            'message' => "Berhasil menghapus admin"
        ]);
    }

    public function news(Request $request) {
        $myData = Auth::guard('admin')->user();
        $posts = News::orderBy('created_at', 'DESC')->paginate(20);
        $message = Session::get('message');

        return view('admin.news.index', [
            'myData' => $myData,
            'posts' => $posts,
            'message' => $message,
        ]);
    }
    public function guru(Request $request) {
        $message = Session::get('message');
        $filter = [];
        if ($request->q != "") {
            array_push($filter, ['name', 'LIKE', '%'.$request->q.'%']);
        }
        $gurus = Guru::where($filter)->orderBy('created_at', 'DESC')->paginate(20);

        return view('admin.master.guru', [
            'message' => $message,
            'request' => $request,
            'gurus' => $gurus,
        ]);
    }
    public function alumni(Request $request) {
        $message = Session::get('message');
        $filter = [];
        if ($request->q != "") {
            array_push($filter, ['name', 'LIKE', '%'.$request->q.'%']);
        }
        $alumnis = Alumni::where($filter)->orderBy('created_at', 'DESC')->paginate(20);

        return view('admin.master.alumni', [
            'message' => $message,
            'request' => $request,
            'alumnis' => $alumnis,
        ]);
    }
    public function galeri(Request $request) {
        $message = Session::get('message');
        $galleries = Gallery::where('type', 'galeri')
        ->orderBy('created_at', 'DESC')->with(['image'])->paginate(25);

        return view('admin.master.galeri.index', [
            'message' => $message,
            'request' => $request,
            'galleries' => $galleries,
        ]);
    }
    public function ekskul(Request $request) {
        $message = Session::get('message');
        $ekskuls = Gallery::where('type', 'ekstrakurikuler')
        ->orderBy('created_at', 'DESC')->with(['image'])->paginate(25);

        return view('admin.master.ekskul.index', [
            'message' => $message,
            'request' => $request,
            'ekskuls' => $ekskuls,
        ]);
    }
    public function jurusan(Request $request) {
        $message = Session::get('message');
        $jurusans = Gallery::where('type', 'jurusan')
        ->orderBy('created_at', 'DESC')->with(['image'])->paginate(25);

        return view('admin.master.jurusan.index', [
            'message' => $message,
            'request' => $request,
            'jurusans' => $jurusans,
        ]);
    }
    public function sarpras(Request $request) {
        $message = Session::get('message');
        $sarprases = Gallery::where('type', 'sarpras')
        ->orderBy('created_at', 'DESC')->with(['image'])->paginate(25);

        return view('admin.master.sarpras.index', [
            'message' => $message,
            'request' => $request,
            'sarprases' => $sarprases,
        ]);
    }

    public function visiMisi(Request $request) {
        $message = Session::get('message');
        $visi = Copywriting::where('key', 'visi')->first();
        $misi = Copywriting::where('key', 'misi')->first();

        return view('admin.content.visiMisi', [
            'message' => $message,
            'request' => $request,
            'visi' => $visi,
            'misi' => $misi,
        ]);
    }
    public function sejarah(Request $request) {
        $message = Session::get('message');
        $sejarah = Copywriting::where('key', 'sejarah')->first();

        return view('admin.content.sejarah', [
            'message' => $message,
            'request' => $request,
        ]);
    }
    public function sambutanKepsek(Request $request) {
        $message = Session::get('message');
        $sambutan = Copywriting::where('key', 'sambutan_kepala_sekolah')->first();

        return view('admin.content.sambutanKepsek', [
            'message' => $message,
            'request' => $request,
            'sambutan' => $sambutan,
        ]);
    }

    public function basicSettings() {
        $message = Session::get('message');

        return view('admin.settings.basic', [
            'message' => $message,
        ]);
    }
    public function saveBasicSettings(Request $request) {
        $toSave = ['APP_NAME', 'WARNA_UTAMA', 'SCHOOL_PHONE', 'SCHOOL_EMAIL', 'SCHOOL_ADDRESS'];

        foreach ($toSave as $item) {
            Log::info('changing ' . $item . " to " . $request->{$item});
            changeEnv($item, $request->{$item});
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoFileName = $logo->getClientOriginalName();
            $removeOldLogo = Storage::delete('public/images/' . env('APP_LOGO'));
            changeEnv('APP_LOGO', $logoFileName);
            $logo->move(
                public_path('images'),
                $logoFileName,
            );
        }

        return redirect()->route('admin.settings.basic')->with([
            'message' => "Berhasil menyimpan perubahan"
        ]);
    }
    public function slideshow() {
        $message = Session::get('message');
        $slides = Slideshow::orderBy('priority', 'DESC')->orderBy('updated_at', 'DESC')->get();

        return view('admin.settings.slideshow', [
            'message' => $message,
            'slides' => $slides,
        ]);
    }
    public function backup() {
        return view('admin.settings.backup');
    }

    public function unduhan(Request $request) {
        $message = Session::get('message');
        $files = Unduhan::orderBy('created_at', 'DESC')->paginate(25);

        return view('admin.master.unduhan', [
            'message' => $message,
            'request' => $request,
            'files' => $files,
        ]);
    }

}
