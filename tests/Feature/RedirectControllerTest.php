<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectControllerTest extends TestCase
{
    private function getAuthHeaders(): array
    {
        return ['X-API-KEY' => 'Vap01'];
    }

    public function testRedirectBasicLimit()
    {
        for ($i = 1; $i <= 60; $i++) {
            $response = $this->withHeaders($this->getAuthHeaders())
            ->get('/redirect/from');

            $response->assertRedirect('/redirect/to')->assertStatus(302);
        }

        $response = $this->withHeaders($this->getAuthHeaders())
            ->get('/redirect/from');
        $response->assertStatus(429);

    }

    public function testRedirectAction()
    {
        $response = $this->withHeaders($this->getAuthHeaders())
            ->get('/redirect/action');

        $response->assertRedirect('/redirect/hello/Azriel');
    }

    public function testRedirectAway()
    {
        $response = $this->withHeaders($this->getAuthHeaders())
            ->get('/redirect/google');

        $response->assertRedirect('https://www.google.com');
    }

    public function testRedirectWithoutApiKey()
    {
        $response = $this->get('/redirect/from');

        // Assumes unauthorized access returns 401 or redirects to login
        $response->assertStatus(401);
        // or $response->assertRedirect('/login');
    }

    public function testRedirectWithInvalidApiKey()
    {
        $response = $this->withHeaders(['X-API-KEY' => 'invalid-key'])
            ->get('/redirect/from');

        $response->assertStatus(401);
    }
}
