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

/* ─────────── Admin (session-based) ─────────── */
$router->get('/admin',            'AdminController@index');
$router->get('/admin/login',      'AdminController@loginForm');
$router->post('/admin/login',     'AdminController@login');
$router->post('/admin/logout',    'AdminController@logout');

$router->group(['prefix' => '/admin', 'middleware' => ['AdminMiddleware']], function($r) {
    $r->get('/dashboard',           'AdminController@dashboard');

    $r->get('/properties',          'AdminController@properties');
    $r->get('/properties/create',   'AdminController@propertyCreate');
    $r->post('/properties',         'AdminController@propertyStore');
    $r->get('/properties/{id}/edit','AdminController@propertyEdit');
    $r->post('/properties/{id}',    'AdminController@propertyUpdate');
    $r->post('/properties/{id}/delete', 'AdminController@propertyDelete');

    $r->get('/leads',               'AdminController@leads');
    $r->post('/leads/{id}/status',  'AdminController@leadStatus');
    $r->get('/leads/export',        'AdminController@leadsExport');

    $r->get('/blogs',               'AdminController@blogs');
    $r->get('/blogs/create',        'AdminController@blogCreate');
    $r->post('/blogs',              'AdminController@blogStore');
    $r->get('/blogs/{id}/edit',     'AdminController@blogEdit');
    $r->post('/blogs/{id}',         'AdminController@blogUpdate');
    $r->post('/blogs/{id}/delete',  'AdminController@blogDelete');

    $r->get('/testimonials',        'AdminController@testimonials');
    $r->post('/testimonials',       'AdminController@testimonialStore');
    $r->post('/testimonials/{id}/delete', 'AdminController@testimonialDelete');

    $r->get('/gallery',             'AdminController@gallery');
    $r->post('/gallery',            'AdminController@galleryStore');
    $r->post('/gallery/{id}/delete','AdminController@galleryDelete');

    $r->get('/careers',             'AdminController@careers');
    $r->post('/careers',            'AdminController@careerStore');

    $r->get('/settings',            'AdminController@settings');
    $r->post('/settings',           'AdminController@settingsUpdate');

    $r->get('/popups',              'AdminController@popups');
    $r->post('/popups',             'AdminController@popupStore');
});
