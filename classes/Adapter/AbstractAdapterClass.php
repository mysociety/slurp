<?php

namespace MySociety\Slurp\Adapter;

use Illuminate\Database\Capsule\Manager as Capsule;

abstract class AbstractAdapterClass {

    protected $client;
    protected $site_instance_id;
    protected $endpoint;

    public function __construct ($site_instance_id, \GuzzleHttp\Client $client, $endpoint) {
        // Initialise the HTTP client as part of the adapter
        $this->client = $client;
        $this->site_instance_id = $site_instance_id;
        $this->endpoint = $endpoint;
    }

    abstract public function parseBody();

    protected function insertDatapoint ($key, $value) {
        Capsule::table('data')->insert([
            'timestamp' => date('Y-m-d H:i:s'),
            'site_instance_id' => $this->site_instance_id,
            'key' => $key,
            'value' => $value,
        ]);
    }

}
