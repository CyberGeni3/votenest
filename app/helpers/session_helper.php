<?php  
	
	session_start();
	// Flash message helper
	// EXAMPLE - flash('register_success', 'You are not registered', 'alert alert-danger');
	// DISPLAY IN VIEW - echo flash('register_success');
	function flash($name= '', $message= '', $class = 'success') {
		if (!empty($name)) {
			if (!empty($message) && empty($_SESSION[$name])) {
				if (!empty($_SESSION[$name])) {
					unset($_SESSION[$name]);
				}
				if (!empty($_SESSION[$name. '_class'])) {
					unset($_SESSION[$name. '_class']);
				}

				$_SESSION[$name] = $message;
				$_SESSION[$name. '_class'] = $class;
			}
			elseif (empty($message) && !empty($_SESSION[$name])) {
				$class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
				echo '
					<script>
				        var Toast = Swal.mixin({
				          toast: false,
				          position: "center",
				          showConfirmButton: true,
				          timer: 3000,
				          timerProgressBar: true,
				          didOpen: (toast) => {
				            toast.addEventListener("mouseenter", Swal.stopTimer)
				            toast.addEventListener("mouseleave", Swal.resumeTimer)
				          }
				        });
				        Toast.fire({
				          icon: "' . $class . '",
				          title: "' . $_SESSION[$name] . '"
				        });
				    </script>
				';
				unset($_SESSION[$name]);
				unset($_SESSION[$name. '_class']);
			}
		}
	}

	//checks if the user logged in is voter
	function isVoterLoggedIn() {
		if (isset($_SESSION['voter'])) {
				return true;
		}
		else {
			return false;
		}
	}

	//checks if the user logged in is admin
	function isAdminLoggedIn() {
		if (isset($_SESSION['admin'])) {
				return true;
		}
		else {
			return false;
		}
	}

?>