<?php

use Illuminate\Database\Seeder;
use App\Models\Lecturer;
use App\Models\Expertise;

class ExpertiseSeeder extends Seeder
{
    public function run()
    {
        // 1. Create default expertises if they don't exist
        $dev = Expertise::firstOrCreate(
            ['name' => 'Software Engineering'],
            ['category' => 'dev']
        );

        $data = Expertise::firstOrCreate(
            ['name' => 'Data Science & Analytics'],
            ['category' => 'data']
        );

        $gov = Expertise::firstOrCreate(
            ['name' => 'IT Governance'],
            ['category' => 'gov']
        );

        // 2. Map existing lecturers to these expertises
        $lecturers = Lecturer::all();
        foreach ($lecturers as $lecturer) {
            // Skip if already has expertises associated
            if ($lecturer->expertises()->count() > 0) {
                continue;
            }

            $expert = strtolower($lecturer->expertise);
            
            if ($expert === 'dev' || $expert === 'software engineering') {
                $lecturer->expertises()->attach($dev->id);
            } elseif ($expert === 'data' || $expert === 'data science' || $expert === 'data science & analytics') {
                $lecturer->expertises()->attach($data->id);
            } elseif ($expert === 'gov' || $expert === 'it governance') {
                $lecturer->expertises()->attach($gov->id);
            } else {
                // If it's something custom
                $custom = Expertise::firstOrCreate(
                    ['name' => $lecturer->expertise],
                    ['category' => 'other']
                );
                $lecturer->expertises()->attach($custom->id);
            }
        }
    }
}
