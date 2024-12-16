<?php

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use OzanKurt\Blog\BlogServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            BlogServiceProvider::class,
        ];
    }
}
