<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Loans;
use App\Models\LoanRepayment;

class LoanRepayControllerTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'is_admin' => 1
          ]);
        $this->user = User::factory()->create([
            'is_admin' => 0
          ]);
    }

    /************* Test Loan Schedules list as user  ***************/
    public function test_schedules_list()
    {
        $response = $this->actingAs($this->user)->post('/api/v1/loan/apply',
        ['amount'=>fake()->numberBetween(10, 10000),
        'term' => fake()->numberBetween(1, 100)
        ]);
            
        //Get the last user created
        $loan = Loans::first();
        $response = $this->actingAs($this->admin)->put('/api/v1/loan/approve/'.$loan->id);   
        $updatedloan = Loans::first();

        //Check if approved
        $this->assertEquals('APPROVED',$updatedloan->loan_status);
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)->get('/api/v1/repayloan/schedules');   
        $repayment = LoanRepayment::first();

        //Check if loan minimum due and shedule due amount is correct
        $this->assertEquals($updatedloan->minimum_due,$repayment->due_amount);
        $response->assertStatus(200);
    }

        /************* Test Loan Schedules list as user  ***************/
        public function test_schedules_repayment()
        {
            $response = $this->actingAs($this->user)->post('/api/v1/loan/apply',
            ['amount'=>fake()->numberBetween(10, 10000),
            'term' => fake()->numberBetween(1, 100)
            ]);
                
            //Get the last user created
            $loan = Loans::first();
            $response = $this->actingAs($this->admin)->put('/api/v1/loan/approve/'.$loan->id);   
            $updatedloan = Loans::first();
    
            //Check if approved
            $this->assertEquals('APPROVED',$updatedloan->loan_status);
            $response->assertStatus(200);


            $repayment_id = LoanRepayment::first();
            $response = $this->actingAs($this->user)->put('/api/v1/repayloan/payment/'.$repayment_id->id,['amount' => $updatedloan->minimum_due]);   

            $repayment = LoanRepayment::first();
            //Check if loan minimum due and shedule due amount is correct
            $this->assertEquals('PAID',$repayment->status);
            $response->assertStatus(200);
        }
}
