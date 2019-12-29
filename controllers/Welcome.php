<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->view('/public/user_login');
	}

	/* User Login Fuction */
	public function user_login() {

		$this->load->helper('html');
		$this->load->helper('form');	
		//Load Validation Library
		$this->load->Library('form_validation');

		if ($this->input->post('frm_Btn_Submit') == 'Submit') 
				$this->Check_User_Authorization(); 
		else
				{
					//Prepare User Type List
					$this->load->model('UserModel','UM');
					$data['UserTypeList'] = $this->UM->GetUserTypeList(); 
					$this->load->view('/public/register_user',$data);
				}
		
	}


	// This function performs following fucnctions:
	// 1. 	Validate data receveid from register_user form 
	// 2. 	Store User Registration Data
	// 3. 	Sends an Email for EMail Account Verification

	public function register_user() {

			
			$this->load->Library('form_validation');
			$this->load->helper('html');
			$this->load->helper('form');

			//Set Validation Rules
			
			// 1 UserType must be Selected
			$this->form_validation->set_rules('frm_MJ_User_Type','User Type','required|is_natural_no_zero');

			// 2 User ID cannot be blank 
			$this->form_validation->set_rules('frm_MJ_User_Login','ID Number','required|alpha_numeric|max_length[10]');

			//3 User Name is required
			$this->form_validation->set_rules('frm_MJ_User_Name','Password','required|alpha_numeric');

			//4 DOB is required

			//$dt = $this->input->post('frm_MJ_User_DOB'); 

			$this->form_validation->set_rules('frm_MJ_User_DOB','Date of Birth','required|callback_checkDateFormat');

			//Set Error Delimeter

			$this->form_validation->set_error_delimiters("<p class='text-danger'>",'</p>');
			
			if ($this->form_validation->run() == FALSE)
	                {		
	               
	               	//Prepare User Type List
					$this->load->model('UserModel','UM');
					$data['UserTypeList'] = $this->UM->GetUserTypeList(); 
					$this->load->view('/public/register_user',$data);
	                }
	                else
	                {
	        		echo "success";
	        	}
			

	}


	function Check_User_Authorization() {		
			
			//Set Validation Rules
			
			//1 UserName cannot be Blank
			$this->form_validation->set_rules('frm_MJ_User_Login','Username','required');

			//2 Password cannot be blank
			$this->form_validation->set_rules('frm_MJ_User_Password','Password','required');

			//Set Error Delimeter
			$this->form_validation->set_error_delimiters("<p class='text-danger'>",'</p>');
			//Run Validation Test

			if ($this->form_validation->run() == FALSE)
	                {		
	                	//If Validation Fails Load the Form Again
	                    $this->load->view('/public/user_login');
	                }
	                else
	                {
	                	//Get Data from Form
	                	$UserName = $this->input->post('frm_MJ_User_Login');
	                	$Password = $this->input->post('frm_MJ_User_Password');

	                    echo 'Successful. Username = '. $UserName . "   Password = ".$Password;
	                }
	}

	// Check date format, if input date is valid return TRUE else returned FALSE.
	public function checkDateFormat($str) {
		
		if ($str != '') {
			list($day, $month, $year)=explode("/",$str);
	
			if (strpos($str,".") == true) {
				$result =  "Bad date: Point is not allowed.";
			}
			else {
				if (is_numeric($day) == 1 && is_numeric($month) == 1 & is_numeric($year) == 1) {
					if(checkdate($month,$day,$year)) 
						$result =  "good";
					else
						$result =  "Bad date";
				}
				else {
					$result =  "Bad date: Non numeric characters not allowed.";
				}
			}
		}
		else 
			$result = 'The {field} is required';

		if ($result == 'good') {
				return true;
			}
			else {
				$this->form_validation->set_message('checkDateFormat', $result); 
				return false;
			}

	}

}