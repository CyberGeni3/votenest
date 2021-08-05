<?php  
class Voter extends Controller {
	public function __construct() {
		if (!isAdminLoggedIn()) {
			redirect('login/admin');
		}
		if (isVoterLoggedIn()) {
			redirect('voters');
		}
		$this->voterModel = $this->model('AdminModel');
	}

	//voters
	public function index() {
		$getVoters = $this->voterModel->getVoters();
		$getPositions = $this->voterModel->getPositions();
		$data = [
			'getPositions' => $getPositions,
			'username' => $_SESSION['username'],
			'password' => $_SESSION['password'],
			'firstname' => $_SESSION['firstname'],
			'lastname' => $_SESSION['lastname'],
			'photo' => $_SESSION['photo'],
			'created_on' => $_SESSION['created_on'],
			'getVoters' => $getVoters
		];
		$this->view('voter/index', $data);
	}

	//add voters
	public function add() {
		$getVoters = $this->voterModel->getVoters();
		$getPositions = $this->voterModel->getPositions();
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
				'getVoters' => $getVoters,
				'empassword' => strtolower($_POST['program']).$_POST['student_id'],
				'student_id' => $_POST['student_id'],
				'vfirstname' => ucwords($_POST['firstname']),
				'vmiddlename' => ucwords($_POST['middlename']),
				'vlastname' => ucwords($_POST['lastname']),
				'program' => $_POST['program'],
				'email' => $_POST['email'],
				'file' => $_POST['voterPic'],
				'success' => '',
				'error' => ''
			];
			$true = "True";
			$binary_data = base64_decode($data['file']);
			// save to server (beware of permissions)
			$dir = 'C:/laragon/www/votingsystem/public/images/temp_faces/';
			$finaldir = 'C:/laragon/www/votingsystem/public/images/voter_faces/';
			$result = file_put_contents( $dir.$data['student_id'].'.jpg', $binary_data );
			if ($result) {
				CreateThumbnail($dir.$data['student_id'].'.jpg', $dir.$data['student_id'].'.jpg', 640);
			}
			else {
				$data['error'] = "Could not save image!  Check file permissions.";
			}
			$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$password = password_hash($data['empassword'], PASSWORD_DEFAULT);
			$voter = substr(str_shuffle($set), 0, 15);
			$photoname = $data['student_id'].'.jpg';

			$checker = shell_exec("python C:/laragon/www/votingsystem/public/compare_faces_registration.py " . escapeshellarg($data['student_id']));
			$final = strcasecmp(trim($checker), $true);
			if ($final == 0) {
				if($this->voterModel->addVoter($data,$voter,$password,$photoname)) {
					file_put_contents($finaldir.$photoname, $binary_data);
				}
				else {
					$data['error'] = 'Something went wrong!';
				}
			}
			elseif($final == (-19)) {
				$data['error'] = 'No face detected!';
			}
			elseif($final == (-16)) {
				$data['error'] = 'Problem connecting to database!';
			}
			else {
				$_SESSION['face'] = trim($checker);
				$data['error'] = 'Face already registered to student '.$_SESSION['face'].'!';
			}
			if (empty($data['error'])) {
				flash('voter_success', 'Voter added successfully');
				redirect('voter');
			}
			else {
				$this->view('voter/index', $data);
			}
		}	
	}//end of add function

	//edit voter
	public function edit() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$getVoters = $this->voterModel->getVoters();
			$getPositions = $this->voterModel->getPositions();
			$data = [
				'getPositions' => $getPositions,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'getVoters' => $getVoters,
				'success' => '',
				'error' => '',
				'id' => $_POST['id'],
				'student_id' => $_POST['student_id'],
				'vfirstname' => ucwords($_POST['firstname']),
				'vmiddlename' => ucwords($_POST['middlename']),
				'vlastname' => ucwords($_POST['lastname']),
				'program' => $_POST['program'],
				'email' => $_POST['email']
			];
			$voter = $this->voterModel->getVoterById($data['id']);
			$email = $data['email'];
			if ($data['email'] == $voter->email) {
				$email = $voter->email;
			}
			else {
				if (preg_match("~@ctu\.edu\.ph$~", $data['email'])) {
					$rows = $this->voterModel->checkEmailDupe($data);
					if (count($rows) >= 1) {
						$data['error'] = 'Email already exists';
					}
				}
				else {
					$data['error'] = 'Make sure the email ends with @ctu.edu.ph';
				}
			}
			if (empty($data['error'])) {
				$this->voterModel->updateVoter($data,$email);
				flash('voter_success', 'Voter updated successfully');
				redirect('voter');
			}
			else {
				$this->view('voter/index', $data);
			}
		}
	}
	//delete voter
	public function delete() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$getVoters = $this->voterModel->getVoters();
			$getPositions = $this->voterModel->getPositions();
			$data = [
				'getPositions' => $getPositions,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'getVoters' => $getVoters,
				'success' => '',
				'error' => '',
				'id' => $_POST['id']
			];
			$findFE = $this->voterModel->findFaceEncoding($data['id']);
			if ($this->voterModel->deleteVoter($data['id']) && $this->voterModel->deleteFaceEncoding($findFE->student_id)) {
				flash('voter_success', 'Voter successfully deleted.');
				redirect('voter');
			}
			else {
				$data['error'] = 'Something went wrong';
				$this->view('voter/index', $data);
			}
		}
	}

	//update photo
	public function updatephoto() {
		$getVoters = $this->voterModel->getVoters();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data = [
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'getVoters' => $getVoters,
				'id' => $_POST['id'],
				'filename' => $_FILES['photo']['name'],
				'success' => '',
				'error' => ''
			];
			if(!empty($data['filename'])){
				move_uploaded_file($_FILES['photo']['tmp_name'], 'C:/laragon/www/votingsystem/public/images/voter_faces/'.$data['filename']);	
			}
			if($this->voterModel->updatePhoto($data)){
				flash('voter_success', 'Photo updated successfully');
				redirect('voter');
			}
			else{
				$data['error'] = $conn->error;
			}
			$this->view('voter/index', $data);
		}
		$this->view('voter/index', $data);
	}

	//get rows
	public function getrow() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$id = $_POST['id'];
			$row = $this->voterModel->getRows($id);
		}
		echo json_encode($row);
	}

	//form checker
	public function formchecker() {
		$emailcheck = $this->voterModel->getVoterByEmail($_POST['email']);
		$exist = $this->voterModel->sidChecker($_POST['student_id']);
		$output = array('error'=>false,'list'=>'');
		if(empty($_POST)) {
			$output['error'] = true;
			$output['message'] = 'Form is empty!';
		}
		elseif(empty($_POST['student_id']) || empty($_POST['firstname']) || empty($_POST['middlename']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['program'])) {
			$output['error'] = true;
			$output['message'] = 'Do not leave a field empty!';
		}
		elseif($exist) {
			$output['error'] = true;
			$output['message'] = 'Student ID already registered!';
		}
		elseif(!preg_match("~@ctu\.edu\.ph$~", $_POST['email'])) {
			$output['error'] = true;
			$output['message'] = 'Email should be a CTU email!';
		}
		elseif(count($emailcheck) > 0) {
			$output['error'] = true;
			$output['message'] = 'Email already exists';
		}
		echo json_encode($output);
	}
}

?>