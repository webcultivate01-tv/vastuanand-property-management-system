<?php
/** @var \App\Core\Router $router */
$router = \App\Core\App::$router;

$router->group(['prefix' => '/api/v1', 'middleware' => ['CorsMiddleware']], function ($r) {

    /* Auth */
    $r->post('/auth/login',    'Api\\AuthApi@login');
    $r->post('/auth/register', 'Api\\AuthApi@register');
    $r->post('/auth/refresh',  'Api\\AuthApi@refresh');
    $r->get('/auth/me',        'Api\\AuthApi@me',  ['AuthMiddleware']);

    /* Properties (public read) */
    $r->get('/properties',          'Api\\PropertyApi@index');
    $r->get('/properties/featured', 'Api\\PropertyApi@featured');
    $r->get('/properties/{slug}',   'Api\\PropertyApi@show');
    $r->get('/locations',           'Api\\PropertyApi@locations');

    /* Leads & forms (public write) */
    $r->post('/contact',         'Api\\LeadApi@contact');
    $r->post('/inquiry',         'Api\\LeadApi@inquiry');
    $r->post('/schedule-visit',  'Api\\LeadApi@scheduleVisit');
    $r->post('/newsletter',      'Api\\LeadApi@newsletter');
    $r->post('/chatbot',         'Api\\ChatbotApi@reply');
    $r->post('/calc/emi',        'Api\\CalculatorApi@emi');
    $r->post('/calc/roi',        'Api\\CalculatorApi@roi');

    /* Blog & content */
    $r->get('/blogs',         'Api\\ContentApi@blogs');
    $r->get('/blogs/{slug}',  'Api\\ContentApi@blog');
    $r->get('/testimonials',  'Api\\ContentApi@testimonials');
    $r->get('/gallery',       'Api\\ContentApi@gallery');
    $r->get('/faqs',          'Api\\ContentApi@faqs');

    /* Admin API */
    $r->group(['prefix' => '/admin', 'middleware' => ['AdminMiddleware']], function ($a) {
        $a->get('/stats',            'Api\\AdminApi@stats');
        $a->get('/leads',            'Api\\AdminApi@leads');
        $a->post('/leads/{id}',      'Api\\AdminApi@updateLead');
        $a->post('/properties',      'Api\\AdminApi@createProperty');
        $a->post('/properties/{id}', 'Api\\AdminApi@updateProperty');
        $a->post('/upload',          'Api\\AdminApi@upload');
    });
});
