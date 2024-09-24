<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Http::fake([
            'https://your-oauth-provider.com/oauth/authorize*' => Http::response('redirect', 302),
            'https://your-oauth-provider.com/oauth/token*' => Http::response([
                'access_token' => 'fake_access_token',
                'refresh_token' => 'fake_refresh_token',
                'expires_in' => 3600,
            ], 200),
        ]);
    }

    public function testOAuthRedirect()
    {
        $response = $this->get('/oauth/redirect');

        $response->assertStatus(302);  
        $response->assertRedirectContains('oauth/authorize');  // Check if the redirect URL contains the authorization endpoint
    }
    public function testOAuthCallback()
    {
        $response = $this->get('/oauth/callback?code=fake_auth_code');

        $response->assertStatus(302);  // Expect redirection to home or another page after successful login
        $response->assertSessionHas('access_token', 'fake_access_token');  // Check if the access token is stored in session
        $response->assertRedirect('/home');
    }
}
