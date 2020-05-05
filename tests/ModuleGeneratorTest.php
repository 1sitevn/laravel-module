<?php

namespace OneSite\Module\Commands;

use OneSite\Module\ModuleGeneratorServiceProvider;
use Orchestra\Testbench\TestCase;

/**
 * @param $suffix
 * @return string
 */
function app_path($suffix)
{
    return __DIR__ . '/dist/app' . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
}

/**
 * @param $suffix
 * @return string
 */
function database_path($suffix)
{
    return __DIR__ . '/dist/database' . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
}

/**
 * @param $suffix
 * @return string
 */
function base_path($suffix)
{
    return __DIR__ . '/dist' . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
}

/**
 * @param $format
 * @return string
 */
function date($format)
{
    return 'date';
}

/**
 * Class ModuleGeneratorTest
 * @package OneSite\Module\Commands
 * PHPUnit test: vendor/bin/phpunit tests/ModuleGeneratorTest.php
 */
class ModuleGeneratorTest extends TestCase
{
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

    /**
     * PHPUnit test: vendor/bin/phpunit --filter testModuleHelper tests/ModuleGeneratorTest.php
     */
    public function testModuleHelper()
    {
        $this->assertTrue(function_exists('module_admin_test_function') && 'admin' === module_admin_test_function());
    }
}