<?php
/**
 * Basic Routes
 *
 * ===========================================
 */

$route = app()->route;

$route->add('/', 'Frontend/home/home');
$route->add('/home', 'Frontend/home/home');

/*Users URLs Group ===============================================*/
$optionsAdminGroupUsers = [
    'prefix'        => '/admin/users',
    'controller'    => 'Admin/users/',
    'middleware'    => ['Admin/Auth']
];
$route->group($optionsAdminGroupUsers, function($route) {
    $route->add('', 'users');
    $route->add('/get', 'users@getUsers', 'get|ajax');
    $route->add('/modal/:id', 'users@loadModal', 'get|ajax');
    $route->add('/add', 'users@add', 'post|ajax');
    $route->add('/edit/:id', 'users@edit', 'post|ajax');
    $route->add('/delete/:id', 'users@delete', 'post|ajax');
    $route->add('/view/:id', 'users@view', 'get|ajax');
});

/*Categories URLs Group ===============================================*/
$optionsAdminGroupCategories = [
    'prefix'        => '/admin/categories',
    'controller'    => 'Admin/categories/',
    'middleware'    => ['Admin/Auth']
];
$route->group($optionsAdminGroupCategories, function($route) {
    $route->add('', 'categories');
    $route->add('/save/:id', 'categories@save', 'post');
    $route->add('/edit/:id', 'categories@edit', 'get|ajax');
    $route->add('/delete/:id', 'categories@delete', 'get|ajax');
});


/*Posts URLs Group ===============================================*/
$optionsAdminGroupCategories = [
    'prefix'        => '/admin/posts',
    'controller'    => 'Admin/posts/',
    'middleware'    => ['Admin/Auth']
];
$route->group($optionsAdminGroupCategories, function($route) {
    $route->add('', 'posts');
    $route->add('/load/:text/:id', 'posts@load', 'get|ajax');
    $route->add('/add', 'posts@add', 'post|ajax');
    $route->add('/edit/:id', 'posts@edit', 'post|ajax');
    $route->add('/delete/:id', 'posts@delete', 'get|ajax');
});
/*Messages URLs Group ===============================================*/
$optionsAdminGroupCategories = [
    'prefix'        => '/admin/messages',
    'controller'    => 'Admin/messages/',
    'middleware'    => ['Admin/Auth']
];
$route->group($optionsAdminGroupCategories, function($route) {
    $route->add('', 'messages');
    $route->add('/delete/:id', 'messages@delete', 'get|ajax');
    $route->add('/view/:id', 'messages@view', 'get|ajax');
    $route->add('/reply/:id', 'messages@reply', 'post|ajax');
});

/*Roles URLs Group ===============================================*/
$optionsAdminGroupRolesPermissions = [
    'prefix'        => '/admin/roles',
    'controller'    => 'Admin/users_groups/',
    'middleware'    => ['Admin/Auth']
];
$route->group($optionsAdminGroupRolesPermissions, function($route) {
    $route->add('', 'roles');
    $route->add('/save/0', 'roles@add', 'post|ajax'); //add new role
    $route->add('/get/:id', 'roles@get', 'get|ajax'); //add new role
    $route->add('/save/:id', 'roles@edit', 'post|ajax'); //edit old role
    $route->add('/delete/:id', 'roles@delete', 'get|ajax'); //edit old role
});

/*Settings ==========================================================*/
$optionSettings = [
    'prefix'        => '/admin/settings',
    'controller'    => 'Admin/settings/',
    'middleware'    => ['Admin/Auth']
];
$route->group($optionSettings, function($route) {
    $route->add('', 'settings');
    $route->add('/save', 'settings@save', 'post|ajax');
});
/*Login URLs Group =================================  */
$optionsLoginGroup = [
    'prefix'        => '/admin',
    'controller'    => 'Admin/',
    'middleware'    => ['Admin/PreventLoginRoute']
];
$route->group($optionsLoginGroup, function ($route) {
    $route->add('', 'login/login');
    $route->add('/login', 'login/login');
    $route->add('/login/submit', 'login/login@submit', 'POST|ajax');
});

/*Dashboard URLs Group =================================== */
$optionsAdminGroup = [
    'prefix'        => '/admin',
    'controller'    => 'Admin/',
    'middleware'    => ['Admin/Auth']
];
$route->group($optionsAdminGroup, function($route) {
    $route->add('/logout', 'logout/logout');
    $route->add('/dashboard', 'dashboard/dashboard');
    $route->add('/profile', 'users/users@profile', 'get|ajax');
    $route->add('/admins/get', 'users/users@getAdmins', 'get|ajax');
    $route->add('/search/users', 'search/search@users', 'get|ajax');
    $route->add('/search/posts', 'search/search@posts', 'get|ajax');
    $route->add('/pagination/:text', 'pagination/pagination@index', 'get|ajax');
});
//pre($route->getRoutes());



