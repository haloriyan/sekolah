<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class InstallController extends Controller
{
    public function run($step, Request $request) {
        if ($step == "credential") {
            $saveData = Admin::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);

            return redirect()->route('install', 'info');
        } else if ($step == "info") {
            $toSave = ['APP_NAME', 'SCHOOL_PHONE', 'SCHOOL_EMAIL', 'SCHOOL_ADDRESS'];

            foreach ($toSave as $item) {
                changeEnv($item, $request->{$item});
            }

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoFileName = $logo->getClientOriginalName();
                changeEnv('APP_LOGO', $logoFileName);
                $logo->move(
                    public_path('images'),
                    $logoFileName,
                );
            }

            changeEnv('APP_INSTALLED', true);
            return redirect()->route('install', 'done');
        }
    }
    public function render($step) {
        if (env('SESSION_DRIVER') != "databse") {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['class' => "AdminSeeder"]);
            Artisan::call('db:seed', ['class' => "CopySeeder"]);

            changeEnv('SESSION_DRIVER', 'database');
        }

        if ($step == "credential") {
            $admins = Admin::all(['id']);
            if ($admins->count() > 1) {
                return redirect()->route('install', 'info');
            }
        }
        $toRender = "install.".$step;
        return view($toRender);
    }
}
