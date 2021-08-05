<?php  

	class Voters extends Controller {
		private $detect;
		public function __construct() {
			if (!isVoterLoggedIn()) {
				redirect('logins');
			}
			if (isAdminLoggedIn()) {
				redirect('admins');
			}
			$this->detect = new Mobile_Detect();
			$this->voterModel = $this->model('VoterModel');
			$valid = $this->voterModel->getVoterById($_SESSION['voter']);
			if ($valid->statuses != 'Active') {
				session_destroy();
				redirect('logins');
			}
		}

		public function index() {
			$confirm = $this->voterModel->getVoterById($_SESSION['voter']);
			if ($confirm->voted == 'Yes') {
				redirect('voters/confirm');
			}
			$viewVote = $this->voterModel->viewVote($_SESSION['voter']);
			$voteCheck = $this->voterModel->voteCheck($_SESSION['voter']);
			$getpos = $this->voterModel->getPositionsAsc();
			$getcan = $this->voterModel->getCandidates();
			$data = [
				'votedAlready' => $voteCheck,
				'list' => '',
				'pos' => $getpos,
				'can' => $getcan,
				'viewvote' => $viewVote
			];
			
			$this->view('voters/index',$data);
		}

		//method to vote in mobile
		public function mobilevote() {
			if (!$this->detect->isMobile()) {
				redirect('voters/vote');
			}
			$confirm = $this->voterModel->getVoterById($_SESSION['voter']);
			if ($confirm->voted == 'Yes') {
				redirect('voters/confirm');
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				//Sanitize POST Data
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$getpos = $this->voterModel->getPositionsAsc();
				$getcan = $this->voterModel->getCandidates();
				$viewVote = $this->voterModel->viewVote($_SESSION['voter']);
				$voteCheck = $this->voterModel->voteCheck($_SESSION['voter']);
				$data = [
					'votedAlready' => $voteCheck,
					'voteview' => $viewVote,
					'pos' => $getpos,
					'can' => $getcan,
					'file' => $_FILES['photo']['name'],
					'sub_error' => ''
				];
				$src = "C:/laragon/www/votingsystem/public/images/temp_faces/";
				$_SESSION['post'] = $_POST;
				$image_name = trim($_SESSION['photo']);
				$result = "True";
				if (empty($data['file'])) {
					die('No photo to process');
				}
				else {
					if(move_uploaded_file($_FILES['photo']['tmp_name'], $src.$_SESSION['photo'])) {
						CreateThumbnail($src.$_SESSION['photo'],$src.$_SESSION['photo'], 640);
					}	
					$sql = $this->voterModel->getPositions();
					$yes = 'Yes';
					$image = shell_exec("python C:/laragon/www/votingsystem/public/compare_faces.py " . $image_name);
					$final = strcasecmp(trim($image), $result);
					if($final == 0) {
						foreach($sql as $row){
							$position = slugify($row->description);
							$pos_id = $row->id;
							if(isset($_POST[$position])){
								if($row->max_vote > 1){
									foreach($_POST[$position] as $key => $values){
										$sql_array = $this->voterModel->prep($_SESSION,$values,$pos_id);
									}
								}
								else{
									$candidate = $_POST[$position];
									$sql_array = $this->voterModel->prep($_SESSION,$candidate,$pos_id);
								}	
							}
						}
						$this->voterModel->updateyes($_SESSION['voters_id'], $yes);
						unset($_SESSION['post']);
						flash('submit_success', 'Face matched. Ballot submitted successfully');
						redirect('voters/confirm');
					}
					elseif ($final == -14) {
						$data['sub_error'] = 'Face doesn\'t match!';	
					}
					else {
						$data['sub_error'] = 'No face detected!';
					}
					$this->view('voters/mobilevote', $data);
				}
				$this->view('voters/mobilevote', $data);		
			}
			else {
				$getpos = $this->voterModel->getPositionsAsc();
				$getcan = $this->voterModel->getCandidates();
				$viewVote = $this->voterModel->viewVote($_SESSION['voter']);
				$voteCheck = $this->voterModel->voteCheck($_SESSION['voter']);
				$data = [
					'votedAlready' => $voteCheck,
					'voteview' => $viewVote,
					'pos' => $getpos,
					'can' => $getcan,
					'sub_error' => ''
				];
				$this->view('voters/mobilevote', $data);
			}
		}
		//method for sending vote
		public function vote() {
			$confirm = $this->voterModel->getVoterById($_SESSION['voter']);
			if ($confirm->voted == 'Yes') {
				redirect('voters/confirm');
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				//Sanitize POST Data
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$getpos = $this->voterModel->getPositionsAsc();
				$getcan = $this->voterModel->getCandidates();
				$viewVote = $this->voterModel->viewVote($_SESSION['voter']);
				$voteCheck = $this->voterModel->voteCheck($_SESSION['voter']);
				$data = [
					'votedAlready' => $voteCheck,
					'voteview' => $viewVote,
					'pos' => $getpos,
					'can' => $getcan,
					'sub_error' => ''
				];
				$yes = "Yes";
				$_SESSION['post'] = $_POST;
				$sql = $this->voterModel->getPositions();
				foreach($sql as $row){
					$position = slugify($row->description);
					$pos_id = $row->id;
					if(isset($_POST[$position])){
						if($row->max_vote > 1){
							foreach($_POST[$position] as $key => $values){
								$sql_array = $this->voterModel->prep($_SESSION,$values,$pos_id);
							}
						}
						else{
							$candidate = $_POST[$position];
							$sql_array = $this->voterModel->prep($_SESSION,$candidate,$pos_id);
						}	
					}
				}
				$this->voterModel->updateyes($_SESSION['voters_id'], $yes);
				unset($_SESSION['post']);
				flash('submit_success', 'Ballot submitted successfully');
				redirect('voters/confirm');		
			}
			else {
				$getpos = $this->voterModel->getPositionsAsc();
				$getcan = $this->voterModel->getCandidates();
				$viewVote = $this->voterModel->viewVote($_SESSION['voter']);
				$voteCheck = $this->voterModel->voteCheck($_SESSION['voter']);
				$data = [
					'votedAlready' => $voteCheck,
					'voteview' => $viewVote,
					'pos' => $getpos,
					'can' => $getcan,
					'sub_error' => ''
				];
				$this->view('voters/vote', $data);
			}
		}

		public function confirm() {
			$confirm = $this->voterModel->getVoterById($_SESSION['voter']);
			$vie = $this->voterModel->viewVote($_SESSION['voters_id']);
			if ($confirm->voted == 'No') {
				redirect('voters');
			}
			$data = [
				'vie' => $vie 
			];
			$this->view('voters/confirm', $data);
		}

		//Method for saving image
		public function saveimage() {
			$filename = $_SESSION['photo'];

			move_uploaded_file($_FILES['webcam']['tmp_name'],'C:/laragon/www/votingsystem/public/images/temp_faces/'.$filename);
		}

		//method for max vote validation
		public function maxvote() {
			$output = array('error'=>false,'list'=>'');
			if(empty($_POST)) {
				$output['error'] = true;
				$output['message'] = 'Please vote at least one candidate.';
			}
			else {	
				$query = $this->voterModel->getPositions();
				foreach($query as $row){
					$position = slugify($row->description);
					$pos_id = $row->id;
					if(isset($_POST[$position])){
						if($row->max_vote > 1){
							if(count($_POST[$position]) > $row->max_vote){
								$output['error'] = true;
								$output['message'] = 'You can only vote '.$row->max_vote.' candidates for '.$row->description;
							}
						}
					}
				}
			}
			echo json_encode($output);
		}

		public function preview() {

			$output = array('error'=>false,'list'=>'');
			$query = $this->voterModel->getPositions();
			foreach($query as $row){
				$position = slugify($row->description);
				$pos_id = $row->id;
				if(isset($_POST[$position])){
					if($row->max_vote > 1){
						if(count($_POST[$position]) > $row->max_vote){
							$output['error'] = true;
							$output['message'] = 'You can only choose '.$row->max_vote.' candidates for '.$row->description;
						}
						else{
							foreach($_POST[$position] as $key => $values){
								$cmrow = $this->voterModel->getCandidatesById($values);
								$output['list'] .= "
									<div class='row votelist'>
				                      	<span class='col-sm-4'><span class='pull-right'><b>".$row->description." :</b></span></span> 
				                      	<span class='col-sm-8'>".$cmrow->firstname." ".$cmrow->lastname."</span>
				                    </div>
								";
							}
						}
					}
					else{
						$candidate = $_POST[$position];
						$csrow = $this->voterModel->getCandidatesById($candidate);
						$output['list'] .= "
							<div class='row votelist'>
		                      	<span class='col-sm-4'><span class='pull-right'><b>".$row->description." :</b></span></span> 
		                      	<span class='col-sm-8'>".$csrow->firstname." ".$csrow->lastname."</span>
		                    </div>
						";
					}
				}	
			}
			echo json_encode($output);
		}
	}

?>