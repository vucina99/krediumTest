<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Vuk',
            'last_name' => 'Zdravkovic',
            'email' => 'vukzdravkovic71@gmail.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'password' => Hash::make('kredium123')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Pera',
            'last_name' => 'Peric',
            'email' => 'pera@gmail.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'password' => Hash::make('kredium12345')
        ]);
    }
}
