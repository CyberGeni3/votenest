<?php  

	class Login extends Controller {
		//private $detect;
		public function __construct() {
			if (isVoterLoggedIn()) {
				redirect('voters');
			}
			if (isAdminLoggedIn()) {
				redirect('admins');
			}
			$this->detect = new Mobile_Detect();
			$this->loginModel = $this->model('LoginModel');
			$this->voterModel = $this->model('VoterModel');
		}

		//Method for voter login
		public function index() {
			if ($this->detect->isMobile()) {
				redirect('login/mobile');
			}
			//Check for post request
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				//Sanitize POST Data
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				//Init data
				$data =[
					'voter_id' => trim($_POST['voter']),
					'password' => trim($_POST['password']),
					'file' => $_POST['loginPic'],
					'error' => ''
				];
				$binary_data = base64_decode($data['file']);
				$voterInfo = $this->loginModel->vlogin($data['voter_id']);
				$dir = 'C:/laragon/www/votingsystem/public/images/login_temp_faces/';
				$photoname = $voterInfo->student_id.'.jpg';
				if (file_put_contents($dir.$photoname, $binary_data)) {
					CreateThumbnail($dir.$photoname, $dir.$photoname, 640);
				}
				else {
					$data['error'] = 'Unable to save image. Check file permissions!';
				}
				$true = "True";
				$result = shell_exec("python C:/laragon/www/votingsystem/public/compare_faces_login.py " . escapeshellarg($voterInfo->student_id));
				$final = strcasecmp(trim($result), $true);
				if ($final == 0) {
					$this->createVoterSession($voterInfo);	
				}
				elseif($final == (-19)) {
					$data['error'] = 'No face detected!';
				}
				elseif($final == (-16)) {
					$data['error'] = 'Problem connecting to database!';
				}
				elseif($final == (-14)) {
					$data['error'] = 'Failed to load image!';
				}
				elseif($final == (-6)) {
					$data['error'] = 'Face doesn\'t match!';
				}
				else {
					$data['error'] = 'Face doesn\'t match!<br> Face belongs to Student ID #'.trim($result).'!';
				}
				$this->view('login/index', $data);
			}		
			else {
				//Init data
				$data =[
					'voter_id' => '',
					'password' => '',
					'error' => ''
				];

				//Load view
				$this->view('login/index', $data);
			}
		}

		public function mobile() {
			if (!$this->detect->isMobile()) {
				redirect('login');
			}
			//Check for post request
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				//Sanitize POST Data
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				//Init data
				$data =[
					'voter_id' => trim($_POST['voter']),
					'password' => trim($_POST['password']),
					'file' => $_FILES['photo']['name'],
					'error' => ''
				];
				$voterInfo = $this->loginModel->vlogin($data['voter_id']);
				$dir = 'C:/laragon/www/votingsystem/public/images/login_temp_faces/';
				$photoname = $voterInfo->student_id.'.jpg';
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $dir.$photoname)) {
					CreateThumbnail($dir.$photoname, $dir.$photoname, 640);
				}
				else {
					$data['error'] = 'Unable to save image. Check file permissions!';
				}
				$true = "True";
				$result = shell_exec("python C:/laragon/www/votingsystem/public/compare_faces_login.py " . escapeshellarg($voterInfo->student_id));
				$final = strcasecmp(trim($result), $true);
				if ($final == 0) {
					$this->createVoterSession($voterInfo);	
				}
				elseif($final == (-19)) {
					$data['error'] = 'No face detected!';
				}
				elseif($final == (-16)) {
					$data['error'] = 'Problem connecting to database!';
				}
				elseif($final == (-14)) {
					$data['error'] = 'Failed to load image!';
				}
				elseif($final == (-6)) {
					$data['error'] = 'Face doesn\'t match!<br> Face not yet registered!';
				}
				else {
					$_SESSION['login_face'] = trim($result);
					$data['error'] = 'Face doesn\'t match!<br> Face is registered to Student ID #'.$_SESSION['login_face'].'!';
				}
				$this->view('login/mobile', $data);
			}		
			else {
				//Init data
				$data =[
					'voter_id' => '',
					'password' => '',
					'error' => ''
				];

				//Load view
				$this->view('login/mobile', $data);
			}
		}

		//Method for admin login
		public function admin() {
			if ($this->detect->isMobile()) {
				redirect('login/error');
			}
			//Check for posts
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				//Sanitize POST Data
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				//Init data
				$data =[
					'admin' => trim($_POST['admin']),
					'password' => trim($_POST['password']),
					'admin_err' => '',
					'password_err' => ''
				];
				//check if user is using dekstop or not
				//if ($this->detect->isMobile()) {
				//	$data['voter_id_err'] = 'Mobile support not supported. Please use desktop to vote!';
				//}

				//Validation for admin
				if (empty($data['admin']) && empty($data['password'])) {
					$data['admin_err'] = 'Please enter credentials first';
				}
				elseif (empty($data['admin'])) {
					$data['admin_err'] = 'Please enter admin id';
				}
				elseif (empty($data['password'])) {
					$data['admin_err'] = 'Please enter password';
				}
				elseif ($this->loginModel->adminDontExist($data['admin'])) {
					$data['admin_err'] = 'No admin found';
				}
				elseif (empty($data['admin_err']) && empty($data['password_err'])) {
					$logInAdmin = $this->loginModel->alogin($data['admin']);
					if (password_verify($data['password'], $logInAdmin->password)) {
						$this->createAdminSession($logInAdmin);
					}
					else {
						$data['password_err'] = 'Incorrect password';
						$this->view('login/admin', $data);
					}
				}
				else {
					$this->view('login/admin', $data);
				}
				$this->view('login/admin', $data);
			}
					
			else {
				//Init data
				$data =[
					'admin' => '',
					'password' => '',
					'admin_err' => '',
					'password_err' => ''
				];

				//Load view
				$this->view('login/admin', $data);
			}
		}

		//voter login validator
		public function logValidator() {
			$output = array('error'=>false,'list'=>'');
			if (empty($_POST['voter']) && empty($_POST['password'])) {
				$output['error'] = true;
				$output['message'] = 'Please enter credentials first';
			}
			elseif (empty($_POST['voter'])) {
				$output['error'] = true;
				$output['message'] = 'Please enter voter id';
			}
			elseif (empty($_POST['password'])) {
				$output['error'] = true;
				$output['message'] = 'Please enter password';
			}
			elseif ($this->loginModel->voterDontExist($_POST['voter'])) {
				$output['error'] = true;
				$output['message'] = 'No voter found';
			}
			elseif($logInUser = $this->loginModel->vlogin($_POST['voter'])) {
				if (password_verify($_POST['password'], $logInUser->password)) {
					if ($logInUser->voted == 'Yes') {
						$output['error'] = true;
						$output['message'] = 'You have already voted!';
					}
					elseif ($logInUser->statuses != 'Active') {
						$output['error'] = true;
						$output['message'] = 'Account not activated';
					}
				}
				else {
					$output['error'] = true;
					$output['message'] = 'Incorrect password';
				}
			}
			echo json_encode($output);
		}

		//Create sessions
		public function createVoterSession($user) {
			$_SESSION['voter'] = $user->id;
			$_SESSION['student_id'] = $user->student_id;
			$_SESSION['voters_id'] = $user->voters_id;
			$_SESSION['password'] = $user->password;
			$_SESSION['role'] = $user->role;
			$_SESSION['firstname'] = $user->firstname;
			$_SESSION['middlename'] = $user->middlename;
			$_SESSION['lastname'] = $user->lastname;
			$_SESSION['program'] = $user->program;
			$_SESSION['email'] = $user->email;
			$_SESSION['photo'] = $user->photo;
			$_SESSION['status'] = $user->statuses;
			$_SESSION['voted'] = $user->voted;
			flash('voter_login_success', 'Face matched!<br>Vote wisely '.$_SESSION['firstname'].'!');
			redirect('voters');
		}
		public function createAdminSession($admin) {
			$_SESSION['admin'] = $admin->id;
			$_SESSION['username'] = $admin->username;
			$_SESSION['password'] = $admin->password;
			$_SESSION['firstname'] = $admin->firstname;
			$_SESSION['lastname'] = $admin->lastname;
			$_SESSION['photo'] = $admin->photo;
			$_SESSION['role'] = $admin->role;
			$_SESSION['created_on'] = $admin->created_on;
			flash('admin_login_success', 'Welcome to the admin panel '.$_SESSION['firstname'].'!');
			if ($_SESSION['role'] == 'superadmin') {
				redirect('admins');
			}
			else {
				redirect('voter');
			}	
		}
		//User logouts
		public function voterlogout(){
			unset($_SESSION['voter']);
			unset($_SESSION['student_id']);
			unset($_SESSION['voters_id']);
			unset($_SESSION['password']);
			unset($_SESSION['role']);
			unset($_SESSION['firstname']);
			unset($_SESSION['middlename']);
			unset($_SESSION['lastname']);
			unset($_SESSION['program']);
			unset($_SESSION['email']);
			unset($_SESSION['photo']);
			unset($_SESSION['status']);
			session_destroy();
			redirect('login');
		}
		public function adminlogout(){
			unset($_SESSION['admin']);
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			unset($_SESSION['firstname']);
			unset($_SESSION['lastname']);
			unset($_SESSION['photo']);
			unset($_SESSION['role']);
			session_destroy();
			redirect('login/admin');
		}
		public function error(){
			$data = [];
			$this->view('login/error',$data);
		}
	}

?>