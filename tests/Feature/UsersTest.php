<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/users',[
            'name'  => 'Elie',
            'email' => 'elieish@gmail.com',
            'password' => '123456'
        ]);

        $user = User::first();

        $response->assertCreated();
        $response->assertJsonFragment(['id' => $user->id]);
    }
}
