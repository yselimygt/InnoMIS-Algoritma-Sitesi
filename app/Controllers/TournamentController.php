<?php

require_once __DIR__ . '/../Models/TournamentModel.php';

class TournamentController extends Controller {
    public function index() {
        $model = new TournamentModel();
        $tournaments = $model->getAll();
        $this->view('tournaments/index', ['tournaments' => $tournaments]);
    }

    public function show($id) {
        $model = new TournamentModel();
        $tournament = $model->getById($id);
        $participants = $model->getParticipants($id);
        
        $this->view('tournaments/show', ['tournament' => $tournament, 'participants' => $participants]);
    }

    public function join() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $tournamentId = $_POST['tournament_id'];
        $userId = $_SESSION['user_id'];

        $model = new TournamentModel();
        if ($model->joinTournament($tournamentId, $userId)) {
            $this->redirect("/tournament/$tournamentId");
        } else {
            die("Could not join tournament (maybe already joined or full)");
        }
    }
}
