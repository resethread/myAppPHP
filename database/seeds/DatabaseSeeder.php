<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(StarSeeder::class);

        Model::reguard();
    }
}

class AppSeeder extends Seeder {

    public function run() {

        DB::table('users')->delete();
        DB::table('users')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'test',
                    'email' => 'test@test.com',
                    'password' => bcrypt('testtest'),
                    'status' => 'user'
                ],
                [
                    'id' => 2,
                    'name' => 'admin',
                    'email' => 'admin@admin.com',
                    'password' => bcrypt('admin'),
                    'status' => 'admin',
                ]
              
            ]
        );
    }
}

class StarSeeder extends Seeder {

    public function run() {

        DB::table('stars')->delete();
        DB::table('stars')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'teststar1',
                    'image' => '/users_content/stars/test.jpg'
                ]
            ]
        );
    }
}
