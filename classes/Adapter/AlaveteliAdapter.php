<?php

namespace MySociety\Slurp\Adapter;

use MySociety\Slurp\Adapter\AbstractAdapterClass as AbstractAdapterClass;

class AlaveteliAdapter extends AbstractAdapterClass {

    public function parseBody() {
        $response = $this->client->get($this->endpoint);

        $data = json_decode($response->getBody());

        $this->insertDatapoint('visible_request_count', $data->visible_request_count);
    }

}
