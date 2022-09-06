<?php
    return [
        'message' => [
            'user_login' => [
                'fail' => 'Unauthorized',
                'wrong' => 'Wrong credential'
            ],
            'user_register' => [
                'success' => 'Register successfully'
            ],
            'user_logout' => [
                'success' => 'Logout successfully'
            ],
            'user_add' => [
                'success' => 'Add user successfully',
                'fail'  => 'Add user fail'
            ],
            'user_update' => [
                'success' => 'Update user successfully',
                'fail'  => 'Update user fail',
                'missing' => 'Missing param Id',
                'not_found' => 'User not found'
            ]
        ],
        'status' => [
            'bad_request' => 400,
            'not_found' => 404,
            'success' => 200,
            'error' => 500
        ]
    ];
