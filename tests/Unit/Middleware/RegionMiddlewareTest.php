<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\RegionMiddleware;
use App\Models\Region;
use App\Services\Region\RegionServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegionMiddlewareTest extends TestCase {

    use RefreshDatabase;

    private RegionMiddleware $middleware;
    private RegionServices $service;

    protected function setUp(): void {
        parent::setUp();
        $this->service = app(RegionServices::class);
        $this->middleware = new RegionMiddleware($this->service);
        cache()->flush();
    }

    private function createRequest(string $host, string $uri = '/'): Request {
        $request = Request::create($uri);
        $request->headers->set('HOST', $host);

        return $request;
    }

    private function runMiddleware(Request $request): Response {
        return $this->middleware->handle($request, fn($req) => new \Illuminate\Http\Response('OK'));
    }

    public function test_main_subdomain_sets_default_region(): void {
        $defaultRegion = Region::query()->where('slug', 'moscow')->first();
        $defaultRegion->update(['default' => true]);
        cache()->flush();

        $request = $this->createRequest('buldozer.test');
        $this->runMiddleware($request);

        $this->assertEquals($defaultRegion->id, session('region'));
    }

    public function test_www_subdomain_treated_as_main(): void {
        $defaultRegion = Region::query()->where('slug', 'moscow')->first();
        $defaultRegion->update(['default' => true]);
        cache()->flush();

        $request = $this->createRequest('www.buldozer.test');
        $this->runMiddleware($request);

        $this->assertEquals($defaultRegion->id, session('region'));
    }

    public function test_region_subdomain_sets_correct_region(): void {
        $spbRegion = Region::factory()->create(['slug' => 'spb']);
        cache()->flush();

        $request = $this->createRequest('spb.buldozer.test', '/catalog');
        $this->runMiddleware($request);

        $this->assertEquals($spbRegion->id, session('region'));
    }

    public function test_region_subdomain_updates_session_when_changed(): void {
        $moscowRegion = Region::query()->where('slug', 'moscow')->first();
        $spbRegion = Region::factory()->create(['slug' => 'spb']);
        session(['region' => $moscowRegion->id]);
        cache()->flush();

        $request = $this->createRequest('spb.buldozer.test', '/catalog');
        $this->runMiddleware($request);

        $this->assertEquals($spbRegion->id, session('region'));
    }

    public function test_unknown_subdomain_redirects_to_main_url(): void {
        $request = $this->createRequest('unknown.buldozer.test', '/catalog');
        $response = $this->runMiddleware($request);

        $this->assertTrue($response->isRedirect());
        $this->assertEquals(config('app.url'), $response->headers->get('Location'));
    }

    public function test_object_url_skips_middleware_processing(): void {
        session()->forget('region');

        $request = $this->createRequest('unknown.buldozer.test', '/object/some-product');
        $response = $this->runMiddleware($request);

        // Не должен редиректить для /object/ URL
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('OK', $response->getContent());
    }

    public function test_preserves_existing_session_on_main_domain(): void {
        $spbRegion = Region::factory()->create(['slug' => 'spb']);
        session(['region' => $spbRegion->id]);

        $request = $this->createRequest('buldozer.test');
        $this->runMiddleware($request);

        $this->assertEquals($spbRegion->id, session('region'));
    }

    public function test_same_region_does_not_update_session(): void {
        $spbRegion = Region::factory()->create(['slug' => 'spb']);
        session(['region' => $spbRegion->id]);
        cache()->flush();

        $request = $this->createRequest('spb.buldozer.test', '/catalog');
        $this->runMiddleware($request);

        $this->assertEquals($spbRegion->id, session('region'));
    }

    public function test_region_is_cached_by_slug(): void {
        $spbRegion = Region::factory()->create(['slug' => 'spb']);
        cache()->flush();

        $request = $this->createRequest('spb.buldozer.test', '/catalog');
        $this->runMiddleware($request);

        $this->assertTrue(cache()->has('region.spb'));
    }

}
