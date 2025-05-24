<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create an Admin User
        User::create([
            'name' => 'Admin User',
            'fname' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@van.com',
            'password' => Hash::make('12345678'),
            'is_otp_verified' => false,
            'role' => 'admin',
            'gender' => 'male',
            'bio' => 'Administrator of the system',
            'phone' => '1234567890',
            'avatar' => null,
            'email_verified_at' => Carbon::now(),
            'dob' => '1980-01-01',
            'stripe_account_id' => "acct_1RHGjbQPESrwz7hv"
        ]);

        // Create Teacher Users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->name,
                'fname' => $faker->firstName,
                'lname' => $faker->lastName,
                'email' => "teacher{$i}@van.com",
                'password' => Hash::make('12345678'),
                'is_otp_verified' => false,
                'role' => 'teacher',
                'gender' => $faker->randomElement(['male', 'female']),
                'bio' => 'A passionate teacher',
                'phone' => $faker->unique()->phoneNumber,
                'avatar' => null,
                'email_verified_at' => Carbon::now(),
                'dob' => $faker->date('Y-m-d', '1985-12-31'),
                'stripe_account_id' => "acct_1RHGjbQPESrwz7hv"
            ]);
        }

        // Create Student Users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->name,
                'fname' => $faker->firstName,
                'lname' => $faker->lastName,
                'email' => "student{$i}@van.com",
                'password' => Hash::make('12345678'),
                'is_otp_verified' => false,
                'role' => 'student',
                'gender' => $faker->randomElement(['male', 'female']),
                'bio' => 'A dedicated student',
                'phone' => $faker->unique()->phoneNumber,
                'avatar' => null,
                'email_verified_at' => Carbon::now(),
                'dob' => $faker->date('Y-m-d', '2005-12-31'),
                'stripe_account_id' => "acct_1RHGjbQPESrwz7hv"
            ]);
        }
    }
}
