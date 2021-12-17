<?php


namespace Beatom\DataSeo;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;


class HelperServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

        var_dump( __DIR__.'/setting/dataseo.php');
        var_dump(base_path('config/dataseo.php'));

        $this->publishes([
            __DIR__.'/../setting/dataseo.php' => base_path('config/dataseo.php'),
            'config'
        ]);

    }


}
