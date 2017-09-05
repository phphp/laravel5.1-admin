<?php

Route::get('/', function () {
    return view('welcome');
});


// ------------------ OAuth ---------------------
Route::group([
    'prefix'        => 'oauth',
    'namespace'     => 'Auth',
    ], function () {
        Route::get('{provider}', [
            'as'            => 'redirect_to_provider',
            'uses'          => 'OAuthController@redirectToProvider'
            ])->where('provider', 'github');
        Route::get('{provider}/callback', [
            'as'            => 'handle_provider_callback',
            'uses'          => 'OAuthController@handleProviderCallback'
            ])->where('provider', 'github');
    });


// ------------------ 重置密码 ---------------------
Route::group([
    'prefix'        => 'password',
    'namespace'     => 'Auth'
    ], function () {
        Route::get('email', [
            'as'            => 'password_get_email',
            'uses'          => 'PasswordController@getEmail'
            ]);
        Route::post('email', [
            'as'            => 'password_post_email',
            'middleware'    => 'attempt:3',
            'uses'          => 'PasswordController@postEmail'
            ]);
        Route::get('reset/{token}', [
            'as'            => 'password_get_reset',
            'uses'          => 'PasswordController@getReset'
            ]);
        Route::post('reset', [
            'as'            => 'password_post_reset',
            'uses'          => 'PasswordController@postReset'
            ]);
    });


// ------------------ 后台登录 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin'
    ], function () {
        // 登陆页面
        Route::get('login', [
            'as'            => 'admin_login_page',
            'uses'          => 'LoginController@loginPage'
            ]);
        // 登陆验证
        Route::post('login', [
            'as'            => 'admin_login_auth',
            'middleware'    => 'attempt:5',
            'uses'          => 'LoginController@loginAuth'
            ]);
        // 登出
        Route::get('logout/{token}', [
            'as'            => 'admin_logout',
            'middleware'    => 'checkUrlCsrfToken:token',
            'uses'          => 'LoginController@logout'
            ]);
        // 后台验证码
        Route::get('captcha', [
            'as'            => 'admin_login_captcha',
            'uses'          => 'LoginController@captcha'
            ]);
    });


// ------------------ 后台首页 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => 'adminAuth'
    ], function () {
        Route::get('home', [
            'as'            => 'dashboard_homepage',
            'uses'          => 'DashboardController@index'
            ]);
    });

// ------------------ 权限管理 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => ['adminAuth', 'checkAdminPermission']
    ], function () {
        // role
        Route::get('role', [
            'as'            => 'role_index',
            'uses'          => 'RoleController@index'
            ]);
        Route::get('role/create', [
            'as'            => 'role_create',
            'uses'          => 'RoleController@create'
            ]);
        Route::post('role', [
            'as'            => 'role_store',
            'uses'          => 'RoleController@store'
            ]);
        Route::get('role/{id}', [
            'as'            => 'role_show',
            'uses'          => 'RoleController@show'
            ]);
        Route::get('role/{id}/edit', [
            'as'            => 'role_edit',
            'uses'          => 'RoleController@edit'
            ]);
        Route::post('role/{id}', [
            'as'            => 'role_update',
            'uses'          => 'RoleController@update'
            ]);
        Route::delete('role/{id}', [
            'as'            => 'role_destroy',
            'uses'          => 'RoleController@destroy'
            ]);

        // permission
        Route::get('permission', [
            'as'            => 'permission_index',
            'uses'          => 'PermissionController@index'
            ]);
        Route::get('permission/create', [
            'as'            => 'permission_create',
            'uses'          => 'PermissionController@create'
            ]);
        Route::post('permission', [
            'as'            => 'permission_store',
            'uses'          => 'PermissionController@store'
            ]);
        Route::get('permission/{id}', [
            'as'            => 'permission_show',
            'uses'          => 'PermissionController@show'
            ]);
        Route::get('permission/{id}/edit', [
            'as'            => 'permission_edit',
            'uses'          => 'PermissionController@edit'
            ]);
        Route::post('permission/{id}', [
            'as'            => 'permission_update',
            'uses'          => 'PermissionController@update'
            ]);
        Route::delete('permission/{id}', [
            'as'            => 'permission_destroy',
            'uses'          => 'PermissionController@destroy'
            ]);

        Route::get('role/update-roles-cache', [
            'as'            => 'update_roles_cache',
            'uses'          => 'RoleController@updateCache'
            ]);

    });


// ------------------ 用户管理 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => ['adminAuth', 'checkAdminPermission']
    ], function () {
        Route::get('user', [
            'as'            => 'user_index',
            'uses'          => 'UserController@index'
            ]);
        Route::get('user/create', [
            'as'            => 'user_create',
            'uses'          => 'UserController@create'
            ]);
        Route::post('user', [
            'as'            => 'user_store',
            'uses'          => 'UserController@store'
            ]);
        Route::get('user/search', [
            'as'            => 'admin_user_search',
            'uses'          => 'UserController@search'
            ]);
        Route::get('user/{id}', [
            'as'            => 'user_show',
            'uses'          => 'UserController@show'
            ]);
        Route::get('user/{id}/edit', [
            'as'            => 'user_edit',
            'uses'          => 'UserController@edit'
            ]);
        Route::patch('user/{id}', [
            'as'            => 'user_update',
            'uses'          => 'UserController@update'
            ]);
        Route::delete('user/{id}', [
            'as'            => 'user_destroy',
            'uses'          => 'UserController@destroy'
            ]);

        Route::get('profile', [
            'as'            => 'admin_profile',
            'uses'          => 'UserController@profile'
            ]);
        Route::patch('profile', [
            'as'            => 'admin_profile_update',
            'uses'          => 'UserController@updateProfile'
            ]);

        Route::get('user/oauth', [
            'as'            => 'oauth_user',
            'uses'          => 'UserController@oauth'
            ]);
        Route::get('user/oauth/{id}/edit', [
            'as'            => 'oauth_user_edit',
            'uses'          => 'UserController@oauthEdit'
            ]);
        Route::patch('user/oauth/{id}', [
            'as'            => 'oauth_user_update',
            'uses'          => 'UserController@oauthUpdate'
            ]);
        Route::delete('user/oauth/{id}', [
            'as'            => 'oauth_user_destroy',
            'uses'          => 'UserController@oauthDestroy'
            ]);
    });

// ------------------ Ajax ---------------------
Route::group([
    'prefix'        => 'admin/ajax',
    'namespace'     => 'Admin',
    'middleware'    => 'adminAuth'
    ], function () {
        Route::post('sort-role', [
            'as'            => 'admin_ajax_sort_role',
            'uses'          => 'AjaxController@sortRole'
            ]);
        Route::post('sort-permission', [
            'as'            => 'admin_ajax_sort_permission',
            'uses'          => 'AjaxController@sortPermission'
            ]);
        Route::post('sort-category', [
            'as'            => 'admin_ajax_sort_category',
            'uses'          => 'AjaxController@sortCategory'
            ]);
    });

// ------------------ 文件管理 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => ['adminAuth', 'checkAdminPermission']
    ], function () {
        Route::get('filesystem', [
            'as'            => 'admin_filesystem',
            'uses'          => 'FileController@index'
            ]);
        Route::post('filesystem/create-directory', [
            'as'            => 'admin_filesystem_create_directory',
            'uses'          => 'FileController@createDirectory'
            ]);
        Route::post('filesystem/upload-file', [
            'as'            => 'admin_filesystem_ajax_upload',
            'uses'          => 'FileController@uploadFile'
            ]);
        Route::delete('filesystem/destory-directory', [
            'as'            => 'admin_filesystem_destory_directory',
            'uses'          => 'FileController@destroyDirectory'
            ]);
        Route::delete('filesystem/destory-file', [
            'as'            => 'admin_filesystem_destory_file',
            'uses'          => 'FileController@destoryFile'
            ]);
        Route::post('filesystem/move-directory', [
            'as'            => 'admin_filesystem_move_directory',
            'uses'          => 'FileController@moveDirectory'
            ]);
        Route::post('filesystem/move-file', [
            'as'            => 'admin_filesystem_move_file',
            'uses'          => 'FileController@moveFile'
            ]);
    });

// ------------------ 文章管理 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => ['adminAuth', 'checkAdminPermission']
    ], function () {
        Route::get('post', [
            'as'            => 'admin_post',
            'uses'          => 'PostController@index'
            ]);
        Route::get('post/create', [
            'as'            => 'admin_create_post',
            'uses'          => 'PostController@create'
            ]);
        Route::post('post/store', [
            'as'            => 'admin_store_post',
            'uses'          => 'PostController@store'
            ]);
        Route::get('post/show/{id}', [
            'as'            => 'admin_show_post',
            'uses'          => 'PostController@show'
            ]);
        Route::get('post/{id}/edit', [
            'as'            => 'admin_edit_post',
            'uses'          => 'PostController@edit'
            ]);
        Route::post('post/update/{id}', [
            'as'            => 'admin_update_post',
            'uses'          => 'PostController@update'
            ]);
        Route::delete('post/destroy/{id}', [
            'as'            => 'admin_destroy_post',
            'uses'          => 'PostController@destroy'
            ]);
    });

// ------------------ 文章 category ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => 'adminAuth'
    ], function () {
        Route::get('category', [
            'as'            => 'admin_category',
            'uses'          => 'CategoryController@index'
            ]);
        Route::get('category/create', [
            'as'            => 'admin_create_category',
            'uses'          => 'CategoryController@create'
            ]);
        Route::post('category/store', [
            'as'            => 'admin_store_category',
            'uses'          => 'CategoryController@store'
            ]);
        Route::get('category/show/{id}', [
            'as'            => 'admin_show_category',
            'uses'          => 'CategoryController@show'
            ]);
        Route::get('category/{id}/edit', [
            'as'            => 'admin_edit_category',
            'uses'          => 'CategoryController@edit'
            ]);
        Route::post('category/update/{id}', [
            'as'            => 'admin_update_category',
            'uses'          => 'CategoryController@update'
            ]);
        Route::delete('category/destroy/{id}', [
            'as'            => 'admin_destroy_category',
            'uses'          => 'CategoryController@destroy'
            ]);
    });

// ------------------ 文章 tag ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => 'adminAuth'
    ], function () {
        Route::get('tag', [
            'as'        => 'admin_tag',
            'uses'      => 'TagController@index'
            ]);
        Route::get('tag/create', [
            'as'        => 'admin_create_tag',
            'uses'      => 'TagController@create'
            ]);
        Route::post('tag/store', [
            'as'        => 'admin_store_tag',
            'uses'      => 'TagController@store'
            ]);
        Route::get('tag/show/{id}', [
            'as'        => 'admin_show_tag',
            'uses'      => 'TagController@show'
            ]);
        Route::get('tag/{id}/edit', [
            'as'        => 'admin_edit_tag',
            'uses'      => 'TagController@edit'
            ]);
        Route::post('tag/update/{id}', [
            'as'        => 'admin_update_tag',
            'uses'      => 'TagController@update'
            ]);
        Route::delete('tag/destroy/{id}', [
            'as'        => 'admin_destroy_tag',
            'uses'      => 'TagController@destroy'
            ]);
        Route::post('tag/ajax/store', [
            'as'        => 'admin_ajax_store_tag',
            'uses'      => 'TagController@ajaxStore'
            ]);
    });


// ------------------ 日志 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => 'adminAuth'
    ], function () {
        Route::get('logs', [
            'as'        => 'admin_logs',
            'uses'      => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index'
            ]);
    });


// ------------------ 队列 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => 'adminAuth'
    ], function () {
        Route::get('queues', [
            'as'        => 'admin_queues',
            'uses'      => 'QueueController@index'
            ]);
        Route::get('queues-failed', [
            'as'        => 'admin_queues_failed',
            'uses'      => 'QueueController@failed'
            ]);
    });


// ------------------ 网站设置 ---------------------
Route::group([
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
    'middleware'    => ['adminAuth', 'checkAdminPermission']
    ], function () {
        Route::get('config', [
            'as'        => 'admin_config',
            'uses'      => 'ConfigController@index'
            ]);
        Route::post('config/update/{file}', [
            'as'        => 'admin_config_update',
            'uses'      => 'ConfigController@update'
            ]);
    });







































Event::listen('illuminate.query', function($sql, $bindings, $time) {
    $count = Config::get('admin.COUNT');
    $timeSum = Config::get('admin.TIME');
    Config::set( 'admin.COUNT', ++$count );
    Config::set( 'admin.SQL', Config::get('admin.SQL') . "\n[NO.$count] ".json_encode($bindings)." [".$time." ms]: \n" . $sql . "\n" );
    Config::set( 'admin.TIME', $timeSum+$time );
});


