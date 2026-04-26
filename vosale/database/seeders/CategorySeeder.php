<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Bar
        $bar = ['Minuman', 'Sirup & Saus', 'Snack', 'Kopi & Teh', 'Susu & Krimer'];
        foreach ($bar as $name) {
            Category::create(['name' => $name, 'module' => 'bar']);
        }

        // Kategori Kitchen
        $kitchen = ['Bahan Pokok', 'Bumbu & Rempah', 'Sayuran', 'Daging & Protein', 'Minyak & Lemak'];
        foreach ($kitchen as $name) {
            Category::create(['name' => $name, 'module' => 'kitchen']);
        }
    }
}