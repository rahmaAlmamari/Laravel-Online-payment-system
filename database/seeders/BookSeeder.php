<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\book;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $record = new book();
        $record->book_name = Str::random(10);
        $record->book_price = rand(1,100);
        $record->save();
    }
}
