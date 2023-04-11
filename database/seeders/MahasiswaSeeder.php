<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswas')->insert([
            'Nim'=> 126372617,
            'Nama'=> 'Aldin Ariel Pramudya',
            'Email'=> 'aldinarielpramudya@gmail.com',
            'TanggalLahir' => '23 April 2003',
            'Kelas'=> '2G',
            'Jurusan'=> 'Teknologi Informasi',
            'No_Handphone'=> '08597654738'
        ]);
    }
}
