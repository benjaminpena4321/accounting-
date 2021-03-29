<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=> 'Benj',
            'email'=> 'benjaminpena1233@gmail.com',
            'password'=>'123456789'
        ]);
    }
}
