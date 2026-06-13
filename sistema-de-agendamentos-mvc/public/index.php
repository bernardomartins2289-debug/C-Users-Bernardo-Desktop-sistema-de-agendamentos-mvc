<?php
declare(strict_types=1);

define('ROOT', dirname(__DIR__));

require_once ROOT . '/app/Core/Database.php';
require_once ROOT . '/app/Core/Session.php';
require_once ROOT . '/app/Core/Controller.php';
require_once ROOT . '/app/Core/Router.php';

require_once ROOT . '/app/Models/User.php';
require_once ROOT . '/app/Models/Appointment.php';
require_once ROOT . '/app/Models/StandardAppointment.php';
require_once ROOT . '/app/Models/UrgentAppointment.php';
require_once ROOT . '/app/Models/ProfessionalAppointment.php';
require_once ROOT . '/app/Models/AppointmentFactory.php';
require_once ROOT . '/app/Models/AppointmentRepository.php';

require_once ROOT . '/app/Controllers/AuthController.php';
require_once ROOT . '/app/Controllers/AppointmentController.php';

Session::start();

$router = new Router();

$router->get('/',          'AuthController@showLogin');
$router->get('/login',     'AuthController@showLogin');
$router->post('/login',    'AuthController@login');
$router->get('/register',  'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout',    'AuthController@logout');

$router->get('/dashboard',                         'AppointmentController@index');
$router->get('/appointments/create',               'AppointmentController@create');
$router->post('/appointments',                     'AppointmentController@store');
$router->get('/appointments/{id}/edit',            'AppointmentController@edit');
$router->post('/appointments/{id}/update',         'AppointmentController@update');
$router->post('/appointments/{id}/delete',         'AppointmentController@destroy');

$router->dispatch();
