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
    'addIssue' => [
        'type' => 2,
        'description' => 'Add an issue',
    ],
    'addIssueToOwnProject' => [
        'type' => 2,
        'description' => 'Add an issue to own project',
        'ruleName' => 'isProjectOwner',
        'children' => [
            'addIssue',
        ],
    ],
    'viewIssue' => [
        'type' => 2,
        'description' => 'View an issue',
    ],
    'viewOwnIssue' => [
        'type' => 2,
        'description' => 'View own issue',
        'children' => [
            'viewIssue',
        ],
    ],
    'toggleIssue' => [
        'type' => 2,
        'description' => 'Toggle an issue',
    ],
    'toggleOwnIssue' => [
        'type' => 2,
        'description' => 'Toggle own issue',
        'ruleName' => 'isIssueOwner',
        'children' => [
            'toggleIssue',
        ],
    ],
    'editIssue' => [
        'type' => 2,
        'description' => 'Edit an issue',
    ],
    'editOwnIssue' => [
        'type' => 2,
        'description' => 'Edit own issue',
        'ruleName' => 'isIssueOwner',
        'children' => [
            'editIssue',
        ],
    ],
    'deleteIssue' => [
        'type' => 2,
        'description' => 'Delete an issue',
    ],
    'deleteOwnIssue' => [
        'type' => 2,
        'description' => 'Delete own issue',
        'ruleName' => 'isIssueOwner',
        'children' => [
            'deleteIssue',
        ],
    ],
    'user' => [
        'type' => 1,
        'children' => [
            'addProject',
            'viewOwnProject',
            'editOwnProject',
            'deleteOwnProject',
            'addIssueToOwnProject',
            'viewOwnIssue',
            'toggleOwnIssue',
            'editOwnIssue',
            'deleteOwnIssue',
        ],
    ],
];
