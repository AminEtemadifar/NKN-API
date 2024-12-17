<?php

namespace Database\Seeders;

use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxonomies = json_decode(file_get_contents(storage_path('app/data/taxonomies.json')), true);
        foreach ($taxonomies as $taxonomy) {
            Taxonomy::create($taxonomy);
        }
    }
}
