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
                'user_id'   => 1,
                'name'      => 'kuma',
                'password'  => Hash::make('kumasanno')
            ],[
                'user_id'   => 2,
                'name'      => 'usagi',
                'password'  => Hash::make('usagisanno')
            ]
        ]);
    }
}
