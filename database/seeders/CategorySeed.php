<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'title' => 'Livros',
        ]);
        Category::create([
            'title' => 'Música',
        ]);
        Category::create([
            'title' => 'Filmes',
        ]);
    }
}
