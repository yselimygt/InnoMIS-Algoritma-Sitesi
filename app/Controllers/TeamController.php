<?php

require_once __DIR__ . '/../Models/TeamModel.php';

class TeamController extends Controller {
    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $model = new TeamModel();
        $team = $model->getUserTeam($userId);

        if ($team) {
            $members = $model->getTeamMembers($team['id']);
            $this->view('teams/show', ['team' => $team, 'members' => $members]);
        } else {
            $this->view('teams/index');
        }
    }

    public function create() {
        $this->view('teams/create');
    }

    public function store() {
        session_start();
        $userId = $_SESSION['user_id'];
        
        $name = $_POST['name'];
        $description = $_POST['description'];
        
        $model = new TeamModel();
        if ($model->createTeam($name, $description, $userId)) {
            $this->redirect('/teams');
        } else {
            die("Error creating team");
        }
    }

    public function join() {
        session_start();
        $userId = $_SESSION['user_id'];
        $inviteCode = $_POST['invite_code'];
        
        $model = new TeamModel();
        if ($model->joinTeam($inviteCode, $userId)) {
            $this->redirect('/teams');
        } else {
            die("Invalid invite code or already in a team");
        }
    }
}
