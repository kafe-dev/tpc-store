<?php

return [
    'app'                      => [
        'path'       => './assets/mappers/app.js',
        'entrypoint' => true,
    ],
    'admin'                    => [
        'path'       => './assets/mappers/admin.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus'       => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo'          => [
        'version' => '7.3.0',
    ],
];
