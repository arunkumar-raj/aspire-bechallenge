<?php

namespace Tests\Unit\Api\V1;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

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
    

    //Test the endpoints are working properly
    public function test_loan_list_url()
    {
        
        $response = $this->actingAs($this->admin)->get('/api/v1/loan/list');
        $response->assertStatus(200);
    }

    public function test_loan_apply_url()
    {
        $response = $this->actingAs($this->user)->post('/api/v1/loan/apply',
                    ['amount'=>fake()->numberBetween(10, 10000),
                    'term' => fake()->numberBetween(1, 100)
                ]);
        $response->assertStatus(200);
    }

}
