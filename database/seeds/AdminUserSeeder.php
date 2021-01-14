<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'first_name' => 'Mohomed',
            'last_name' => 'Rimshan',
            'email' => 'ymrimshan@gmail.com',
            'password' => bcrypt('1qaz2wsx@'),
            'contact_number' => '0766397227',
            'is_active' => true
        ]);
    }
}
