<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('patients')->insert([
                'title' => $faker->title(),
                'first_name' => $faker->firstName(),
                'middle_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'social_security_no' => $faker->ssn(),
                'medical_no' => $faker->uuid(),
                'age' => $faker->numberBetween(18, 90),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'date_of_birth' => $faker->date(),
                'race' => $faker->word(),
                'ethnicity' => $faker->word(),
                'marital_status' => $faker->randomElement(['Single', 'Married']),
                'referral_source_1' => $faker->company(),
                'referral_source_2' => $faker->word(),
                'financial_class' => $faker->word(),
                'fin_class_name' => $faker->word(),
                'doctor_name' => $faker->name(),
                'auth' => $faker->word(),
                'account_no' => $faker->uuid(),
                'admit_date' => $faker->date(),
                'disch_date' => $faker->date(),
                'adm_dx' => $faker->word(),
                'resid_military' => $faker->word(),
                'pre_admit_date' => $faker->date(),
                'service' => $faker->word(),
                'nursing_station' => $faker->word(),
                'occupation' => $faker->jobTitle(),
                'employer' => $faker->company(),
                'email' => $faker->unique()->safeEmail(),
                'other_contact_name' => $faker->name(),
                'other_contact_address' => $faker->address(),
                'other_contact_country' => $faker->country(),
                'other_contact_city' => $faker->city(),
                'other_contact_state' => $faker->state(),
                'other_contact_phone_no' => $faker->phoneNumber(),
                'other_contact_cell' => $faker->phoneNumber(),
                'relationship' => $faker->word(),
                'medical_dependency' => $faker->word(),
                'city' => $faker->city(),
                'state' => $faker->state(),
                'language' => $faker->languageCode(),
                'phone_no' => $faker->phoneNumber(),
                'zip_code' => $faker->postcode(),
                'country' => $faker->country(),
                'profile_pic' => 'placeholder.jpg',
                'status' => $faker->randomElement(['Active', 'Inactive']),
            ]);
        }
    }
}
