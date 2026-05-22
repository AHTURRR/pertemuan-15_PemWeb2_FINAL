<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Daftar Kategori Buku');
    }

    public function test_kategori_page_can_be_visited(): void
    {
        $response = $this->get('/kategori');

        $response->assertStatus(200);
        $response->assertSee('Daftar Kategori Buku');
    }

    public function test_hello_route_returns_text(): void
    {
        $response = $this->get('/hello');

        $response->assertStatus(200);
        $response->assertSee('Hello dari Laravel!');
    }
}
