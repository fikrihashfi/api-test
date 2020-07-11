<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\User::class)->create([
            'name' => 'transisi',
            'email' => 'admin@transisi.id',
            'email_verified_at' => now(),
            'password' => bcrypt('transisi'),
        ]);
    }
}
