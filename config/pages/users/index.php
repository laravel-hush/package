<?php

use App\User;

return [
    'get' => [
        'class' => null,
        'title' => 'users',
        'breadcrumbs' => ['users' => null],

        'blocks' => [
            [
                'class' => 'col-lg-12',

                'title' => [
                    'text' => 'users',
                    'add' => true,
                    'search' => true
                ],

                'content' => [
                    'type' => 'table',
                    'pagination' => true,
                    'modal' => true,
                    'edit' => true,
                    'delete' => true,
                    'rows' => function () {
                        $userClass = config('hush.app.user.model');
                        return (new $userClass)->paginate();
                    },
                    'columns' => [
                        'id' => ['sortable', 'searchable'],
                        'name' => ['sortable', 'searchable']
                    ],
                    'actions' => [
                        [
                            'icon' => 'remove_red_eye',
                            'text' => 'show'
                        ]
                    ],
                ]

            ]
        ]
    ],

    'delete' => [

        'delete' => [
            'rules' => [],
            'closure' => function () {
                User::where('id', request()->id)->delete();

                return [
                    'status' => 'success',
                    'reload' => true,
                    'swal' => [
                        'title' => 'Deleted',
                        'text' => 'User was deleted successfully',
                        'type' => 'success'
                    ]
                ];
            }
        ],

    ]
];
