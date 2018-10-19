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
        //

        DB::table('users')->insert([

            'name'=>str_random(10),
            'role_id'=>2,
            'is_active'=>1,
            'email'=>str_random(10).'@codingfaculty.com',
            'password'=>bcrypt('secret')

        ]);

//        DB::table('posts')->insert([
//
//            'category_id'=>str_random(10),
//            'photo_id'=>2,
//            'title'=>1,
//            'body'=>str_random(10).'@codingfaculty.com',
//            'slug'=>bcrypt('secret')
//
//        ]);

    }
}
