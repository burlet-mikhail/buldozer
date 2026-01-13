<?php

namespace Tests\Feature;

use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionControllerTest extends TestCase {

    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        cache()->flush();
    }

    public function test_region_change_sets_session(): void {
        $spbRegion = Region::factory()->create(['slug' => 'spb', 'name' => 'Санкт-Петербург']);

        $this->get("/region/{$spbRegion->slug}");

        $this->assertEquals($spbRegion->id, session('region'));
    }

    public function test_region_change_redirects_to_subdomain(): void {
        $spbRegion = Region::factory()->create(['slug' => 'spb']);

        $response = $this->get("/region/{$spbRegion->slug}");

        $response->assertRedirect();
        $this->assertStringContainsString('spb', $response->headers->get('Location'));
    }

    public function test_region_change_queues_cookie(): void {
        $spbRegion = Region::factory()->create(['slug' => 'spb']);

        $response = $this->get("/region/{$spbRegion->slug}");

        $cookies = $response->headers->getCookies();
        $regionCookie = collect($cookies)->first(fn($c) => $c->getName() === 'region');

        $this->assertNotNull($regionCookie, 'Cookie "region" should be set');
    }

    public function test_non_existing_region_returns_404(): void {
        $response = $this->get('/region/non-existing-region');

        $response->assertNotFound();
    }

}
