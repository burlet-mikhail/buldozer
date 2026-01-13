<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Отключаем Vite в тестах чтобы не требовать скомпилированные assets
        $this->withoutVite();
    }
}
