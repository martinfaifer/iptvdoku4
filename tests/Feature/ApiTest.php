<?php

it('get channels list', function() {
    $response = $this->get('/api/v1/public/channels');

    $response->assertStatus(200);
});

it('get epg for channel', function() {
    $response = $this->get('/api/v1/public/epg?channel=HBO HD&forDay=2024-05-25');

    $response->assertStatus(200);
});

it('fail if epg for channel do not exists ot channel not exists', function() {
    $response = $this->get('/api/v1/public/epg?channel=HBO2 HD&forDay=2024-05-25');
    $response->assertStatus(404);

    $response = $this->get('/api/v1/public/epg?channel=HBO HD54545&forDay=2024-05-25');
    $response->assertStatus(404);
});
