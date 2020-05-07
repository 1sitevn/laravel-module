# Laravel artisan make:resource command

This package adds the ```php artisan make:module command```, allowing 
you to:

> Generate a module create a model, migration, controller, 
routes and model factory in a single easy to use command.

This package serves as a way of very quickly getting an idea off the 
ground, reducing the time you need to spend setting up various parts 
of your application so that you can concentrate on the complexity.

## Installation

Install MakeResource through Composer.

    "require": {
        "onesite/laravel-module": "~1.0"
    }

Next, update your ```config/app.php``` to add the included service provider ```\OneSite\Module\ModuleGeneratorServiceProvider::class```:

    'providers' => [
        //...
        \OneSite\Module\ModuleGeneratorServiceProvider::class
    ],

And you're good to go.

## Using the generator

From the command line, run: 

    php artisan make:module ModelName "attributes"

For the simplest example, let's create a new ```admin``` module:

    php artisan make:module admin
    
This will create the following:

* modules\Admin\app\Http\Controllers\BaseController.php
* modules\Admin\app\Http\Controllers\ExampleController.php
* modules\Admin\resources\views/example.blade.php

as well as appending to:

* modules\Admin\routes.php

Copy to composer.json and run ```composer dump-autoload``` to register composer for module, example with module ```admin```:

      "autoload": {
        "psr-4": {
          "Module\\Admin\\": [
            "modules/admin/app/"
          ]
        }
      }

Next, update your ```app/Providers/AppServiceProvider.php``` to add the included service provider
to your ```register``` function:

    public function register()
    {
        $this->app->register(\Modules\ModuleName\Providers\AppServiceProvider::class);
    }

## Running tests 

A full test suite is included. To execute the tests, from the 
package directory:

    vendor/bin/phpunit tests/testMakeNewModule.php

