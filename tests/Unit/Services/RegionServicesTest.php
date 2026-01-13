<?php

namespace Tests\Unit\Services;

use App\Models\Region;
use App\Services\Region\RegionServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionServicesTest extends TestCase {

    use RefreshDatabase;

    private RegionServices $service;

    protected function setUp(): void {
        parent::setUp();
        $this->service = app(RegionServices::class);
        cache()->flush();
    }

    public function test_set_stores_region_in_session(): void {
        $region = Region::factory()->create();

        $this->service->set($region->id);

        $this->assertEquals($region->id, session('region'));
    }

    public function test_set_queues_cookie(): void {
        $region = Region::factory()->create();

        $this->service->set($region->id);

        // Cookie добавляется в очередь через cookie()->queue()
        $queuedCookies = app('cookie')->getQueuedCookies();
        $found = false;
        foreach ($queuedCookies as $cookie) {
            if ($cookie->getName() === 'region') {
                $found = true;
                $this->assertEquals($region->id, $cookie->getValue());
                break;
            }
        }
        $this->assertTrue($found, 'Cookie "region" should be queued');
    }

    public function test_get_id_returns_region_from_session(): void {
        $region = Region::factory()->create();
        session(['region' => $region->id]);

        $result = $this->service->getId();

        $this->assertEquals($region->id, $result);
    }

    public function test_get_id_returns_default_when_session_empty(): void {
        // Начальный регион moscow создаётся миграцией
        $moscowRegion = Region::query()->where('slug', 'moscow')->first();
        $moscowRegion->update(['default' => true]);

        cache()->flush();
        session()->forget('region');

        $result = $this->service->getId();

        $this->assertEquals($moscowRegion->id, $result);
    }

    public function test_get_id_returns_config_default_when_no_default_region(): void {
        // moscow создан миграцией с id = 1
        Region::query()->update(['default' => false]);
        cache()->flush();
        session()->forget('region');

        $result = $this->service->getId();

        $this->assertEquals(config('regions.default_region_id'), $result);
    }

    public function test_get_id_validates_region_exists(): void {
        $moscowRegion = Region::query()->where('slug', 'moscow')->first();
        $moscowRegion->update(['default' => true]);
        cache()->flush();

        session(['region' => 99999]); // несуществующий ID

        $result = $this->service->getId();

        $this->assertEquals($moscowRegion->id, $result);
    }

    public function test_get_default_id_returns_default_region(): void {
        $defaultRegion = Region::factory()->create(['default' => true]);
        Region::query()->where('id', '!=', $defaultRegion->id)->update(['default' => false]);
        cache()->flush();

        $result = $this->service->getDefaultId();

        $this->assertEquals($defaultRegion->id, $result);
    }

    public function test_region_exists_returns_true_for_existing_region(): void {
        $region = Region::factory()->create();
        cache()->flush();

        $result = $this->service->regionExists($region->id);

        $this->assertTrue($result);
    }

    public function test_region_exists_returns_false_for_non_existing_region(): void {
        cache()->flush();

        $result = $this->service->regionExists(99999);

        $this->assertFalse($result);
    }

    public function test_get_name_returns_region_name(): void {
        $region = Region::factory()->create(['name' => 'Тестовый']);
        cache()->flush();
        $this->service->set($region->id);

        $result = $this->service->getName();

        $this->assertEquals('Тестовый', $result);
    }

    public function test_get_slug_returns_region_slug(): void {
        $region = Region::factory()->create(['slug' => 'test-region']);
        cache()->flush();
        $this->service->set($region->id);

        $result = $this->service->getSlug();

        $this->assertEquals('test-region', $result);
    }

    public function test_get_id_casts_session_value_to_int(): void {
        $region = Region::factory()->create();
        session(['region' => (string) $region->id]);
        cache()->flush();

        $result = $this->service->getId();

        $this->assertIsInt($result);
        $this->assertEquals($region->id, $result);
    }

}
