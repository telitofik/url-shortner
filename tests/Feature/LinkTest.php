<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Link;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    // Test 1 - Guest redirect hoga login pe
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    // Test 2 - Logged in user links page dekh sakta hai
    public function test_authenticated_user_can_see_links_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    // Test 3 - URL shorten ho sakti hai
    public function test_user_can_shorten_a_url(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/shorten', [
            'url' => 'https://google.com'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('links', [
            'url' => 'https://google.com',
            'user_id' => $user->id
        ]);
    }

    // Test 4 - Short code redirect karta hai original URL pe
    public function test_short_code_redirects_to_original_url(): void
    {
        $link = Link::factory()->create([
            'url' => 'https://google.com',
            'code' => 'abc123'
        ]);

        $response = $this->get('/abc123');
        $response->assertRedirect('https://google.com');
    }
}