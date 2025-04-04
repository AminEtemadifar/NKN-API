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
        $doctor = Doctor::create([
            'first_name' => $this->data['first_name'],
            'last_name' => $this->data['last_name'],
            'code' => $this->data['code'],
            'sub_title' => $this->data['sub_title'],
            'hospital_id' => $hospital?->id,
            'gender' => 'male',
            'status' => 1,
            'redirect' => 'https://pa.nikan365.ir/main/doctors?turnGroupId=0&turnGeneralTypeId=0',
        ]);

        $term = Term::query()->firstOrCreate([
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
