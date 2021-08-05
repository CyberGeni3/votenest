<?php  

class Officers extends Controller {
	public function __construct() {
		if (!isAdminLoggedIn()) {
			redirect('login/admin');
		}
		if (isVoterLoggedIn()) {
			redirect('voters');
		}
		$this->officerModel = $this->model('AdminModel');
	}

	/* Officer Methods */
	public function index() {
		if ($_SESSION['role'] != 'superadmin') {
			redirect('voter');
		}
		$getOfficers = $this->officerModel->getAdmins();
		$data = [
			'getOfficers' => $getOfficers,
			'username' => $_SESSION['username'],
			'password' => $_SESSION['password'],
			'firstname' => $_SESSION['firstname'],
			'lastname' => $_SESSION['lastname'],
			'photo' => $_SESSION['photo'],
			'created_on' => $_SESSION['created_on']
		];
		$this->view('officers/index', $data);
	}

	//add officer
	public function add() {
		if ($_SESSION['role'] != 'superadmin') {
			redirect('voter');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$getOfficers = $this->officerModel->getAdmins();
			$data = [
				'getOfficers' => $getOfficers,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'error' => '',
				'vfirstname' => ucwords($_POST['firstname']),
				'vlastname' => ucwords($_POST['lastname']),
				'file' => $_FILES['photo']['name']
			];
			$set = '123456789abcdefghijklmnopqrstuvwxyz';
			$username = substr(str_shuffle($set), 0,10);
			$password = password_hash("admin", PASSWORD_DEFAULT);
			if ($this->officerModel->addOfficer($data, $username, $password)) {
				if (!empty($data['file'])) {
					if(move_uploaded_file($_FILES['photo']['tmp_name'], 'C:/laragon/www/votingsystem/public/images/admin/'.$data['file'])) {
						flash('officer_success', 'Officer added successfully!');
						redirect('officers');
					}
					else {
						$data['error'] = 'Unable to add officer!';
						$this->view('officers/index', $data);
					}
				}
			}
		}
	}

	public function delete() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$getOfficers = $this->officerModel->getAdmins();
			$data = [
				'getOfficers' => $getOfficers,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'id' => $_POST['id'],
				'error' => ''
			];
			if ($this->officerModel->deleteOfcr($data['id'])) {
				flash('officer_success', 'Officer deleted!');
				redirect('officers');
			}
			else {
				$data['error'] = 'Something went wrong';
				$this->view('officers/index', $data);
			}
		}
	}

	//get officer row result by id
	public function offrow() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$id = $_POST['id'];
			$row = $this->officerModel->getOfficer($id);
		}
		echo json_encode($row);
	}
}

?>