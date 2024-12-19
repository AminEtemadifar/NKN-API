<?php

namespace Database\Seeders;

use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terms = json_decode(file_get_contents(storage_path('app/data/terms.json')), true);
        foreach ($terms as $term) {
            $taxonomy = Taxonomy::where('key', $term['taxonomy_key'])->first();
            unset($term['taxonomy_key']);
            $taxonomy->terms()->create($term);
        }
    }
}
