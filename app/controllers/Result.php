<?php 

class Result extends Controller {
	public function __construct() {
		if (!isAdminLoggedIn()) {
			redirect('login/admin');
		}
		if (isVoterLoggedIn()) {
			redirect('voters');
		}
		$this->resultModel = $this->model('AdminModel');
	}

	//results
	public function index() {
		if ($_SESSION['role'] != 'superadmin') {
			redirect('voter');
		}
		$votenum = $this->resultModel->getVoters();
		$cannum = $this->resultModel->getCandidates();
		$votesResult = $this->resultModel->votesResult();
		$totalVotes = $this->resultModel->totalVotes();
		$data = [
			'votenum' => $votenum,
			'cannum' => $cannum,
			'username' => $_SESSION['username'],
			'password' => $_SESSION['password'],
			'firstname' => $_SESSION['firstname'],
			'lastname' => $_SESSION['lastname'],
			'photo' => $_SESSION['photo'],
			'created_on' => $_SESSION['created_on'],
			'votesResult' => $votesResult,
			'totalVotes' => $totalVotes
		];
		$this->view('result/index', $data);
	}

	//method to reset the votes
	public function reset() {
		$votenum = $this->resultModel->getVoters();
		$cannum = $this->resultModel->getCandidates();
		$votesResult = $this->resultModel->votesResult();
		$totalVotes = $this->resultModel->totalVotes();
		$data = [
			'votenum' => $votenum,
			'cannum' => $cannum,
			'username' => $_SESSION['username'],
			'password' => $_SESSION['password'],
			'firstname' => $_SESSION['firstname'],
			'lastname' => $_SESSION['lastname'],
			'photo' => $_SESSION['photo'],
			'role' => $_SESSION['role'],
			'created_on' => $_SESSION['created_on'],
			'votesResult' => $votesResult,
			'totalVotes' => $totalVotes
		];
		if ($this->resultModel->deleteVotes() && $this->resultModel->changeStat()) {
			 flash('reset_success', 'All votes have been deleted!');
			 redirect('result');
		}
		else {
			die('Something went wrong');
		}
		$this->view('result/index', $data);
	}
	
	//print result
	public function print() {
		if ($_SESSION['role'] != 'superadmin') {
			redirect('voter');
		}
		$votenum = $this->resultModel->getVoters();
		$cannum = $this->resultModel->getCandidates();
		$votes = $this->resultModel->getVotes();
		$getPositionsAsc = $this->resultModel->getPositionsAsc();
		$winner = $this->resultModel->countDept();
		$group = $this->resultModel->groupProg();
		$winnersDesc = $this->resultModel->winnersDesc();
		$stud = $this->resultModel->groupStud();
		$getWinners = $this->resultModel->getWinners();
		$data = [
			'winnersDesc' => $winnersDesc,
			'stud' => $stud,
			'getpos' => $getPositionsAsc,
			'winners' => $getWinners,
			'grp' => $group,
			'activeDept' => $winner,
			'votes' => $votes,
			'votenum' => $votenum,
			'cannum' => $cannum,
			'username' => $_SESSION['username'],
			'password' => $_SESSION['password'],
			'firstname' => $_SESSION['firstname'],
			'lastname' => $_SESSION['lastname'],
			'photo' => $_SESSION['photo'],
			'created_on' => $_SESSION['created_on']
		];
		$this->view('result/print', $data);
	}
}

?>