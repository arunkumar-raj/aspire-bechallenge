<?php

namespace Tests\Unit\Api\V1;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    //Test the endpoints are working properly
    public function test_login()
    {
        $response = $this->post('/api/v1/user/login',['email' => 'sampletest@gmail.com','password'=>'sample123']);
        $response->assertStatus(200);
    }

    public function test_register()
    {
        $response = $this->post('/api/v1/user/register',['name'=>'sample','email' => 'sampletest@gmail.com','password'=>'sample123']);
        $response->assertStatus(200);
    }

    public function test_logout()
    {
        $response = $this->post('/api/v1/user/logout');
        $response->assertStatus(200);
    }
}
