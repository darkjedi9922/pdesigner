<?php
return [
    'viewProject' => [
        'type' => 2,
        'description' => 'View a project',
        'ruleName' => 'isProjectOwner',
    ],
    'user' => [
        'type' => 1,
        'children' => [
            'viewProject',
        ],
    ],
];
