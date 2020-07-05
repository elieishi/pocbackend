<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('migrate',['-vvv' => true]);
        \Artisan::call('passport:install',['-vvv' => true]);
        \Artisan::call('db:seed',['-vvv' => true]);
    }

    /** @test */
    public function a_user_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/users',[
            'name'  => 'Elie Ishimwe',
            'email' => 'elieish@gmail.com',
            'password' => '123456'
        ]);

        $user = User::first();

        $response->assertCreated();
        $response->assertJsonFragment(['id' => $user->id]);
    }

    /** @test */
    public function a_user_can_login()
    {
        $this->withoutExceptionHandling();

        // create user
        $user = User::create([
            'name'     => 'Elie Ishimwe',
            'email'    => 'elieish@gmail.com',
            'password' => bcrypt(12345),
        ]);

        // see a user in database
        $this->assertDatabaseHas('users', [
            'name'  => 'Elie Ishimwe',
            'email' => 'elieish@gmail.com',
        ]);

        //login user
        $response = $this->post('/api/login',[
            'email' => 'elieish@gmail.com',
            'password' => '12345'
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'user',
            'access_token'
        ]);



    }
}
