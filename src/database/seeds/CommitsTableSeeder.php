<?php

use Illuminate\Database\Seeder;

class CommitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Commit::class, 100)->create();
    }
}
