<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'kuma',
                'password'  => Hash::make('kumasanno')
            ],[
                'name'      => 'usagi',
                'password'  => Hash::make('usagisanno')
            ]
        ]);
    }
}
