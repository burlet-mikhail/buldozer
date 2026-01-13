<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\City;
use App\Models\Page;
use App\Models\Product;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Очищаем sitemap файлы перед каждым тестом
        $this->cleanSitemapFiles();
    }

    protected function tearDown(): void
    {
        $this->cleanSitemapFiles();
        parent::tearDown();
    }

    private function cleanSitemapFiles(): void
    {
        $indexFile = public_path('sitemap.xml');
        if (File::exists($indexFile)) {
            File::delete($indexFile);
        }

        $sitemapsDir = config('sitemap.path');
        if (File::isDirectory($sitemapsDir)) {
            File::deleteDirectory($sitemapsDir);
        }
    }

    public function test_sitemap_index_returns_404_when_not_generated(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(404);
    }

    public function test_sitemap_index_returns_xml_after_generation(): void
    {
        // Создаём тестовые данные
        $region = Region::factory()->create(['active' => true]);
        $category = Category::factory()->create(['active' => true]);
        Product::factory()->create([
            'active' => true,
            'region_id' => $region->id,
        ])->categories()->attach($category);

        // Генерируем sitemap
        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        // Проверяем ответ
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $response->assertSee('<?xml version="1.0"', false);
        $response->assertSee('<sitemapindex', false);
    }

    public function test_sitemap_file_returns_xml(): void
    {
        $region = Region::factory()->create(['active' => true]);
        $category = Category::factory()->create(['active' => true]);
        Product::factory()->create([
            'active' => true,
            'region_id' => $region->id,
        ])->categories()->attach($category);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-main.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $response->assertSee('<urlset', false);
    }

    public function test_sitemap_file_returns_404_for_nonexistent(): void
    {
        $response = $this->get('/sitemaps/sitemap-nonexistent.xml');

        $response->assertStatus(404);
    }

    public function test_sitemap_contains_products(): void
    {
        $region = Region::factory()->create(['active' => true]);
        $product = Product::factory()->create([
            'active' => true,
            'slug' => 'test-product-slug',
            'region_id' => $region->id,
        ]);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-products-0.xml');

        $response->assertStatus(200);
        $response->assertSee('/object/test-product-slug');
    }

    public function test_sitemap_excludes_inactive_products(): void
    {
        $region = Region::factory()->create(['active' => true]);
        Product::factory()->create([
            'active' => false,
            'slug' => 'inactive-product',
            'region_id' => $region->id,
        ]);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-products-0.xml');

        $response->assertStatus(200);
        $response->assertDontSee('/object/inactive-product');
    }

    public function test_sitemap_contains_categories_with_products(): void
    {
        $region = Region::factory()->create(['active' => true]);
        $category = Category::factory()->create([
            'active' => true,
            'slug' => 'test-category',
        ]);

        $product = Product::factory()->create([
            'active' => true,
            'region_id' => $region->id,
        ]);
        $product->categories()->attach($category);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-categories-0.xml');

        $response->assertStatus(200);
        $response->assertSee('/catalog/category/test-category');
    }

    public function test_sitemap_excludes_categories_without_products(): void
    {
        Category::factory()->create([
            'active' => true,
            'slug' => 'empty-category',
        ]);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-categories-0.xml');

        $response->assertStatus(200);
        $response->assertDontSee('/catalog/category/empty-category');
    }

    public function test_sitemap_contains_cities_with_products(): void
    {
        $region = Region::factory()->create(['active' => true]);
        $city = City::factory()->create([
            'active' => true,
            'slug' => 'test-city',
            'region_id' => $region->id,
        ]);

        $product = Product::factory()->create([
            'active' => true,
            'region_id' => $region->id,
        ]);
        $product->cities()->attach($city);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-cities-0.xml');

        $response->assertStatus(200);
        $response->assertSee('/catalog/city/test-city');
    }

    public function test_sitemap_excludes_cities_without_products(): void
    {
        $region = Region::factory()->create(['active' => true]);
        City::factory()->create([
            'active' => true,
            'slug' => 'empty-city',
            'region_id' => $region->id,
        ]);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-cities-0.xml');

        $response->assertStatus(200);
        $response->assertDontSee('/catalog/city/empty-city');
    }

    public function test_sitemap_contains_pages(): void
    {
        Page::factory()->create(['slug' => 'about-us']);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-pages.xml');

        $response->assertStatus(200);
        $response->assertSee('/about-us');
    }

    public function test_sitemap_contains_region_with_products(): void
    {
        $region = Region::factory()->create([
            'active' => true,
            'slug' => 'test-region-for-sitemap',
        ]);

        Product::factory()->create([
            'active' => true,
            'region_id' => $region->id,
        ]);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemaps/sitemap-region-test-region-for-sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee('test-region-for-sitemap.');
    }

    public function test_sitemap_excludes_region_without_products(): void
    {
        Region::factory()->create([
            'active' => true,
            'slug' => 'empty-region',
        ]);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        // Файл не должен существовать
        $this->assertFalse(
            File::exists(config('sitemap.path') . '/sitemap-region-empty-region.xml')
        );
    }

    public function test_artisan_command_generates_sitemap(): void
    {
        $region = Region::factory()->create(['active' => true]);
        Product::factory()->create([
            'active' => true,
            'region_id' => $region->id,
        ]);

        $this->artisan('sitemap:generate')
            ->expectsOutput('Начало генерации sitemap...')
            ->assertExitCode(0);

        $this->assertFileExists(public_path('sitemap.xml'));
        $this->assertDirectoryExists(config('sitemap.path'));
    }

    public function test_artisan_command_clears_cache(): void
    {
        $this->artisan('sitemap:generate --clear-cache')
            ->expectsOutput('Очистка кеша sitemap...')
            ->expectsOutput('Кеш очищен.')
            ->assertExitCode(0);
    }

    public function test_sitemap_index_contains_all_sitemaps(): void
    {
        $region = Region::factory()->create(['active' => true]);
        $category = Category::factory()->create(['active' => true]);
        $city = City::factory()->create(['active' => true, 'region_id' => $region->id]);
        Page::factory()->create();

        $product = Product::factory()->create([
            'active' => true,
            'region_id' => $region->id,
        ]);
        $product->categories()->attach($category);
        $product->cities()->attach($city);

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee('sitemap-main.xml');
        $response->assertSee('sitemap-products-0.xml');
        $response->assertSee('sitemap-categories-0.xml');
        $response->assertSee('sitemap-cities-0.xml');
        $response->assertSee('sitemap-pages.xml');
    }
}
