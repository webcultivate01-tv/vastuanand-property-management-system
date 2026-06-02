<?php
/** @var \App\Core\Router $router */
$router = \App\Core\App::$router;

/* ─────────── Public site ─────────── */
$router->get('/',                  'HomeController@index');
$router->get('/about',             'PageController@about');
$router->get('/services',          'PageController@services');
$router->get('/services/{slug}',   'PageController@serviceDetail');
$router->get('/property-management','PageController@propertyManagement');
$router->get('/commercial',        'PageController@commercial');
$router->get('/luxury-homes',      'PageController@luxuryHomes');
$router->get('/nri',               'PageController@nri');
$router->get('/careers',           'PageController@careers');
$router->get('/faq',               'PageController@faq');
$router->get('/privacy',           'PageController@privacy');
$router->get('/terms',             'PageController@terms');
$router->get('/gallery',           'PageController@gallery');
$router->get('/testimonials',      'PageController@testimonials');

$router->get('/properties',                   'PropertyController@index');
$router->get('/properties/buy',               'PropertyController@buy');
$router->get('/properties/rent',              'PropertyController@rent');
$router->get('/properties/commercial',        'PropertyController@commercial');
$router->get('/property/{slug}',              'PropertyController@show');

$router->get('/blog',          'BlogController@index');
$router->get('/blog/{slug}',   'BlogController@show');

$router->get('/contact',       'ContactController@index');
$router->post('/contact',      'ContactController@submit');
$router->post('/inquiry',      'ContactController@inquiry');
$router->post('/schedule-visit','ContactController@scheduleVisit');
$router->post('/newsletter',   'ContactController@newsletter');
$router->post('/property-access','ContactController@propertyAccess');
$router->post('/reviews',        'ContactController@submitReview');

/* ─────────── Admin (session-based) ─────────── */
$router->get('/admin',            'AdminController@index');
$router->get('/admin/login',      'AdminController@loginForm');
$router->post('/admin/login',     'AdminController@login');
$router->post('/admin/logout',    'AdminController@logout');

$router->group(['prefix' => '/admin', 'middleware' => ['AdminMiddleware']], function($r) {
    $r->get('/dashboard',           'AdminController@dashboard');

    $r->get('/profile',             'AdminController@profile');
    $r->post('/profile',            'AdminController@profileUpdate');

    $r->get('/search',              'AdminController@search');

    $r->get('/properties/export',   'AdminController@propertiesExport');
    $r->get('/blogs/export',        'AdminController@blogsExport');

    $r->get('/properties',          'AdminController@properties');
    $r->get('/properties/create',   'AdminController@propertyCreate');
    $r->post('/properties',         'AdminController@propertyStore');
    $r->get('/properties/{id}/edit','AdminController@propertyEdit');
    $r->post('/properties/{id}',    'AdminController@propertyUpdate');
    $r->post('/properties/{id}/delete', 'AdminController@propertyDelete');

    $r->get('/leads',               'AdminController@leads');
    $r->post('/leads/{id}/status',  'AdminController@leadStatus');
    $r->get('/leads/export',        'AdminController@leadsExport');

    $r->get('/subscribers',              'AdminController@subscribers');
    $r->get('/subscribers/export',       'AdminController@subscribersExport');
    $r->post('/subscribers/{id}/delete', 'AdminController@subscriberDelete');

    $r->get('/blogs',               'AdminController@blogs');
    $r->get('/blogs/create',        'AdminController@blogCreate');
    $r->post('/blogs',              'AdminController@blogStore');
    $r->get('/blogs/{id}/edit',     'AdminController@blogEdit');
    $r->post('/blogs/{id}',         'AdminController@blogUpdate');
    $r->post('/blogs/{id}/delete',  'AdminController@blogDelete');

    $r->get('/testimonials',        'AdminController@testimonials');
    $r->post('/testimonials',       'AdminController@testimonialStore');
    $r->post('/testimonials/{id}/approve', 'AdminController@testimonialApprove');
    $r->post('/testimonials/{id}/unapprove','AdminController@testimonialUnapprove');
    $r->post('/testimonials/{id}/delete', 'AdminController@testimonialDelete');

    $r->get('/settings',            'AdminController@settings');
    $r->post('/settings',           'AdminController@settingsUpdate');

    $r->get('/events',                 'AdminController@events');
    $r->get('/events/create',          'AdminController@eventCreate');
    $r->post('/events',                'AdminController@eventStore');
    $r->get('/events/{id}/edit',       'AdminController@eventEdit');
    $r->post('/events/{id}',           'AdminController@eventUpdate');
    $r->post('/events/{id}/delete',    'AdminController@eventDelete');
    $r->get('/events/export',          'AdminController@eventsExport');

    $r->get('/users',                  'AdminController@users');
    $r->get('/users/export',           'AdminController@usersExport');
    $r->get('/users/{id}',             'AdminController@userShow');
    $r->post('/users/{id}/delete',     'AdminController@userDelete');

    $r->get('/filters',                'AdminController@filters');
    $r->get('/filters/create',         'AdminController@filterCreate');
    $r->post('/filters',               'AdminController@filterStore');
    $r->get('/filters/{id}/edit',      'AdminController@filterEdit');
    $r->post('/filters/{id}',          'AdminController@filterUpdate');
    $r->post('/filters/{id}/delete',   'AdminController@filterDelete');

    $r->get('/admins',              'AdminController@admins');
    $r->get('/admins/create',       'AdminController@adminCreate');
    $r->post('/admins',             'AdminController@adminStore');
    $r->get('/admins/{id}/edit',    'AdminController@adminEdit');
    $r->post('/admins/{id}',        'AdminController@adminUpdate');
    $r->post('/admins/{id}/delete', 'AdminController@adminDelete');
});
