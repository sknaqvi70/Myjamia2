<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct() {

		parent::__construct();

		if(!isset($_SESSION['login'])) {
			echo 'Unauthorised access is not allowed! Click <a href="'.base_url().'">here</a> to login';
			redirect(base_url());
			
		}

	}

	public function dashboard() {
	 
		$this->load->view('auth/welcome');
	
	}

	// Fuction for Logout Event
	public function user_logout() {
		
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('login');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('useremail');
		$this->session->unset_userdata('userprev');
		$this->session->unset_userdata('usertype');
		$this->session->unset_userdata('userrole');
		$this->session->unset_userdata('menu');
		$this->session->unset_userdata('menuprev');
		$this->session->unset_userdata('ssmid');
		$this->session->unset_userdata('depid');
		$this->session->unset_userdata('depdesc');
		$this->session->unset_userdata('admindepid');
		$this->session->unset_userdata('admindepdesc');


		$data['message'] = 'Thanks for using MyJamia Portal!';
		$data['messageType'] = 'I';
		$this->load->view('/public/user_login',$data);
	}

	
	//This function allows user to Change Password
	public function change_password() {

		//Show Screen to let user enter password
		$PWD1 = $this->input->post('frm_New_Password_1');

		//Set Validation Rules
		// 1 Password cannot be empty
		$this->form_validation->set_rules('frm_MJ_User_Password','Current Password','required|min_length[6]|max_length[20]');

		//2 New Password cannot be empty
		$this->form_validation->set_rules('frm_New_Password_1','New Password','required|min_length[6]|max_length[20]'); 

		//3 Retyped New Password cannot be empty
		$this->form_validation->set_rules('frm_New_Password_2','New Password','required|min_length[6]|max_length[20]|callback_checkPasswordsMatch['.$PWD1.']');

		//Set Error Delimeterss

		//$this->form_validation->set_error_delimiters("<p class='text-danger'>",'</p>');
		//$data['UID'] = $this->input->post('UID'); 

			
		if ($this->form_validation->run() == FALSE) {		
			//if(validation_errors()) echo validation_errors(); 

	        $array = array(
		        'error'							=> 	true,
		        'frm_MJ_User_Password_Error'	=>	form_error('frm_MJ_User_Password'),
		        'frm_New_Password_1_Error' 		=> 	form_error('frm_New_Password_1'),
		        'frm_New_Password_2_Error' 		=> 	form_error('frm_New_Password_2'),
		        'message' 						=>	'Please review your data.'
		       	);
			}
	        else {

	        	//Validation Passes
	        	//Check Old Password
	        	$this->load->model('UserModel','UM');
	        	$User = $_SESSION['user'];
	        	
	        	$Usr = substr($User, 1,1);
				if (ord($Usr) >= 65 && ord($Usr) <= 90 ) {
					if($this->UM->isEmpAuthorised($_SESSION['user'], $this->input->post('frm_MJ_User_Password')) == 'OK') {
		        		//If User is authorised, update password
		        		if($this->UM->updateEmpPassword($User, $this->input->post('frm_New_Password_1')) == 'OK') {

			        	$array = array(
			        		'success'					=>	true,
			        		'message' 					=>	'Password successfully changed.'
			        	);
			        	}
			        	else {
			      			$array = array(
				        	'error'							=> 	true,
				        	'message' 						=>	'Password not updated!'
				       		);
				       	}
		      		}
		      		else {
		      			$array = array(
			        	'error'							=> 	true,
			        	'message' 						=>	'Incorrect Password!'
			       		);
		      		}
				}
				else{
		        	if($this->UM->isUserAuthorised($_SESSION['user'], $this->input->post('frm_MJ_User_Password')) == 'OK') {
		        		//If User is authorised, update password
		        		$this->UM->updatePassword($_SESSION['user'], $this->input->post('frm_New_Password_1'));

			        	$array = array(
			        		'success'					=>	true,
			        		'message' 					=>	'Password successfully changed.'
			        	);
		      		}
		      		else {
		      			$array = array(
			        	'error'							=> 	true,
			        	'message' 						=>	'Incorrect Password!'
			       		);
		      		}
		      	}

	        }
	        
	        echo json_encode($array);	
			
	}

	//Show contact page
	public function contact(){
		
		$this->load->view('auth/contact');
	}

	//Show Welcome page
	public function about(){
		
		$this->load->view('auth/welcome');
	}



	// Check that Passwords are same 
	public function checkPasswordsMatch($str, $str2) {

		if ($str == $str2)
			return true;
		else {
				$this->form_validation->set_message('checkPasswordsMatch', 'Passwords do not match!'); 
				return false;
			}
	}


	
}
