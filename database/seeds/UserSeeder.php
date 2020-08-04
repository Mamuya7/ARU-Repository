<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = rand(2007,2020);
        $sex = ["female","male"];
        $lname = Str::random(6);

        DB::table('users')->insert([
            'first_name' => Str::random(6),
            'last_name' => $lname,
            'username' => $lname."/1000"."/S".$year,
            'gender' => Arr::random($sex),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'department_id' => rand(1,12)
        ]);
        
        // factory(App\User::class, 50)->create()->each(function ($user) {
        //     // $user->posts()->save(factory(App\Post::class)->make());
        // });
    }
}
