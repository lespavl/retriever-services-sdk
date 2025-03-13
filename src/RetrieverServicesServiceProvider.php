<?php

namespace RelationDesk\RetrieverServicesSdk;

use Illuminate\Support\ServiceProvider;

class RetrieverServicesServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/retriever-services.php', 'retriever-services'
        );
    }


}