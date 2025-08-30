<?php

namespace App\Jobs;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Taxonomy;
use App\Models\Term;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportDoctorJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $hospital = Hospital::where('name', $this->data['hospital'])->first();
        // Create the doctor
        $doctor = Doctor::query()->updateOrCreate(
            [
                'code' => $this->data['code'],
            ],[
            'first_name' => $this->data['first_name'],
            'last_name' => $this->data['last_name'],
            'sub_title' => $this->data['sub_title'],
            'hospital_id' => $hospital?->id,
            'gender' => $this->data['gender'],
            'status' => 1,
            'redirect' => $this->data['redirect_link'],
        ]);

        $hospital_taxonomy = Taxonomy::where('key', 'hospital')->first();
        $hospital_term = Term::query()->updateOrCreate([
            'title' => $this->data['hospital'],
            'taxonomy_id' => $hospital_taxonomy->id,
        ], [
            'slug' => preg_replace('/\s+/', '_', $this->data['hospital']),
            'is_main' => 0,
            'is_filter' => 1,
            'is_footer' => 0,
        ]);
        $doctor->terms()->attach($hospital_term->id);
        $term = Term::query()->updateOrCreate([
            'title' => $this->data['term'],
        ], [
            'slug' => preg_replace('/\s+/', '_', $this->data['term']),
            'is_main' => 1,
            'is_filter' => 1,
            'is_footer' => 1,
            'taxonomy_id' => Taxonomy::where('key', 'expertise')->first()->id,
        ]);
        $doctor->terms()->attach($term->id);
    }
}
