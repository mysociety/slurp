<?php

namespace MySociety\Slurp\Adapter;

use MySociety\Slurp\Adapter\AbstractAdapterClass as AbstractAdapterClass;

class AlaveteliAdapter extends AbstractAdapterClass {

    private $dataKeys = array(
        'alaveteli_version',
        'alaveteli_git_commit',
        'ruby_version',
        'visible_request_count',
        'visible_public_body_count',
        'confirmed_user_count',
        'visible_comment_count',
        'track_thing_count',
        'widget_vote_count',
        'public_body_change_request_count',
        'request_classification_count',
        'visible_followup_message_count',
    );

    public function parseBody($site_instance_id, \GuzzleHttp\Client $client, $endpoint) {
        $response = $client->get($endpoint);

        $data = json_decode($response->getBody());

        foreach ($this->dataKeys as $dataKey) {
            if (!empty($data->$dataKey)) {
                $this->insertDatapoint($site_instance_id, $dataKey, $data->$dataKey);
            }
        }
    }

}
