<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private CacheInterface $issLocationPool,
    ) {}

    public function getIssLocationData()
    {
        return $this->issLocationPool->get('iss_data', function () {
            $response = $this->client->request('GET', 'https://api.wheretheiss.at/v1/satellites/25544');
            return $response->toArray();
        });
    }
}
