<?php  
	class Admins extends Controller {
		public function __construct() {
			if (!isAdminLoggedIn()) {
				redirect('login/admin');
			}
			if (isVoterLoggedIn()) {
				redirect('voters');
			}
			$this->adminModel = $this->model('AdminModel');
		}

		// main view of admin -- dashboard
		public function index() {
			if ($_SESSION['role'] != 'superadmin') {
				redirect('voter');
			}
			$winners = $this->adminModel->getWinners();
			$votes = $this->adminModel->getVotes();
			$asc = $this->adminModel->getPositionsAsc();
			$pos = $this->adminModel->getPositions();
			$can = $this->adminModel->getCandidates();
			$position = $this->adminModel->getPositions();
			$vot = $this->adminModel->getVoters();
			$votnum = $this->adminModel->getVotersById($_SESSION['admin']);
			$data = [
				'winners' => $winners,
				'getPositions' => $position,
				'votes' => $votes,
				'getPositionsAsc' => $asc,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'role' => $_SESSION['role'],
				'created_on' => $_SESSION['created_on'],
				'pos' => $pos,
				'can' => $can,
				'vote' => $vot,
				'votenum' => $votnum
			];
			$this->view('admins/index', $data);
		}

		//profile update method
		public function profile() {
			$admin = $this->adminModel->getAdmin();
			$getVoters = $this->adminModel->getVoters();
			$getPositions = $this->adminModel->getPositions();
			$votes = $this->adminModel->getVotes();
			$asc = $this->adminModel->getPositionsAsc();
			$pos = $this->adminModel->getPositions();
			$can = $this->adminModel->getCandidates();
			$vot = $this->adminModel->getVoters();
			$votnum = $this->adminModel->getVotersById($_SESSION['admin']);
			$return = 'admins/index';
			if ($_SESSION['role'] != 'superadmin') {
				$return = 'voter/index';
			}
			$data = [
				'getPositions' => $getPositions,
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'role' => $_SESSION['role'],
				'created_on' => $_SESSION['created_on'],
				'getVoters' => $getVoters
			];

			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_URL);
				$return = $_GET['return'];
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$data = [
					'getPositionsAsc' => $asc,
					'votes' => $votes,
					'pos' => $pos,
					'can' => $can,
					'vote' => $vot,
					'votenum' => $votnum,
					'getVoters' => $getVoters,
					'firstname' => $_POST['firstname'],
					'lastname' => $_POST['lastname'],
					'username' => $_POST['username'],
					'created_on' => $_SESSION['created_on'],
					'password' => $_POST['password'],
					'vphoto' => $_FILES['photo']['name'],
					'photo' => $_SESSION['photo'],
					'curr_password' => $_POST['curr_password'],
					'error' =>  '',
					'success' => ''
				];
				if(password_verify($data['curr_password'], $_SESSION['password'])){
					if(!empty($data['vphoto'])){
						move_uploaded_file($_FILES['photo']['tmp_name'],'C:/laragon/www/votingsystem/public/images/admin/'.$data['vphoto']);
						$filename = $data['vphoto'];	
					}
					else{
						$filename = $_SESSION['photo'];
					}

					if($data['password'] == $_SESSION['password']){
						$data['password'] = $_SESSION['password'];
					}
					else{
						$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
					}
					if($this->adminModel->updateAdmin($data,$filename,$_SESSION['admin'])){
						$_SESSION['username'] = $data['username'];
						$_SESSION['password'] = $data['password'];
						$_SESSION['firstname'] = $data['firstname'];
						$_SESSION['lastname'] = $data['lastname'];
						$_SESSION['photo'] = $filename;
						unset($_POST);
					}
					else{
						die('Something went wrong');
					}
				}
				else {
					$data['error'] = 'Incorrect password';
				}
				if (empty($data['error'])) {
					flash('admin_success', 'Admin successfully updated');
					if ($_SESSION['role'] == 'superadmin') {
						redirect('admins');
					}
					else {
						redirect('voter');
					}
				}
				else {
					$this->view($return, $data);
				}
			}
		}

		//activate
		public function activate() {
			if ($_SESSION['role'] != 'superadmin') {
				redirect('voter');
			}
			$votes = $this->adminModel->getVotes();
			$asc = $this->adminModel->getPositionsAsc();
			$pos = $this->adminModel->getPositions();
			$can = $this->adminModel->getCandidates();
			$vot = $this->adminModel->getVoters();
			$votnum = $this->adminModel->getVotersById($_SESSION['admin']);
			$getVoters = $this->adminModel->getVoters();
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				$data = [
					'votes' => $votes,
					'getPositionsAsc' => $asc,
					'username' => $_SESSION['username'],
					'password' => $_SESSION['password'],
					'firstname' => $_SESSION['firstname'],
					'lastname' => $_SESSION['lastname'],
					'photo' => $_SESSION['photo'],
					'created_on' => $_SESSION['created_on'],
					'getVoters' => $getVoters,
					'pos' => $pos,
					'can' => $can,
					'vote' => $vot,
					'votenum' => $votnum,
					'success' => '',
					'error' => ''
				];
				$stmt = $this->adminModel->getVoters();
				$num = 0;
				foreach ($stmt as $status) {
					if ($status->statuses != 'Active') {
						$num+=1;
					}
				}
				if ($num > 0) {
					$parse = parse_ini_file(APPROOT . '/views/admins/config.ini', FALSE, INI_SCANNER_RAW);
					$emilyado = ['mail'=>$stmt];
					$title = $parse['election_title'];
					$template_file = APPROOT."/views/admins/email.php";
					$email_from = SITENAME."-CTU <kandingon1@gmail.com>";
					foreach($emilyado['mail'] as $mail) {
						$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$pass_set = '123456789abcdefghijklmnopqrstuvwxyz';
						$password_init = substr(str_shuffle($pass_set), 0, 10);
						$password = password_hash($password_init, PASSWORD_DEFAULT);
						$voter = substr(str_shuffle($set), 0, 15);
						if ($mail->statuses != 'Active') {
							$this->adminModel->generateCred($voter,$password,$mail->id);
							// create a list of the variables to be swapped in the html template
							$swap_var = array(
								"{INSTITUTION}" => "Cebu Technological University - Tuburan Campus",
								"{COUNCIL}" => "Supreme Student Council",
								"{ELECTION_TITLE}" => $title,
								"{VOTER_ID}" => $voter,
								"{PASSWORD}" => $password_init
							);

							// create the email headers to being the email
							$email_headers = "From: $email_from\r\n";
							$email_headers .= "MIME-Version: 1.0\r\n";
							$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

							$to      = $mail->email; // Send email to our user
							$subject = $swap_var['{ELECTION_TITLE}']." Invitation"; // Give the email a subject 
							$message = file_get_contents($template_file); // Our email to be sent

							//search and replace for predefined variablesc
							foreach (array_keys($swap_var) as $key){
								if (strlen($key) > 2 && trim($swap_var[$key]) != '')
									$message = str_replace($key, $swap_var[$key], $message);
							}
							mail($to, $subject, $message, $email_headers); // Send our email **/
						}
					}
				}
				else {
					$data['error'] = 'Accounts are already active.';
				}
				if (empty($data['error'])) {
					shell_exec("python C:/laragon/www/votingsystem/public/images/voter_faces/resize_image.py");
					$this->adminModel->activateAll();
					flash('admin_success', 'Emails successfully sent!<br>Voters are now activated');
					redirect('admins');
				}
				else{
					$this->view('admins/index', $data);
				}
			}
		}

		//end
		public function end() {
			$votes = $this->adminModel->getVotes();
			$asc = $this->adminModel->getPositionsAsc();
			$pos = $this->adminModel->getPositions();
			$can = $this->adminModel->getCandidates();
			$vot = $this->adminModel->getVoters();
			$votnum = $this->adminModel->getVotersById($_SESSION['admin']);
			$getVoters = $this->adminModel->getVoters();
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				$data = [
					'votes' => $votes,
					'getPositionsAsc' => $asc,
					'username' => $_SESSION['username'],
					'password' => $_SESSION['password'],
					'firstname' => $_SESSION['firstname'],
					'lastname' => $_SESSION['lastname'],
					'photo' => $_SESSION['photo'],
					'created_on' => $_SESSION['created_on'],
					'getVoters' => $getVoters,
					'pos' => $pos,
					'can' => $can,
					'vote' => $vot,
					'votenum' => $votnum,
					'success' => '',
					'error' => ''
				];
				if ($this->adminModel->endElect()) {
					flash('admin_success', 'Election successfully ended');
					redirect('admins');
				}
			}
		}

		//method for election title configuration
		public function config() {
			if ($_SESSION['role'] != 'superadmin') {
				redirect('voter');
			}
			$votes = $this->adminModel->getVotes();
			$asc = $this->adminModel->getPositionsAsc();
			$pos = $this->adminModel->getPositions();
			$can = $this->adminModel->getCandidates();
			$vot = $this->adminModel->getVoters();
			$winners = $this->adminModel->getWinners();
			$position = $this->adminModel->getPositions();
			$votnum = $this->adminModel->getVotersById($_SESSION['admin']);
			$return = 'admins/index';
			$data = [
				'title' => '',
				'success' => ''
			];
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_URL);
				$return = $_GET['return'];
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$data = [
					'winners' => $winners,
					'getPositions' => $position,
					'username' => $_SESSION['username'],
					'password' => $_SESSION['password'],
					'firstname' => $_SESSION['firstname'],
					'lastname' => $_SESSION['lastname'],
					'photo' => $_SESSION['photo'],
					'created_on' => $_SESSION['created_on'],
					'getPositionsAsc' => $asc,
					'votes' => $votes,
					'pos' => $pos,
					'can' => $can,
					'vote' => $vot,
					'votenum' => $votnum,
					'error' =>  '',
					'title' => $_POST['title'],
					'success' => ''
				];
				$file = APPROOT . '/views/admins/config.ini';
				$content = 'election_title ='.$data['title'];
				file_put_contents($file, $content);
				$data['success'] = 'Title updated successfully.';
			}
			else {
				$this->view($return, $data); 
			}
			$this->view($return, $data);
		}

		//votes page view
		public function votes() {
			if ($_SESSION['role'] != 'superadmin') {
				redirect('voter');
			}
			$getstudents = $this->adminModel->getStudents();
			$data = [
				'username' => $_SESSION['username'],
				'password' => $_SESSION['password'],
				'firstname' => $_SESSION['firstname'],
				'lastname' => $_SESSION['lastname'],
				'photo' => $_SESSION['photo'],
				'created_on' => $_SESSION['created_on'],
				'getStudents' => $getstudents
			];
			$this->view('admins/votes', $data);
		}
		
		//Method for saving image
		public function saveimage() {
			$filename = $_SESSION['photo'];
			move_uploaded_file($_FILES['webcam']['tmp_name'],'C:/laragon/www/votingsystem/public/images/temp_faces/'.$filename);
		}

		/*
			END OF ALL METHODS FOR ADMIN
		*/

		/*
			METHOD FOR STARTING ELECTION
		*/
	}
?>