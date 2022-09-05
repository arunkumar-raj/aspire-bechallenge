<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /*********** Test user can register properly ***************/
    public function test_user_register_properly()
    {
        $this->withExceptionHandling();

        //Hit the api url to register the user
        $response = $this->post('/api/v1/user/register',['name'=>'sample','email' => 'sampletest@gmail.com','password'=>'sample123']);

        //Get the last user created
        $user = User::first();

        //We only have one user 
        $this->assertEquals(1,User::count());

        //Check the response we got back
        $response->assertStatus(200);

        //Test the user has a proper data
        $this->assertEquals('sample',$user->name);
    }

}
