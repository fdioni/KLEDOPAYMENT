<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataPayment;

class DataPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataPayment::factory(100)->create();
    }
}
