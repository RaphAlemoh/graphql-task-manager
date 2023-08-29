<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        Category::insert([
            ['name' => 'Work',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Personal',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Urgent',  'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
