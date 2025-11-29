<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/helpers.php';

// Start session early so controllers/views can rely on it
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Simple CSRF enforcement:
// - For JSON POST requests, expect header X-CSRF-Token
// - For form POST requests, expect a hidden input named csrf_token
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
// Simple CSRF enforcement (configurable):
// - For JSON POST requests, expect header X-CSRF-Token
// - For form POST requests, expect a hidden input named csrf_token
// Use config constants `ENFORCE_CSRF` and `CSRF_EXEMPT_PREFIXES` to control behavior.
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

$enforceCsrf = defined('ENFORCE_CSRF') ? ENFORCE_CSRF : true;
$exemptPrefixes = defined('CSRF_EXEMPT_PREFIXES') ? CSRF_EXEMPT_PREFIXES : [];
$isExempt = false;
foreach ($exemptPrefixes as $prefix) {
    if ($prefix !== '' && strpos($requestPath, $prefix) === 0) {
        $isExempt = true;
        break;
    }
}

if ($method === 'POST' && $enforceCsrf && !$isExempt) {
    if (stripos($contentType, 'application/json') !== false) {
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
    } else {
        $token = $_POST['csrf_token'] ?? null;
    }
    if (!$token || !verify_csrf($token)) {
        http_response_code(400);
        echo "Invalid CSRF token";
        exit;
    }
}

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
$router->get('/admin/login', 'AuthController@adminLogin');
$router->post('/admin/login', 'AuthController@adminLoginPost');
$router->get('/admin_login', 'AuthController@adminLogin'); // alternatif yol
$router->post('/admin_login', 'AuthController@adminLoginPost');
$router->get('/admin/problems', 'AdminController@problems');
$router->get('/admin/problems/create', 'AdminController@createProblem');
$router->post('/admin/problems/store', 'AdminController@storeProblem');
$router->get('/admin/problems/{id}/edit', 'AdminController@editProblem');
$router->post('/admin/problems/update', 'AdminController@updateProblem');
$router->post('/admin/problems/delete', 'AdminController@deleteProblem');

// Admin Users
$router->get('/admin/users', 'AdminController@manageUsers');
$router->post('/admin/users/update-role', 'AdminController@updateUserRole');
$router->post('/admin/users/delete', 'AdminController@deleteUser');

// Admin Badges
$router->get('/admin/badges', 'AdminController@manageBadges');
$router->get('/admin/badges/create', 'AdminController@createBadge');
$router->post('/admin/badges/store', 'AdminController@storeBadge');
$router->get('/admin/badges/{id}/edit', 'AdminController@editBadge');
$router->post('/admin/badges/update', 'AdminController@updateBadge');
$router->post('/admin/badges/delete', 'AdminController@deleteBadge');

// Admin Tournaments
$router->get('/admin/tournaments', 'AdminController@manageTournaments');
$router->get('/admin/tournaments/create', 'AdminController@createTournament');
$router->post('/admin/tournaments/store', 'AdminController@storeTournament');
$router->get('/admin/tournaments/{id}/edit', 'AdminController@editTournament');
$router->post('/admin/tournaments/update', 'AdminController@updateTournament');
$router->post('/admin/tournaments/delete', 'AdminController@deleteTournament');

// Admin Forum
$router->get('/admin/forum', 'AdminController@forumThreads');
$router->post('/admin/forum/toggle', 'AdminController@toggleThread');
$router->post('/admin/forum/delete', 'AdminController@deleteThread');

// Profile
$router->get('/profile', 'ProfileController@index');
$router->get('/profile/{id}', 'ProfileController@show');

// Follow actions
$router->post('/follow', 'FollowController@follow');
$router->post('/unfollow', 'FollowController@unfollow');

// Learning Paths
$router->get('/paths', 'LearningPathController@index');
$router->get('/path/{id}', 'LearningPathController@show');
$router->post('/path/{id}/steps/toggle', 'LearningPathController@toggleStep');
$router->post('/path/{id}/remind', 'LearningPathController@remind');

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
