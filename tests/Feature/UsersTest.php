<?php

namespace Tests\Feature;

use App\User;
use App\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    private $user;

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

    /** @test */
    public function a_user_can_create_a_listing()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        //create listing
        $response = $this->post('/api/listings',[
            'title'         => 'Lonehill Bedroom',
            'description'   => '12345',
            'price'         => 100,
            'currency'      => 'zar',
            'category'      => 'furniture'
        ]);

        $listing = Listing::first();

        $this->assertCount(1, Listing::all());
        $this->assertEquals($user->id, $listing->user_id);

        $response->assertSuccessful();
        $response->assertJson([
                'id'=> $listing->id,
                'title' => 'Lonehill Bedroom',
                'description' => '12345',
                'price' => 100,
                'currency' => 'zar',
                'category' => 'furniture'
        ]);
    }

}
