<?php  

	class AdminModel {
		private $db;
		public function __construct() {
			$this->db = new Database;
		}

		//end election
		public function endElect() {
			$this->db->query('UPDATE voters SET statuses = "Inactive"');
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//get admin
		public function getAdmin() {
			$this->db->query('SELECT * FROM admin');
			$result = $this->db->single();
			return $result;
		}
		//get positions
		public function getPositions () {
			$this->db->query('SELECT * FROM positions');
			$result = $this->db->resultSet();
			return $result;
		}
		//get candidates
		public function getCandidates () {
			$this->db->query('SELECT * FROM candidates');
			$result = $this->db->resultSet();
			return $result;
		}
		//get votes
		public function getVotes() {
			$this->db->query('SELECT * FROM votes');
			$result = $this->db->resultSet();
			return $result;
		}
		//get voters
		public function getVoters () {
			$this->db->query('SELECT * FROM voters');
			$result = $this->db->resultSet();
			return $result;
		}
		//get voter by id
		public function getVotersById () {
			$this->db->query('SELECT * FROM votes GROUP BY voters_id');
			$result = $this->db->resultSet();
			return $result;
		}
		//update admin
		public function updateAdmin($data,$file,$id) {
			$this->db->query('UPDATE admin 
							  SET username = :username, password = :password, 
							  firstname = :firstname, lastname = :lastname, 
							  photo = :photo 
							  WHERE id = :id');
			$this->db->bind(':id', $id);
			$this->db->bind(':username', $data['username']);
			$this->db->bind(':password', $data['password']);
			$this->db->bind(':firstname', $data['firstname']);
			$this->db->bind(':lastname', $data['lastname']);
			$this->db->bind(':photo', $file);

			if($this->db->execute()) {
				return true;
			}		
			else {
				return false;
			}
		}

		//get students
		public function getStudents(){
			$this->db->query('SELECT student_id, program, voted_on FROM votes GROUP BY student_id');
			$result = $this->db->resultSet();
			return $result;
		}
		//get votes
		public function votesResult() {
			$this->db->query('SELECT *,
							 votes.candidate_id AS canid, 
						     candidates.firstname AS canfirst, 
						     candidates.lastname AS canlast, 
						     voters.firstname AS votfirst, 
						     voters.lastname AS votlast,
						     positions.id AS posid 
						     FROM votes
						     LEFT JOIN positions 
						     ON positions.id=votes.position_id 
						     LEFT JOIN candidates 
						     ON candidates.id=votes.candidate_id 
						     LEFT JOIN voters 
						     ON voters.id=votes.voters_id 
						     GROUP BY candidate_id');
			$result = $this->db->resultSet();
			return $result;
		}

		//get winners
		public function getWinners() {
			$this->db->query('SELECT *,
                              COUNT(candidate_id) AS total, MAX(candidate_id),
                              votes.candidate_id AS canid, 
                              candidates.firstname AS canfirst, 
                              candidates.lastname AS canlast, 
                              voters.firstname AS votfirst, 
                              voters.lastname AS votlast,
                              positions.id AS posid 
                              FROM votes
                              LEFT JOIN positions 
                              ON positions.id=votes.position_id 
                              LEFT JOIN candidates 
                              ON candidates.id=votes.candidate_id 
                              LEFT JOIN voters 
                              ON voters.id=votes.voters_id
                              GROUP BY candidate_id
                              ORDER BY total ASC');
			$result = $this->db->resultSet();
			return $result;
		}

		//generate new credentials
		public function generateCred($voter,$password,$id) {
			$this->db->query('UPDATE voters SET voters_id = :voter, password = :password WHERE id = :id');
			$this->db->bind(':id', $id);
			$this->db->bind(':voter', $voter);
			$this->db->bind(':password', $password);
			
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		//find face encoding
		public function findFaceEncoding($id) {
			$this->db->query('
					SELECT *,
					face.Student_ID AS fid 
					FROM face
					LEFT JOIN voters
					ON voters.student_id = face.Student_ID
					WHERE voters.id = :id
				');
			$this->db->bind(':id', $id);
			$row = $this->db->single();
			return $row;
		}
		//delete face encoding
		public function deleteFaceEncoding($id) {
			$this->db->query('DELETE FROM face WHERE Student_ID = :id');
			$this->db->bind(':id', $id);
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//find voter by stud id
		public function findVoterBySID($sid) {
			$this->db->query('SELECT * FROM voters WHERE student_id = :sid');
			$this->db->bind(':sid', $sid);
			$result = $this->db->single();
			return $result;
		}
		//student id checker
		public function sidChecker($id) {
			$this->db->query('SELECT * FROM voters WHERE student_id = :id');
			$this->db->bind(':id', $id);
			$result = $this->db->resultSet();
			if (count($result) != 0) {
				return true;
			}
			else {
				return false;
			}
		}
		//get winners desc
		public function winnersDesc() {
			$this->db->query('SELECT *,
                              COUNT(candidate_id) AS total, MAX(candidate_id),
                              votes.candidate_id AS canid, 
                              candidates.firstname AS canfirst, 
                              candidates.lastname AS canlast, 
                              voters.firstname AS votfirst, 
                              voters.lastname AS votlast,
                              positions.id AS posid 
                              FROM votes
                              LEFT JOIN positions 
                              ON positions.id=votes.position_id 
                              LEFT JOIN candidates 
                              ON candidates.id=votes.candidate_id 
                              LEFT JOIN voters 
                              ON voters.id=votes.voters_id
                              GROUP BY candidate_id
                              ORDER BY total DESC');
			$result = $this->db->resultSet();
			return $result;
		}
		//get most active department
		public function activeDept() {
			$this->db->query('SELECT program, COUNT(program) AS total FROM votes GROUP BY program ORDER BY total DESC LIMIT 3');
			$result = $this->db->resultSet();
			return $result;
		}

		//group by program
		public function groupProg() {
			$this->db->query('SELECT * FROM votes GROUP BY program');
			$result = $this->db->resultSet();
			return $result;
		}
		//group by stud id
		public function groupStud() {
			$this->db->query('SELECT * FROM votes GROUP BY student_id');
			$result = $this->db->resultSet();
			return $result;
		}

		//change voted status after resetting election
		public function changeStat() {
			$this->db->query('UPDATE voters SET voted = "No"');
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		//total of codes
		public function codeTotal() {
			$this->db->query('SELECT * FROM codes');
			$result = $this->db->resultSet();
			return $result;
		}

		//count all active dept
		public function countDept() {
			$this->db->query('SELECT student_id,program, COUNT(*) AS duplicates
								FROM votes
								GROUP BY student_id
								HAVING COUNT(*) >0');
			$result = $this->db->resultSet();
			return $result;
		}
		//total votes
		public function totalVotes() {
			$this->db->query('SELECT * FROM votes');
			$result = $this->db->resultSet();
			return $result;

		}

		//reset codes
		public function resetCodes() {
			$this->db->query('DELETE FROM codes');
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		//get all codes
		public function getCodes() {
			$this->db->query('SELECT * FROM codes');
			$result = $this->db->resultSet();
			return $result;
		}

		//generate codes
		public function generateCodes($array, $data) {
			foreach ($array as $arr) {
				$this->db->query('INSERT INTO codes (codes, status, for_position) VALUES (:code, "Active", :forposition)');
				$this->db->bind(':code', $arr);
				$this->db->bind(':forposition', $data);
				$this->db->execute();
			}
			return true;
		}
		//getRows json
		public function getRows($id) {
			$this->db->query('SELECT * FROM voters WHERE id = :id');
			$this->db->bind(':id', $id);
			$result = $this->db->single();
			return $result;
		}
		//get voter by email
		public function getVoterByEmail($email) {
			$this->db->query('SELECT * FROM voters WHERE email = :email');
			$this->db->bind(':email', $email);
			$row = $this->db->resultSet();
			return $row;
		}

		public function getVoterById($id) {
			$this->db->query('SELECT * FROM voters WHERE id = :id');
			$this->db->bind(':id', $id);
			$result = $this->db->single();
			return $result;
		}
		//add voter
		public function addVoter($data,$voter,$password,$photo) {
			$this->db->query('INSERT INTO voters (student_id, voters_id, password, firstname, middlename, lastname, program, email, photo, statuses, voted) VALUES (:student_id, :voter, :password, :firstname, :middlename, :lastname, :program, :email, :filename, "Inactive", "No")');
			$this->db->bind(':student_id', $data['student_id']);
			$this->db->bind(':voter', $voter);
			$this->db->bind(':password', $password);
			$this->db->bind(':firstname', $data['vfirstname']);
			$this->db->bind(':middlename', $data['vmiddlename']);
			$this->db->bind(':lastname', $data['vlastname']);
			$this->db->bind(':program', $data['program']);
			$this->db->bind(':email', $data['email']);
			$this->db->bind(':filename', $photo);

			if($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//activate
		public function activateAll() {
			$this->db->query('UPDATE voters SET statuses = "Active"');
			$this->db->execute();
		}
		//check double email
		public function checkEmailDupe($data) {
			$this->db->query('SELECT * FROM voters WHERE id != :id AND email = :email');
			$this->db->bind(':id', $data['id']);
			$this->db->bind(':email', $data['email']);
			$result = $this->db->resultSet();
			return $result;
		}
		//update voter
		public function updateVoter($data,$email) {
			$this->db->query('UPDATE voters SET firstname = :firstname, middlename = :middlename, lastname = :lastname, program = :program, email = :email WHERE id = :id');
			$this->db->bind(':id', $data['id']);
			$this->db->bind(':firstname', $data['vfirstname']);
			$this->db->bind(':middlename', $data['vmiddlename']);
			$this->db->bind(':lastname', $data['vlastname']);
			$this->db->bind(':program', $data['program']);
			$this->db->bind(':email', $email);

			if($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//delete voter
		public function deleteVoter($id) {
			$this->db->query('DELETE FROM voters WHERE id = :id');
			$this->db->bind(':id', $id);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		/* 
			END --
			OF VOTER MODEL --
			RELATED QUERIES
		*/

		/* 
			START OF POSITION MODEL QUERIES
		*/
		public function getPos($id) {
			$this->db->query('SELECT * FROM positions WHERE id = :id');
			$this->db->bind(':id', $id);
			$result = $this->db->single();
			return $result;
		}
		//get positions ascending
		public function getPositionsAsc() {
			$this->db->query('SELECT * FROM positions ORDER BY priority ASC');
			$result = $this->db->resultSet();
			return $result;
		}
		//get positions descending
		public function getPositionsDesc() {
			$this->db->query('SELECT * FROM positions ORDER BY priority DESC LIMIT 1');
			$result = $this->db->single();
			return $result;
		}
		//add position
		public function addPosition($data,$priority) {
			$this->db->query('INSERT INTO positions (description, max_vote, priority) VALUES (:description, :max_vote, :priority)');
			$this->db->bind(':description', $data['description']);
			$this->db->bind(':max_vote', $data['max_vote']);
			$this->db->bind(':priority', $priority);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//update / edit position
		public function updatePosition($data) {
			$this->db->query('UPDATE positions SET description = :description, max_vote = :max_vote, priority = :priority WHERE id = :id');
			$this->db->bind(':id', $data['id']);
			$this->db->bind(':description', $data['description']);
			$this->db->bind(':max_vote', $data['max_vote']);
			$this->db->bind(':priority', $data['priority']);

			if ($this->db->execute()) {
				return true;
			}		
			else {
				return false;
			}
		}
		//delete position
		public function delPosition($data) {
			$this->db->query('DELETE FROM positions WHERE id = :id');
			$this->db->bind(':id', $data['id']);
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//delete candidate associated with the position
		public function delCandidate($data) {
			$this->db->query('DELETE FROM candidates WHERE position_id = :id');
			$this->db->bind(':id', $data['id']);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//get candidate row
		public function getCanRow($id) {
			$this->db->query('SELECT * FROM candidates WHERE id = :id');
			$this->db->bind(':id', $id);
			$result = $this->db->single();
			return $result;
		}

		//get all officers
		public function getAdmins() {
			$this->db->query('SELECT * FROM admin WHERE id != 1');
			$result = $this->db->resultSet();
			return $result;
		}

		//get officer by id
		public function getOfficer($id) {
			$this->db->query('SELECT * FROM admin WHERE id = :id');
			$this->db->bind(':id', $id);
			$result = $this->db->single();
			return $result;
		}

		//add officer
		public function addOfficer($data, $username, $password) {
			$this->db->query('INSERT INTO admin (username, password, firstname, role, lastname, photo) VALUES (:username, :password, :firstname, "reg_officer", :lastname, :photo)');
			$this->db->bind(':username', $username);
			$this->db->bind(':password', $password);
			$this->db->bind(':firstname', $data['vfirstname']);
			$this->db->bind(':lastname', $data['vlastname']);
			$this->db->bind(':photo', $data['file']);

			$result = $this->db->execute();
			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}

		//delete officer
		public function deleteOfcr($id) {
			$this->db->query('DELETE FROM admin WHERE id = :id');
			$this->db->bind(':id', $id);
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		//get candidates from positions
		public function getCanFP() {
			$this->db->query('SELECT *, 
							 candidates.id AS canid
							 FROM candidates 
							 LEFT JOIN positions 
							 ON positions.id=candidates.position_id 
							 ORDER BY positions.priority ASC');
			$result = $this->db->resultSet();
			return $result;
		}
		//get candidates from positions
		public function getCanFromPos($id) {
			$this->db->query('SELECT *, 
							 candidates.id AS canid 
							 FROM candidates 
							 LEFT JOIN positions 
							 ON positions.id=candidates.position_id 
							 WHERE candidates.id = :id');
			$this->db->bind(':id', $id);
			$result = $this->db->single();
			return $result;
		}
		//add candidates
		public function addCandidates($data,$photoname) {
			$this->db->query('INSERT INTO candidates (position_id, firstname, middlename, lastname, email, program, gender, birthdate, b_address, m_address, contact, photo, platform) VALUES (:position, :firstname, :middlename, :lastname, :email, :program, :gender, :birthdate, :b_address, :m_address, :contact, :filename, :platform)');
			$this->db->bind(':position', $data['position']);
			$this->db->bind(':firstname', $data['vfirstname']);
			$this->db->bind(':middlename', $data['vmiddlename']);
			$this->db->bind(':lastname', $data['vlastname']);
			$this->db->bind(':email', $data['email']);
			$this->db->bind(':program', $data['program']);
			$this->db->bind(':gender', $data['gender']);
			$this->db->bind(':birthdate', $data['birthdate']);
			$this->db->bind(':b_address', $data['birth_address']);
			$this->db->bind(':m_address', $data['address']);
			$this->db->bind(':contact', $data['contact']);
			$this->db->bind(':filename', $photoname);
			$this->db->bind(':platform', $data['platform']);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//edit candidate
		public function editCandidate($data) {
			$this->db->query('UPDATE candidates SET position_id = :position, platform = :platform WHERE id = :id');
			$this->db->bind(':id', $data['id']);
			$this->db->bind(':position', $data['position']);
			$this->db->bind(':platform', $data['platform']);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		//delete candidate
		public function deleteCandidate($id) {
			$this->db->query('DELETE FROM candidates WHERE id = :id');
			$this->db->bind(':id', $id);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//update voter photo
		public function updatePhoto($data) {
			$this->db->query('UPDATE voters SET photo = :filename WHERE id = :id');
			$this->db->bind(':id', $data['id']);
			$this->db->bind(':filename', $data['filename']);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//update candidate photo
		public function updateCandidatePhoto($data,$filename) {
			$this->db->query('UPDATE candidates SET photo = :filename WHERE id = :id');
			$this->db->bind(':id', $data['id']);
			$this->db->bind(':filename', $filename);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		//delete votes
		public function deleteVotes() {
			$this->db->query('DELETE FROM votes');
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

	}

?>