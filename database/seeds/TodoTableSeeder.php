<?php

use App\Todo;
use Illuminate\Database\Seeder;

class TodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Todo::create([
            'name' => 'Belajar Laravel',
            'note' => 'memahami cara kerja laravel',
            'due_date' => '2020-01-24',
            'status' => false,
        ]);
        Todo::create([
            'name' => 'Belajar Vuejs',
            'note' => 'memahami cara kerja Vuejs',
            'due_date' => '2020-01-22',
            'status' => true,
        ]);
    }
}
