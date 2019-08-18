<?php
return [
    'addProject' => [
        'type' => 2,
        'description' => 'Add a project',
    ],
    'viewProject' => [
        'type' => 2,
        'description' => 'View a project',
    ],
    'viewOwnProject' => [
        'type' => 2,
        'description' => 'View own project',
        'ruleName' => 'isProjectOwner',
        'children' => [
            'viewProject',
        ],
    ],
    'editProject' => [
        'type' => 2,
        'description' => 'Edit a project',
    ],
    'editOwnProject' => [
        'type' => 2,
        'description' => 'Edit own project',
        'ruleName' => 'isProjectOwner',
        'children' => [
            'editProject',
        ],
    ],
    'deleteProject' => [
        'type' => 2,
        'description' => 'Delete a project',
    ],
    'deleteOwnProject' => [
        'type' => 2,
        'description' => 'Delete own project',
        'ruleName' => 'isProjectOwner',
        'children' => [
            'deleteProject',
        ],
    ],
    'user' => [
        'type' => 1,
        'children' => [
            'addProject',
            'viewOwnProject',
            'editOwnProject',
            'deleteOwnProject',
        ],
    ],
];
