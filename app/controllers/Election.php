<?php 

class Election extends Controller {
	public function __construct(){
		if (!isAdminLoggedIn()) {
			redirect('login/admin');
		}
		if (isVoterLoggedIn()) {
			redirect('voters');
		}
		$this->electionModel = $this->model('ElectionModel');
	}

	public function index(){
		if ($_SESSION['role'] != 'superadmin') {
			redirect('voter');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		}
	}
}
?>