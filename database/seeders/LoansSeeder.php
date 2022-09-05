<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Loans;
class LoansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Loan using seeder
        $loans = [
            ['user_id'=>2,'amount'=>'10000','scheduled_terms'=>'3'],
        ];

        Loans::insert($loans);
    }
}
