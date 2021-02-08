<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rule::create([
            'without_login' => 5,
            'with_login' => 6,
            'on_referral' => 1,
        ]);
    }
}
