<?php  

class Positions extends Controller {
	public function __construct() {
		if (!isAdminLoggedIn()) {
			redirect('login/admin');
		}
		if (isVoterLoggedIn()) {
			redirect('voters');
		}
		$this->positionModel = $this->model('AdminModel');
	}

	/* 
		Position methods starts here
	*/
	public function index() {
		if ($_SESSION['role'] != 'superadmin') {
			redirect('voter');
		}
		$getPositions = $this->positionModel->getPositionsAsc();
		$data = [
			'getPositions' => $getPositions,
			'username' => $_SESSION['username'],
			'password' => $_SESSION['password'],
			'firstname' => $_SESSION['firstname'],
			'lastname' => $_SESSION['lastname'],
			'photo' => $_SESSION['photo'],
			'created_on' => $_SESSION['created_on']
		];
		$this->view('positions/index', $data);
	}

	//add position
	public function add() {
		$getPositions = $this->positionModel->getPositionsAsc();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'getPositions' => $getPositions,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'description' => ucwords($_POST['description']),
				'max_vote' => $_POST['max_vote'],
				'success' => '',
				'error' => ''
			];

			$stmt = $this->positionModel->getPositionsDesc();
			$priority = $stmt->priority + 1;

			if($this->positionModel->addPosition($data,$priority)){
				flash('position_success', 'Position added successfully');
				redirect('positions');
			}
			else{
				$data['error'] = 'Something went wrong';
				$this->view('positions/index', $data);
			}
		}
	}
	//edit position
	public function edit() {
		$getPositions = $this->positionModel->getPositionsAsc();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'getPositions' => $getPositions,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'id' => $_POST['id'],
				'description' => ucwords($_POST['description']),
				'max_vote' => $_POST['max_vote'],
				'priority' => $_POST['priority'],
				'success' => '',
				'error' => ''
			];
			if($this->positionModel->updatePosition($data)){
				flash('position_success', 'Position updated successfully');
				redirect('positions');
			}
			else{
				$data['error'] = 'Something went wrong';
				$this->view('positions/index', $data);
			}
		}
	}
	//delete position
	public function delete() {
		$getPositions = $this->positionModel->getPositionsAsc();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'getPositions' => $getPositions,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'id' => $_POST['id'],
				'success' => '',
				'error' => ''
			];
			if($this->positionModel->delPosition($data['id'])){
				if ($this->positionModel->delCandidate($data['id'])) {
					flash('position_success', 'Position deleted successfully');
					redirect('positions');
				}	
			}
			else{
				$data['error'] = 'Something went wrong';
				$this->view('positions/index', $data);
			}
		}
	}

	//get position row result by id
	public function posrow() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$id = $_POST['id'];
			$row = $this->positionModel->getPos($id);
		}
		echo json_encode($row);
	}
	/* 
		END OF POSITION METHODS
	*/
}

?>