<?php

namespace Tests\Feature;

use App\Listing;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveListingsTest extends TestCase
{
    use RefreshDatabase;

    public function  setUp():void
    {
        parent::setUp();
        \Artisan::call('migrate',['-vvv' => true]);
        \Artisan::call('passport:install',['-vvv' => true]);
        \Artisan::call('db:seed',['-vvv' => true]);
    }

    /** @test */
    public function can_retrieve_listings()
    {
        $this->withoutExceptionHandling();

        $listings = factory(Listing::class, 2)->create();

        $response = $this->get('api/listings');

        $response->assertStatus(200);
        $response->assertJson([
            "data" => [
                [
                    'id'=> $listings->first()->id,
                    'title' => $listings->first()->title,
                ],
                [
                    'id'=> $listings->last()->id,
                    'title' => $listings->last()->title
                ]
            ]
         ]);
    }

    /** @test */
    public function a_user_can_only_retrieve_their_listing()
    {
        $this->withoutExceptionHandling();

        $listing = factory(Listing::class, 1)->create();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $myListing = factory(Listing::class, 1)->create(['user_id' => $user->id]);

        $response = $this->get('api/listings/me');

        $this->assertCount(2, Listing::all());

        $response->assertStatus(200);

        $response->assertSee($myListing[0]->title);

        $response->assertDontSee($listing[0]->title);

    }
}
