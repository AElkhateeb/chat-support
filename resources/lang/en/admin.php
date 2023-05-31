<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'chat' => [
        'title' => 'Chats',

        'actions' => [
            'index' => 'Chats',
            'create' => 'New Chat',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'client_type' => 'Client type',
            'client_id' => 'Client',
            'sender_type' => 'Sender type',
            'sender_id' => 'Sender',
            'body' => 'Body',
            
        ],
    ],

    'message' => [
        'title' => 'Messages',

        'actions' => [
            'index' => 'Messages',
            'create' => 'New Message',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'dir' => 'Dir',
            'from' => 'From',
            'to' => 'To',
            'segments' => 'Segments',
            'status' => 'Status',
            'body' => 'Body',
            'media' => 'Media',
            'sender_type' => 'Sender type',
            'sender_id' => 'Sender',
            'client_type' => 'Client type',
            'client_id' => 'Client',
            'chat_id' => 'Chat',
            
        ],
    ],

    'client' => [
        'title' => 'Clients',

        'actions' => [
            'index' => 'Clients',
            'create' => 'New Client',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'phone' => 'Phone',
            'name' => 'Name',
            
        ],
    ],

    'post' => [
        'title' => 'Posts',

        'actions' => [
            'index' => 'Posts',
            'create' => 'New Post',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'customer' => [
        'title' => 'Customers',

        'actions' => [
            'index' => 'Customers',
            'create' => 'New Customer',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'phone' => 'Phone',
            'name' => 'Name',
            'opened' => 'Opened',
            
        ],
    ],

    'boot-admin' => [
        'title' => 'Boot Admins',

        'actions' => [
            'index' => 'Boot Admins',
            'create' => 'New Boot Admin',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'pattern' => 'Pattern',
            'previous' => 'Previous',
            'checked' => 'Checked',
            
        ],
    ],

    'income' => [
        'title' => 'Incomes',

        'actions' => [
            'index' => 'Incomes',
            'create' => 'New Income',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'income' => 'Income',
            'pattern_id' => 'Pattern',
            'replay_id' => 'Replay',
        ],
    ],

    'reply' => [
        'title' => 'Replies',

        'actions' => [
            'index' => 'Replies',
            'create' => 'New Reply',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'replay' => 'Replay',
            'pattern_id' => 'Pattern',
            
        ],
    ],

    'reply' => [
        'title' => 'Replies',

        'actions' => [
            'index' => 'Replies',
            'create' => 'New Reply',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'reply' => [
        'title' => 'Replies',

        'actions' => [
            'index' => 'Replies',
            'create' => 'New Reply',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'replay' => 'Replay',
            'pattern_id' => 'Pattern',
            
        ],
    ],

    'income' => [
        'title' => 'Incomes',

        'actions' => [
            'index' => 'Incomes',
            'create' => 'New Income',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'income' => [
        'title' => 'Incomes',

        'actions' => [
            'index' => 'Incomes',
            'create' => 'New Income',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'income' => 'Income',
            'pattern_id' => 'Pattern',
            
        ],
    ],

    'income' => [
        'title' => 'Incomes',

        'actions' => [
            'index' => 'Incomes',
            'create' => 'New Income',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'income' => [
        'title' => 'Incomes',

        'actions' => [
            'index' => 'Incomes',
            'create' => 'New Income',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'income' => 'Income',
            'pattern_id' => 'Pattern',
            
        ],
    ],

    'boot-admin' => [
        'title' => 'Boot Admins',

        'actions' => [
            'index' => 'Boot Admins',
            'create' => 'New Boot Admin',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'pattern' => 'Pattern',
            'stuff' => 'Stuff',
            'previous' => 'Previous',
            'checked' => 'Checked',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];