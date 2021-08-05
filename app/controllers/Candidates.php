<?php 
use mikehaertl\pdftk\Pdf;
use mikehaertl\pdftk\XfdfFile;
use mikehaertl\pdftk\FdfFile;

class Candidates extends Controller {
	public function __construct() {
			if (!isAdminLoggedIn()) {
				redirect('login/admin');
			}
			if (isVoterLoggedIn()) {
				redirect('voters');
			}
			$this->candidateModel = $this->model('AdminModel');
		}

	/* Start of Methods 
	   for Candidates
	*/
	public function index() {
		if ($_SESSION['role'] != 'superadmin') {
			redirect('voter');
		}
		$getCanFromPos = $this->candidateModel->getCanFP();
		$getPos = $this->candidateModel->getPositions();
		$data = [
			'getCanFromPos' => $getCanFromPos,
			'getPositions' => $getPos,
			'username' => $_SESSION['username'],
			'password' => $_SESSION['password'],
			'firstname' => $_SESSION['firstname'],
			'lastname' => $_SESSION['lastname'],
			'photo' => $_SESSION['photo'],
			'created_on' => $_SESSION['created_on']
		];
		$this->view('candidates/index', $data);
	}

	//add candidate 
	public function add() {
		$getCanFromPos = $this->candidateModel->getCanFP();
		$getPos = $this->candidateModel->getPositions();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'getCanFromPos' => $getCanFromPos,
				'getPositions' => $getPos,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'platform' => $_POST['platform'],
				'position' => $_POST['position'],
				'created_on' => $_SESSION['created_on'],
				'vfirstname' => ucwords($_POST['firstname']),
				'vmiddlename' => ucwords($_POST['middlename']),
				'vlastname' => ucwords($_POST['lastname']),
				'program' => $_POST['program'],
				'email' => $_POST['email'],
				'filename' => $_FILES['photo']['name'],
				'year1' => $_POST['year1'],
				'year2' => $_POST['year2'],
				'gender' => $_POST['gender'],
				'age' => $_POST['age'],
				'birthdate' => $_POST['birthdate'],
				'birth_address' => $_POST['birth_address'],
				'address' => $_POST['address'],
				'contact' => $_POST['contact'],
				'success' => '',
				'error' => ''
			];
			$position = $this->candidateModel->getPos($data['position']);
			$course = $this->getCourse($data['program']);
			$photoname = time().'.jpg';
			if(!empty($data['filename'])){
				move_uploaded_file($_FILES['photo']['tmp_name'], 'C:/laragon/www/votingsystem/public/images/candidates/'.$photoname);
			}
			if(preg_match("~@ctu\.edu\.ph$~", $data['email'])) {
				if($this->candidateModel->addCandidates($data,$photoname)){
					if($this->generateCOC($data,$position->description,$course)) {
						$this->createCOC($data);
					}
				}
				else{
					$data['error'] = 'Something went wrong';
				}
			}
			else {
				$data['error'] = 'Only CTU emails are accepted!';
			}
			if (empty($data['error'])) {
				flash('candidate_success', 'Candidate added successfully');
				redirect('candidates');
			}
			else {
				$this->view('candidates/index', $data);
			}
		}
	}

	//edit candidate
	public function edit() {
		$getCanFromPos = $this->candidateModel->getCanFP();
		$getPos = $this->candidateModel->getPositions();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'getCanFromPos' => $getCanFromPos,
				'getPositions' => $getPos,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'position' => $_POST['position'],
				'platform' => $_POST['platform'],
				'id' => $_POST['id'],
				'success' => '',
				'error' => ''
			];
			if($this->candidateModel->editCandidate($data)){
				flash('candidate_success', 'Candidate updated successfully');
				redirect('candidates');
			}
			else{
				$data['error'] = 'Something went wrong';
				$this->view('candidates/index', $data);
			}
		}
	}

	//delete candidate
	public function delete() {
		$getCanFromPos = $this->candidateModel->getCanFP();
		$getPos = $this->candidateModel->getPositions();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'getCanFromPos' => $getCanFromPos,
				'getPositions' => $getPos,
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
			if ($this->candidateModel->deleteCandidate($data['id'])) {
				flash('candidate_success', 'Candidate deleted successfully.');
				redirect('candidates');
			}
			else {
				$data['error'] = 'Something went wrong';
				$this->view('candidates/index', $data);
			}
		}
	}

	//candidate photo
	public function photo() {
		if ($_SESSION['role'] != 'superadmin') {
			redirect('admins/voters');
		}
		$getCanFromPos = $this->candidateModel->getCanFP();
		$getPos = $this->candidateModel->getPositions();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'getCanFromPos' => $getCanFromPos,
				'getPositions' => $getPos,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'id' => $_POST['id'],
				'student_id' => $_POST['student_id'],
				'filename' => $_FILES['photo']['name'],
				'success' => '',
				'error' => ''
			];
			$filename = $data['student_id'].'.jpg';
			if(!empty($data['filename'])){
				move_uploaded_file($_FILES['photo']['tmp_name'], 'C:/laragon/www/votingsystem/public/images/voter_faces/'.$filename);	
			}
			if($this->candidateModel->updateCandidatePhoto($data,$filename)){
				flash('candidate_success', 'Candidate photo updated successfully');
				redirect('candidates');
			}
			else{
				$data['error'] = $conn->error;
			}
			$this->view('candidates/index', $data);
		}
	}

	//get candidate row result by id
	public function canrow() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$id = $_POST['id'];
			$row = $this->candidateModel->getCanFromPos($id);
		}
		echo json_encode($row);
	}

	//get course description
	public function getCourse($course) {
		$description = '';
		switch ($course) {
			case 'BIT':
				$description = 'Bachelor of Industrial Technology';
				return $description;
				break;
			case 'BSHM':
				$description = 'Bachelor of Science in Hospitality Management';
				return $description;
				break;
			case 'BSME':
				$description = 'Bachelor of Science in Mechanical Engineering';
				return $description;
				break;
			case 'BSEE':
				$description = 'Bachelor of Science in Electrical Engineering';
				return $description;
				break;
			case 'BSCE':
				$description = 'Bachelor of Science in Civil Engineering';
				return $description;
				break;
			case 'BAE':
				$description = 'Bachelor of Arts in English';
				return $description;
				break;
			case 'BALIT':
				$description = 'Bachelor of Arts in Literature';
				return $description;
				break;
			case 'BEED':
				$description = 'Bachelor in Elementary Education';
				return $description;
				break;
			case 'BSED':
				$description = 'Bachelor in Secondary Education';
				return $description;
				break;
			case 'BTLE':
				$description = 'Bachelor of Technology and Livelihood Education';
				return $description;
				break;
			case 'BSA':
				$description = 'Bachelor of Science in Agriculture';
				return $description;
				break;
			default:
				$description = 'Bachelor of Science in Information Technology';
				return $description;
				break;
		}
	}

	public function generateCOC($data,$position,$course) {
		$xfdf = new XfdfFile([
				'candidate_name' => strtoupper($data['vfirstname']).' '.mb_substr($data['vmiddlename'], 0, 1, "UTF-8") .'.'.' '.strtoupper($data['vlastname']),
				'position' => strtoupper($position),
				'year1' => substr($data['year1'], -2),
				'year2' => substr($data['year2'], -2),
				'position2' => strtoupper($position),
				'course' => strtoupper($course),
				'gender' => $data['gender'],
				'age' => $data['age'],
				'birth_date' => $data['birthdate'],
				'birth_address' => $data['birth_address'],
				'current_address' => $data['address'],
				'number' => $data['contact'],
				'email' => $data['email'],
				'name_with_sig' => strtoupper($data['vfirstname']).' '.mb_substr($data['vmiddlename'], 0, 1, "UTF-8") .'.'.' '.strtoupper($data['vlastname'])
			]);
		if($xfdf->saveAs('C:/laragon/www/votingsystem/public/pdf/form-filler/'.strtolower(str_replace(' ','_',$data['vfirstname'])).'_'.strtolower(str_replace(' ','_',$data['vlastname'])).'.xfdf')) {
			return true;
		}
		else {
			return false;
		}
	}

	public function createCOC($data) {
		// Fill form with data array
		$pdf = new Pdf('C:/laragon/www/votingsystem/public/pdf/coc.pdf');
		$result = $pdf->fillForm('C:/laragon/www/votingsystem/public/pdf/form-filler/'.strtolower(str_replace(' ','_',$data['vfirstname'])).'_'.strtolower(str_replace(' ','_',$data['vlastname'])).'.xfdf')
			->flatten()
		    ->saveAs('C:/laragon/www/votingsystem/public/pdf/candidate-coc/'.strtolower(str_replace(' ','_',$data['vfirstname'])).'_'.strtolower(str_replace(' ','_',$data['vlastname'])).'.pdf');
		if ($result === false) {
		    $error = $pdf->getError();
		}
	}
}

?>