<?php
use  System\Application;

$app = Application::getInstance();
//admin routes
$app->route->add('/admin/login', 'Admin/Login');
$app->route->add('/admin/login/submit','Admin/Login@submit', 'POST');
$app->route->add('/', 'Home');

// /admin => users
$app->route->add('/admin/users','Admin/Users');
$app->route->add('/admin/users/add','Admin/Users@add');
$app->route->add('/admin/users/submit','Admin/Users@submit', '@POST');
$app->route->add('/admin/users/edit/:id','Admin/Users@edit');
$app->route->add('/admin/users/edit/save','Admin/Users@save');
$app->route->add('/admin/users/delete/:id','Admin/Users@delete');

// /admin => users-groups
$app->route->add('/admin/users-groups','Admin/UsersGroups');
$app->route->add('/admin/users-groups/add','Admin/UsersGroups@add');
$app->route->add('/admin/users-groups/submit','Admin/UsersGroups@submit', '@POST');
$app->route->add('/admin/users-groups/edit/:id','Admin/UsersGroups@edit');
$app->route->add('/admin/users-groups/edit/save','Admin/UsersGroups@save', 'POST');
$app->route->add('/admin/users-groups/delete/:id','Admin/UsersGroups@delete');

// /admin => posts
$app->route->add('/admin/posts','Admin/Posts');
$app->route->add('/admin/posts/add','Admin/Posts@add');
$app->route->add('/admin/posts/submit','Admin/Posts@submit', '@POST');
$app->route->add('/admin/posts/edit/:id','Admin/Posts@edit');
$app->route->add('/admin/posts/edit/save','Admin/Posts@save','POST');
$app->route->add('/admin/posts/delete/:id','Admin/Posts@delete');

// /admin => comments
$app->route->add('/admin/post/:id/comments','Admin/Comments');
$app->route->add('/admin/comments/add','Admin/Comments@add');
$app->route->add('/admin/comments/submit','Admin/Comments@submit', '@POST');
$app->route->add('/admin/comments/edit/:id','Admin/Comments@edit');
$app->route->add('/admin/comments/edit/save','Admin/Comments@save', 'POST');
$app->route->add('/admin/comments/delete/:id','Admin/Comments@delete');

// /admin => categories
$app->route->add('/admin/categories','Admin/Categories');
$app->route->add('/admin/categories/add','Admin/Categories@add');
$app->route->add('/admin/categories/submit','Admin/Categories@submit', '@POST');
$app->route->add('/admin/categories/edit/:id','Admin/Categories@edit');
$app->route->add('/admin/categories/edit/save','Admin/Categories@save', 'POST');
$app->route->add('/admin/categories/delete/:id','Admin/Categories@delete');

// /admin => settings
$app->route->add('/admin/settings','Admin/Settings');
$app->route->add('/admin/settings/edit/save','Admin/Settings@save', 'POST');

// /admin => contacs
$app->route->add('/admin/contacs','Admin/Contacs');
$app->route->add('/admin/contacs/reply/:id','Admin/Contacs@reply');
$app->route->add('/admin/contacs/send/:id','Admin/Contacs@send', '@POST');

// /admin => ads
$app->route->add('/admin/ads','Admin/Ads');
$app->route->add('/admin/ads/add','Admin/Ads@add');
$app->route->add('/admin/ads/submit','Admin/Ads@submit', '@POST');
$app->route->add('/admin/ads/edit/:id','Admin/Ads@edit');
$app->route->add('/admin/ads/edit/save','Admin/Ads@save', 'POST');
$app->route->add('/admin/ads/delete/:id','Admin/Ads@delete');


// Dashboard routes
$app->route->add('/admin','Admin/Dashboard');
$app->route->add('/admin/dashboard','Admin/Dashboard');

//logout
$app->route->add('/logout','Logout');


//notfound page
$app->route->add('/404','Error/NotFound');
$app->route->notFound('/404');

