<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ['board','council','committee','department','directorate','school'];
        $year = rand(2019, 2021);
        $month = rand(1, 12);
        $day = rand(1, 28);
        $date = Carbon::create($year,$month ,$day , 0, 0, 0);

        DB::table('meetings')->insert([
            'meeting_title' => Str::random(10),
            'meeting_description' => Str::random(100),
            'meeting_type' => Arr::random($type),
            'meeting_date' => $date->format('Y-m-d'),
            'user_id' => rand(1001,1017),
        ]);
    }
}
