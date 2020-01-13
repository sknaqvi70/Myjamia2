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
	public function index() {

		$data['message'] = 'Welcome to MyJamia Portal!';
		$data['messageType'] = 'I';
		$this->load->view('/public/user_login',$data);
	}

	/* User Login & New registration Fuction */
	public function user_login() {

		if ($this->input->post('frm_Btn_Submit') == 'Sign in') {
			$AccountStatus = $this->Check_User_Authorization(); 
			
			if ($AccountStatus == 'OK') {
	            //Authorised User
	            $this->PrepareUserSession();
	            unset($_POST['frm_Btn_Submit']);
				return redirect('auth/dashboard');
	         }
	        else {
		        if ($AccountStatus == 'E') //Expired
		        	$data['message'] = 'Your account has expired! Pl. contact FTK-CIT.';
		        elseif ($AccountStatus == 'DNE') //Does not exists
		        	$data['message'] = 'Invalid login/password. Pl. try again!';
		        else
		        	$data['message'] = 'Please enter your login name and password carefully!';
		                    
		        $data['messageType'] = 'D';
		      
		        $this->load->view('/public/user_login',$data);
		    }
	    }
		elseif ($this->input->post('frm_Btn_Submit') == 'New User Registration') {
			//Prepare User Type List
			$this->load->model('UserModel','UM');
			$data['UserTypeList'] = $this->UM->GetUserTypeList(); 
			$data['message'] = '';
			$this->load->view('/public/register_user',$data);
		}	
		else
			redirect(base_url());
		}


	// This function performs following fucnctions:
	// 1. 	Validate data receveid from register_user form 
	// 2. 	Store User Registration Data
	// 3. 	Sends an Email for EMail Account Verification
	public function register_user() {

			
			//$this->load->Library('form_validation');
			//Set Validation Rules
			
			// 1 UserType must be Selected
			$this->form_validation->set_rules('frm_MJ_User_Type','User Type','required|is_natural_no_zero');

			// 2 User ID cannot be blank 
			$this->load->database();
			$this->form_validation->set_rules('MJ_UR_ID_NO','ID Number','required|alpha_numeric|max_length[10]|is_unique[MJ_USER_REGISTRATION.MJ_UR_ID_NO]');

			//3 User Name is required
			$this->form_validation->set_rules('frm_MJ_User_Name','User Name','required|alpha_numeric_spaces|max_length[50]');

			//4 Valid DOB is required
			$this->form_validation->set_rules('frm_MJ_User_DOB','Date of Birth','required|callback_checkDateFormat');

			//Set Error Delimeter

			$this->form_validation->set_error_delimiters("<p class='text-danger'>",'</p>');
			
			//Prepare User Type List
			$this->load->model('UserModel','UM');
			$data['UserTypeList'] = $this->UM->GetUserTypeList();

			if ($this->form_validation->run() == FALSE) {		
	               
	     		//if(validation_errors()) echo validation_errors(); 

	            $data['message'] = 'Please review your data.' ;	 
				$this->load->view('/public/register_user',$data);

	        }
	        else {
	       		$UserEMail = '';
	       		$VerificationString = '';
	        	$this->load->model('UserModel','UM');
				$data['message']  = $this->UM->RegisterUser(
						$this->input->post('frm_MJ_User_Type'),
						$this->input->post('MJ_UR_ID_NO'),
						$this->input->post('frm_MJ_User_Name'),
						$this->input->post('frm_MJ_User_DOB'),
						$UserEMail,
						$VerificationString
				);
				if ($data['message'] == 'OK') {

					$this->SendMail($UserEMail, $this->input->post('MJ_UR_ID_NO'), $VerificationString);
				
					$data['message'] = "An email containing account verification link has been sent to ".
					$this->MaskUserEMail($UserEMail). ' Pl. login to your mailbox to verify your email and complete Registration.';
				}
	       		$this->load->view('/public/register_user',$data);
	        }
	}


	// This function performs following fucnctions:
	// 1. 	Validates data receveid from SetUserPassword View 
	// 2. 	Sends an Email for EMail Account Verification
	public function set_account_password() {

			$PWD = $this->input->post('MJ_USER_PASSWORD');
			//Set Validation Rules
			// 1 Password cannot be empty
			$this->form_validation->set_rules('MJ_USER_PASSWORD','Password','required|min_length[6]|max_length[20]');

			// 2 Retyped Password cannot be empty
			$this->form_validation->set_rules('MJ_USER_PASSWORD_RETRY','Password','required|min_length[6]|max_length[20]|callback_checkPasswordsMatch['.$PWD.']');

			//Set Error Delimeter

			$this->form_validation->set_error_delimiters("<p class='text-danger'>",'</p>');
			$data['UID'] = $this->input->post('UID'); 

			
			if ($this->form_validation->run() == FALSE) {		
	               
	     		//if(validation_errors()) echo validation_errors(); 

	           	$data['message'] = 'Please review your data.' ;	
	           	$data['messageType'] = 'D';
				$this->load->view('/public/SetAccountPassword',$data);

	        }
	        else {
	       		$this->load->model('UserModel','UM');
				$data['message']  = $this->UM->AddUser(
						$this->input->post('UID'),
						$this->input->post('MJ_USER_PASSWORD')
				);
				if ($data['message'] == 'OK') {
				
					$data['message'] = 'MyJamia Account has been successfully created. You may now login.';
					$data['messageType'] = 'S';
					$this->load->view('/public/user_login',$data);
				}
				elseif ($data['message'] == 'Duplicate') {
					$data['message'] = 'Account already exists!';
					$data['messageType'] = 'D';
					$this->load->view('/public/SetAccountPassword',$data);
				}
				else
				{
					$data['message'] = 'Cannot create MyJamia Account. Please contact FTK-CIT.';
					$data['messageType'] = 'D';
					$this->load->view('/public/SetAccountPassword',$data);

				}
	       			
	        }
	}

	//This function verifies that User has access to the email account.
	//Function is invoked by the user by clicking the URL sent to him/her in the email.
	public function verifyAccount() {

		//Get Value of UserId from URL
		$UID = $this->MyJamiaDecrypt($this->input->get('UID'));
		//Get value of rtext from URL
		$RText = $this->input->get('rtext');

		$this->load->model('UserModel','UM');

		$data['VerificationResult'] = $this->UM->VerifyEMailAccount($UID, $RText);
		$data['UID'] = $UID;

		$data['message'] = 'Please set your password';
		$data['messageType'] = 'I';
		// 	$VerificationResult == 1  	=>  Passed verification
		//	$VerificationResult == -1 	=>	Account already created
		//	$VerificationResult == 0 	=>	Verification failed

		$this->load->view('/public/SetAccountPassword',$data);
	}

	//This function Checks Users Authorisation
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
	                	//If Validation Fails Return Status to the calling form.
	                    return false;  
	                }
	                else
	                {
	                	//Get Data from Form
	                	$UserName = $this->input->post('frm_MJ_User_Login');
	                	$Password = $this->input->post('frm_MJ_User_Password');
	                	$this->load->model('UserModel', 'UM');

	                	return $this->UM->isUserAuthorised($UserName, $Password);
	                }
	}
			
	//This function prepares User Session
	function PrepareUserSession(){
		
		$UserID = $this->input->post('frm_MJ_User_Login');

		$this->load->model('UserModel', 'UM');
		$UserType =  $this->UM->getUserType($UserID);

		if ($UserType == 2) {//User is employee
			$UserName = $this->UM->getEmpName('EMP\\'.$UserID);

		}
		$this->load->model('MenuModel');
		$UserMenu =  $this->MenuModel->getUserMenu($UserType);

		$sessionData = array(
			'login'		=> 	$UserID,
        	'username'  => 	$UserName,
        	'usertype'	=>	$UserType
        	'menu' 		=> 	$UserMenu
		);

		$this->session->set_userdata($sessionData);
	}	
	

	//----------------- SUPPORT FUNCTIONS ---------------------

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

	// Check that Passwords are same 
	public function checkPasswordsMatch($str, $str2) {

		//if ($str == $this->input->post('MJ_USER_PASSWORD'))
		if ($str == $str2)
			return true;
		else {
				$this->form_validation->set_message('checkPasswordsMatch', 'Passwords do not match!'); 
				return false;
			}
	}

	//Function to Send Verification Mail
	function SendMail($to, $UserID, $RandomChallengeText){

		//Encode UserID
		$EncryptedUserID = $this->MyJamiaEncrypt($UserID);

		$this->load->library('email');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->from('kazim.jmi@gmail.com', 'Additional Director, CIT');
		$this->email->to($to);
		$this->email->subject('MyJamia Account Verification Mail.');
		$this->email->message('<html>Dear Sir/Madam,<br>'.
							  'With reference to your request for account creation on MyJamia Portal, please click <a href=http://localhost:8080/CI/Welcome/verifyAccount?UID='.$EncryptedUserID.'&rtext='.$RandomChallengeText. '>here</a> to verify your account and set password for your account. <br><br>CIT, JMI</html>');
		
		
		$this->email->send();
		echo $this->email->print_debugger();
	}

	//Function to Mask User EMail
	function MaskUserEMail($email){

		$maskedEMail = '';
		$positionOfAt = strpos($email, '@');
		$maskedEMail .= substr($email, 0,1);
		for($i=1; $i < strlen($email); $i++) {
			if($i < $positionOfAt-1 || $i > $positionOfAt + 1)
				$maskedEMail .= '*';
			else
				$maskedEMail .= substr($email, $i,1);
		}
		$maskedEMail .= substr($email, $i-1,1);
		return $maskedEMail;
	}

	//Function to Enrypt a string
	function MyJamiaEncrypt($str) {
		
		// Store the cipher method 
		$ciphering = "AES-128-CTR"; 
  
		// Use OpenSSl Encryption method 
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
  
		// Non-NULL Initialization Vector for encryption 
		$encryption_iv = '1234567891011121'; 
  
		// Store the encryption key 
		$encryption_key = "MyJamiaEncryptionString"; 
  
		// Use openssl_encrypt() function to encrypt the data 
		return openssl_encrypt($str, $ciphering, 
		            $encryption_key, $options, $encryption_iv); 
  	}

  	//Function to Decrypt a string
	function MyJamiaDecrypt($str) {

		// Store the cipher method 
		$ciphering = "AES-128-CTR"; 
  
		// Use OpenSSl Encryption method 
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
				
		// Non-NULL Initialization Vector for decryption 
		$decryption_iv = '1234567891011121'; 
		  
		// Store the decryption key 
		$decryption_key = "MyJamiaEncryptionString"; 
		  
		// Use openssl_decrypt() function to decrypt the data 
		return openssl_decrypt ($str, $ciphering,  
		        $decryption_key, $options, $decryption_iv); 	  
	}

}