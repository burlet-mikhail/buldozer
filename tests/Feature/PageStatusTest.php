<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageStatusTest extends TestCase {

    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_status_home(): void {
        $response = $this->get( '/' );

        $response->assertStatus( 200 );
    }
}
