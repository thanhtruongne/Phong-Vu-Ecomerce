<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use GuzzleHttp\Client as HttpClient;
class CreateElasticsearchIndex extends Command
{
    protected $signature = 'elasticsearch:create-index';
    protected $description = 'Tạo index trong Elasticsearch';
    public function handle()
    {
        $client = ClientBuilder::create()->setHttpClient(new HttpClient(['verify' => false ]))->setHosts([env('APP_URL_ELASTICSEARCHT')])->build();
        $params = [
            'index' => 'product_index',
            'body'  => [
                'mappings' => [
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'name' => ['type' => 'text', 'analyzer' => 'standard'],
                        'price' => ['type' => 'double'],
                        'quantity' => ['type' => 'integer'],
                        'status' => ['type' => 'integer'],
                        'is_single' => ['type' => 'integer'],
                        'product_category_id' => ['type' => 'product_category_id'],
                        'brand_id' => ['type' => 'integer'],
                    ],   
                ],
            ],
        ];

        $response = $client->indices()->create($params);

        $this->info('Index created: ' . json_encode($response));
    }
}
