<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Loans;

class LoanControllerTest extends TestCase
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

    /************* Test Validation Loan Request  ***************/
    public function test_validation_loan_request()
    {
        $response = $this->actingAs($this->user)->postJson('/api/v1/loan/apply',[]);
        $response->assertStatus(310)
            ->assertJson([
                "message"=>"There is an error on validating the request",
                'data'    => [
                    'amount' => ['The amount field is required.'],
                    'term' => ['The term field is required.']
                ]
            ]);
    }

    /************* Test Validation Loan Creation  ***************/
    public function test_customer_loan()
    {
        $response = $this->actingAs($this->user)->post('/api/v1/loan/apply',
                    ['amount'=>fake()->numberBetween(10, 10000),
                    'term' => fake()->numberBetween(1, 100)
                ]);
                
        //Get the last user created
        $loan = Loans::first();

        //We only have one Loan 
        $this->assertEquals(1,Loans::count());

        $response->assertStatus(200);
    }

    /************* Test Loan List ***************/
    public function test_loan_list()
    {
        $response = $this->actingAs($this->user)->get('/api/v1/loan/list');   
        $response->assertStatus(200);
    }

    /************* Test Single lian as admin  ***************/
    public function test_loan_single()
    {
        $response = $this->actingAs($this->user)->post('/api/v1/loan/apply',
                    ['amount'=>fake()->numberBetween(10, 10000),
                    'term' => fake()->numberBetween(1, 100)
                ]);
                
        //Get the last user created
        $loan = Loans::first();
        $response = $this->actingAs($this->admin)->get('/api/v1/loan/single/'.$loan->id);   
        $response->assertStatus(200);
    }

    /************* Test Loan Approval as admin  ***************/
    public function test_loan_approval()
    {
        $response = $this->actingAs($this->user)->post('/api/v1/loan/apply',
                    ['amount'=>fake()->numberBetween(10, 10000),
                    'term' => fake()->numberBetween(1, 100)
                ]);
                
        //Get the last user created
        $loan = Loans::first();
        $response = $this->actingAs($this->admin)->put('/api/v1/loan/approve/'.$loan->id);   
        $updatedloan = Loans::first();
        $this->assertEquals('APPROVED',$updatedloan->loan_status);
        $response->assertStatus(200);
    }

    /************* Test Delete Loan as admin  ***************/
    public function test_delete_loan()
    {
        $response = $this->actingAs($this->user)->post('/api/v1/loan/apply',
                    ['amount'=>fake()->numberBetween(10, 10000),
                    'term' => fake()->numberBetween(1, 100)
                ]);
                
        //Get the last user created
        $loan = Loans::first();
        $response = $this->actingAs($this->admin)->delete('/api/v1/loan/delete/'.$loan->id);   
        $this->assertEquals(0,Loans::count());
        $response->assertStatus(200);
    }
}
