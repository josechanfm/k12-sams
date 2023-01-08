<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            YearSeeder::class,
            ConfigSeeder::class,
            StudentSeeder::class,
            SubjectSeeder::class,
            CategorySeeder::class,
            CourseSeeder::class,
            KlassSeeder::class,
            KlassStudentSeeder::class,
            LocationSeeder::class,
            SupplierSeeder::class,
            UserSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
