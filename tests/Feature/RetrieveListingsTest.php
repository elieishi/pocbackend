<?php

namespace Tests\Feature;

use App\Listing;
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
    public function a_user_can_retrieve_listings()
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
}
