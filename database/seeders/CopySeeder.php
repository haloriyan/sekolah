<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'key' => "visi",
                'content' => "Visi kami adalah"
            ],
            [
                'key' => "misi",
                'content' => "Misi kami adalah"
            ],
            [
                'key' => "sambutan_kepala_sekolah",
                'content' => "Lorem ipsum dolor sit amet"
            ],
            [
                'key' => "sejarah",
                'content' => "Lorem ipsum dolor sit amet"
            ],
            [
                'key' => "jumbo_home_title",
                'content' => "Pendidikan Berkualitas, Generasi Berkualitas"
            ],
            [
                'key' => "jumbo_home_description",
                'content' => "Siswa akan mendapatkan pendidikan yang berkualitas serta dikelilingi oleh lingkungan yang ideal untuk perkembangan terbaiknya"
            ],
        ];
        
        DB::table('copywritings')->insert($datas);
    }
}
