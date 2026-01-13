<?php

namespace Tests\Feature;

use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionMiddlewareTest extends TestCase {

    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        cache()->flush();
    }

    public function test_main_subdomain_sets_default_region_when_no_session(): void {
        $defaultRegion = Region::query()->where('slug', 'moscow')->first();
        $defaultRegion->update(['default' => true]);
        cache()->flush();

        $this->get('/', ['HTTP_HOST' => 'buldozer.test']);

        $this->assertEquals($defaultRegion->id, session('region'));
    }

    public function test_main_subdomain_preserves_existing_session_region(): void {
        $region = Region::factory()->create(['slug' => 'spb']);

        $this->withSession(['region' => $region->id])
             ->get('/', ['HTTP_HOST' => 'buldozer.test']);

        $this->assertEquals($region->id, session('region'));
    }

    public function test_www_subdomain_treated_as_main(): void {
        $defaultRegion = Region::query()->where('slug', 'moscow')->first();
        $defaultRegion->update(['default' => true]);
        cache()->flush();

        $this->get('/', ['HTTP_HOST' => 'www.buldozer.test']);

        $this->assertEquals($defaultRegion->id, session('region'));
    }

}
