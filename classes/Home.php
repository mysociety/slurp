<?php

namespace MySociety\Slurp;

class Home {

    public function showHome($request, $response) {
        $response->setContent(json_encode([
            'success' => true,
            'message' => 'Slurp.'
        ]));
        $response->headers->add(['Content-Type' => 'application/json']);
        return $response;
    }

}
