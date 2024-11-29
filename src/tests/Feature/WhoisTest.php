<?php

namespace Tests\Feature;

use Tests\TestCase;

class WhoisTest extends TestCase
{
    public function testValidDomain()
    {
        $response = $this->get('/v1/api/whois?domain=example.com');
        $response->assertStatus(200);
    }

    public function testInvalidDomain()
    {
        $response = $this->get('/v1/api/whois?domain=invalid_domain');
        $response->assertStatus(400);
    }

    public function testNonComDomain()
    {
        $response = $this->get('/v1/api/whois?domain=example.net');
        $response->assertStatus(400);
    }

    public function testNotFoundDomain()
    {
        $response = $this->get('/v1/api/whois?domain=aegaegeagrearg.com');
        $response->assertStatus(404);
    }
}
