<?php
return [
    'models' =>
        [
            [
                'scope' => [
                    'indirect-emissions-owned',
                    'electricity',
                ],
                'name' => 'meeting-rooms',
            ],
            [
                'scope' => [
                    'indirect-emissions-owned',
                    'electricity',
                ],
                'name' => 'meeting-rooms-guarded',
                'template' => 'guarded'
            ]
        ],
    'aplan' =>
        [
            [
                'scope' => [
                    'examples'
                ],
                'name' => 'non-model-example'
            ]
        ]
];
