<?php

namespace OneSite\Module;

use Orchestra\Testbench\TestCase;

/**
 * @param $suffix
 * @return string
 */
function base_path($suffix)
{
    return __DIR__ . '/dist' . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
}

/**
 * Class ModuleGeneratorTest
 * @package OneSite\Module\Commands
 * PHPUnit test: vendor/bin/phpunit tests/ModuleGeneratorTest.php
 */
class ModuleGeneratorTest extends TestCase
{
    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ModuleGeneratorServiceProvider::class
        ];
    }

    /**
     * PHPUnit test: vendor/bin/phpunit --filter testMakeNewModule tests/ModuleGeneratorTest.php
     */
    public function testMakeNewModule()
    {
        $this->artisan('make:module', ['name' => 'admin']);

        $this->assertTrue(file_exists(base_path('/modules/admin')));
    }
}
