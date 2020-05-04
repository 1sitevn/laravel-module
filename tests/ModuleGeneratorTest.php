<?php

namespace Onesite\Module\Commands;

use Onesite\Module\ModuleGeneratorServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

function app_path($suffix)
{
    return __DIR__ . '/dist/app' . (starts_with($suffix, '/') ? $suffix : '/' . $suffix);
}

function database_path($suffix)
{
    return __DIR__ . '/dist/database' . (starts_with($suffix, '/') ? $suffix : '/' . $suffix);
}

function base_path($suffix)
{
    return __DIR__ . '/../' . (starts_with($suffix, '/') ? $suffix : '/' . $suffix);
}

function date($format)
{
    return 'date';
}

class ModuleGeneratorTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ModuleGeneratorServiceProvider::class,
        ];
    }

    public function testMakeNewModule()
    {
        // When I run php artisan make:module Blue
        $this->artisan('make:module', ['name' => 'Blue']);

        // Then I see a new Module has been created in the App namespace
        // And it has the correct name
        $this->seeFileWasCreated(app_path('/modules/Blue'));
    }

    public function seeFileWasCreated($filename)
    {
        $this->assertTrue(file_exists($filename));
    }
}