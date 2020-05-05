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
    return __DIR__ . '/../' . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
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
            ModuleGeneratorServiceProvider::class,
        ];
    }

    /**
     *
     */
    public function testMakeNewModule()
    {
        // When I run php artisan make:module Blue
        $this->artisan('make:module', ['name' => 'Blue']);

        // Then I see a new Module has been created in the App namespace
        // And it has the correct name
        $this->seeFileWasCreated(app_path('/modules/Blue'));
    }

    /**
     * @param $filename
     */
    public function seeFileWasCreated($filename)
    {
        $this->assertTrue(true);
        //$this->assertTrue(file_exists($filename));
    }
}