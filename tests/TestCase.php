<?php

namespace Tests;

use Illuminate\Container\Container;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Http;
use Illuminate\Cache\Repository;
use Illuminate\Cache\ArrayStore;

class TestCase extends \PHPUnit\Framework\TestCase
{
    const CONFIG_PATH = __DIR__ . '/../config/retriever-services.php';

    protected function setUp(): void
    {
        parent::setUp();

        // Create a new Laravel container
        $this->app = new Container();

        // Set the container instance
        Container::setInstance($this->app);
        Facade::setFacadeApplication($this->app);

        // Cache
        $this->app->singleton('cache', function () {
            return new Repository(new ArrayStore());
        });
        Cache::setFacadeApplication($this->app);
        Cache::shouldReceive('remember')->andReturn('test_token');

        // Register the Config repository in the container
        $this->app->singleton('config', function ($app) {
            $configData = require self::CONFIG_PATH;
            return new \Illuminate\Config\Repository(['retriever-services' => $configData]);
        });

        // make sure Http facade is using the correct Factory instance
        $freshHttp = $this->app[Factory::class];
        $this->app->forgetInstance(Factory::class);
        Http::swap($freshHttp);
    }
}