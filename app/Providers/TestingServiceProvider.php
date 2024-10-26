<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!$this->app->runningUnitTests()) {
            return;
        }

        AssertableInertia::macro('hasResource', function (string $key, JsonResource $resource) {
            $json_data = $resource->response()->getData(true);

            $this->has($key);
            expect($this->prop($key))->toEqual($json_data);

            return $this;
        });

        AssertableInertia::macro('hasPaginatedResource', function (string $key, ResourceCollection $resource) {
            $json_data = $resource->response()->getData(true);

            $this->has($key);
            expect($this->prop($key))
                ->toHaveKeys(['data', 'links', 'meta'])
                ->data
                ->toEqual($json_data);

            return $this;
        });

        TestResponse::macro('assertComponentExists', function (string $name) {
            return $this->assertInertia(
                fn (AssertableInertia $inertia) => $inertia->component($name, true)
            );
        });

        TestResponse::macro('assertResource', function (string $key, JsonResource $resource) {
            return $this->assertInertia(
                fn (AssertableInertia $inertia) => $inertia->hasResource($key, $resource)
            );
        });

        TestResponse::macro('assertPaginatedResource', function (string $key, ResourceCollection $resource) {
            return $this->assertInertia(
                fn (AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $resource)
            );
        });
    }
}
