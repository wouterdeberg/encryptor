<?php


namespace FlexFlux\Encryptor;

use Illuminate\Support\ServiceProvider;

class EncryptorServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\EncryptCommand::class,
            ]);
        }
    }

}