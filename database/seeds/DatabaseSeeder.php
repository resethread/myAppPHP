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

        $this->call(AppSeeder::class);

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
                    'password' => bcrypt('testtest')
                ],
                [
                    'id' => 2,
                    'name' => 'test2',
                    'email' => 'test2@test.com',
                    'password' => bcrypt('testtest2')
                ],
                [
                    'id' => 3,
                    'name' => 'test3',
                    'email' => 'test32@test.com',
                    'password' => bcrypt('testtest3')
                ]
            ]
        );

        DB::table('videos')->delete();
        DB::table('videos')->insert(
            [
                [
                    'name' => 'lorem ipsum',
                    'slug' => 'lorem-ipsum',
                    'user_id' => 1
                ]
            ]
        );
    }
}
