<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Controller.php';

$router = new Router();

// Define Routes
$router->get('/', 'HomeController@index');

// Auth Routes
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@loginPost');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@registerPost');
$router->get('/logout', 'AuthController@logout');

// Problem Routes
$router->get('/problems', 'ProblemController@index');
$router->get('/problem/{slug}', 'ProblemController@show');
$router->post('/api/submit', 'ProblemController@submit');

// Leaderboard
$router->get('/leaderboard', 'LeaderboardController@index');

// Admin Routes
$router->get('/admin', 'AdminController@index');
$router->get('/admin/problems', 'AdminController@problems');
$router->get('/admin/problems/create', 'AdminController@createProblem');
$router->post('/admin/problems/store', 'AdminController@storeProblem');

// Profile
$router->get('/profile', 'ProfileController@index');

// Learning Paths
$router->get('/paths', 'LearningPathController@index');
$router->get('/path/{id}', 'LearningPathController@show');

// Teams
$router->get('/teams', 'TeamController@index');
$router->get('/teams/create', 'TeamController@create');
$router->post('/teams/store', 'TeamController@store');
$router->post('/teams/join', 'TeamController@join');

// Run Router
$router->resolve();
