# Laravel artisan make:resource command

This package adds the ```php artisan make:module command```, allowing 
you to:

> Generate a module create a model, migration, controller, 
routes and model factory in a single easy to use command.

This package serves as a way of very quickly getting an idea off the 
ground, reducing the time you need to spend setting up various parts 
of your application so that you can concentrate on the complexity.

## Why use this package?

When starting a new project, typically we'll begin by creating a new
model, and then going into that model and defining its fillable attributes.
Next, we'll set up a migration, and again define which columns the table 
should hold. 

Next we generate a controller, and add methods for ```index```, 
```show```, ```edit```, ```update```, ```create```, and ```store``` and 
finally open up the routes.php file to set up endpoints that relate to the 
methods in the controller.

If you practice test-driven development, or write automated tests, you'll
then need to create a model factory and again define the same attributes.

I found myself going through the same long winded process time and time again,
so decided to build a single command which can:

* Create a model
* Set its fillable and hidden attributes
* Generate a migration, with column definitions based on the model
* Build a restful controller, with the model imported
* Add the corresponding restful routes namespaced under the model name
* A model factory, with the same attributes and sensible faker dummy data 

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

## Limitations
 
Currently, the package assumes your application lives in the ```App```
namespace, though a future update will make this more flexible.

The way that Faker association in model factories is implemented, 
is not really optimal - but it's a good starting point. Feel free to 
fork and submit a PR. 
 
## Running tests 

A full test suite is included. To execute the tests, from the 
package directory:

    vendor/bin/phpunit tests/testMakeNewModule.php

## Contributing

If you find a bug, or have ideas for an improvement, please submit a 
pull-request, backed by the relevant unit tests.
