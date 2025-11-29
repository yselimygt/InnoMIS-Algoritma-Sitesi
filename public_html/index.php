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
$router->post('/api/run-test', 'ProblemController@runTest');

// Leaderboard
$router->get('/leaderboard', 'LeaderboardController@index');
$router->get('/api/leaderboard', 'LeaderboardController@api');

// Admin Routes
$router->get('/admin', 'AdminController@index');
$router->get('/admin/problems', 'AdminController@problems');
$router->get('/admin/problems/create', 'AdminController@createProblem');
$router->post('/admin/problems/store', 'AdminController@storeProblem');

// Admin Users
$router->get('/admin/users', 'AdminController@manageUsers');
$router->post('/admin/users/update-role', 'AdminController@updateUserRole');

// Admin Badges
$router->get('/admin/badges', 'AdminController@manageBadges');
$router->get('/admin/badges/create', 'AdminController@createBadge');
$router->post('/admin/badges/store', 'AdminController@storeBadge');

// Admin Tournaments
$router->get('/admin/tournaments', 'AdminController@manageTournaments');
$router->get('/admin/tournaments/create', 'AdminController@createTournament');
$router->post('/admin/tournaments/store', 'AdminController@storeTournament');

// Admin Forum
$router->get('/admin/forum', 'AdminController@forumThreads');
$router->post('/admin/forum/toggle', 'AdminController@toggleThread');

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

// Tournaments
$router->get('/tournaments', 'TournamentController@index');
$router->get('/tournament/{id}', 'TournamentController@show');
$router->post('/tournaments/join', 'TournamentController@join');

// Forum
$router->get('/forum', 'ForumController@index');
$router->get('/forum/olustur', 'ForumController@create');
$router->post('/forum', 'ForumController@store');
$router->get('/forum/{slug}', 'ForumController@show');
$router->post('/forum/{slug}/yorum', 'ForumController@comment');

// Notifications
$router->post('/api/notifications/read', 'NotificationController@markRead');
$router->post('/api/notifications/read-all', 'NotificationController@markAll');

// Run Router
$router->resolve();
