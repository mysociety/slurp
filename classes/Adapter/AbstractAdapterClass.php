<?php

namespace MySociety\Slurp\Adapter;

use Illuminate\Database\Capsule\Manager as Capsule;

abstract class AbstractAdapterClass {

    abstract public function parseBody($site_instance_id, \GuzzleHttp\Client $client, $endpoint);

    protected function insertDatapoint ($site_instance_id, $key, $value) {
        Capsule::table('data')->insert([
            'timestamp' => date('Y-m-d H:i:s'),
            'site_instance_id' => $site_instance_id,
            'key' => $key,
            'value' => $value,
        ]);
    }

}
