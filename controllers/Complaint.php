<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Complaint extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['login'])) {
			echo 'Unauthorised access is not allowed! Click <a href="'.base_url().'">here</a> to login';
			redirect(base_url());
			
		}
		$this->load->model('ComplaintModel', 'CM');
	}
	// This function performs following fucnctions:
	// 1. 	Validate data receveid from complaintReg form 
	// 2. 	Store User Complaint Data
	// 3. 	Sends an Email for to User for successfull register complaint
	public function complaintRegistration(){

		// 1 Contact Person Name cannot be blank
			$this->form_validation->set_rules('CM_USER_NANE','Contact Person Name','required|alpha_numeric_spaces|max_length[50]');

			// 2 E-Mail Id cannot be blank 			
			$this->form_validation->set_rules('CM_USER_EMAIL','E-Mail Id','required|valid_email');

			//3 Mobile Number cannot be blank
			$this->form_validation->set_rules('CM_USER_MOBILE','Mobile Number','required|max_length[10]');

			//4 Complaint Location cannot be blank
			$this->form_validation->set_rules('CM_USER_LOCATION','Complaint Location','required');

			//5 Complaint Type must be Selected
			$this->form_validation->set_rules('CM_COMPLAINT_TYPE','Complaint Type','required|is_natural_no_zero');

			//6 Complaint Sub Type must be Selected
			$this->form_validation->set_rules('CM_COMPLAINT_SUB_TYPE','Complaint Sub Type','required|is_natural_no_zero');

			//7 Brief Description of Complaint is required
			$this->form_validation->set_rules('CM_COMPLAINT_DESC','Brief Description of Complaint','required|max_length[400]');

			//Set Error Delimeter

			$this->form_validation->set_error_delimiters("<p class='text-danger'>",'</p>');

			$UserType= $_SESSION['usertype'];
			$data['ComplaintTypeList'] = $this->CM->getComplaintCat($UserType);
			
			if ($this->form_validation->run() == FALSE) {		               
	     		
				$this->load->view('auth/complaintReg',$data);

	        }
	        else {

	       		$VerificationString = '';
	       		$dept = $_SESSION['depid'];
	       		$UserId= $_SESSION['login'];
	       		$CM_USER_NANE			= $this->input->post('CM_USER_NANE');
	       		$CM_USER_EMAIL			= $this->input->post('CM_USER_EMAIL');
	       		$CM_USER_MOBILE			= $this->input->post('CM_USER_MOBILE');
	       		$CM_USER_LOCATION		= $this->input->post('CM_USER_LOCATION');
	       		$CM_COMPLAINT_TYPE 		= $this->input->post('CM_COMPLAINT_TYPE');
	       		$CM_COMPLAINT_SUB_TYPE 	= $this->input->post('CM_COMPLAINT_SUB_TYPE');
	       		$CM_COMPLAINT_DESC		= $this->input->post('CM_COMPLAINT_DESC'); 

				$data['message']  = $this->CM->RegisterComplaint(
	       				$dept,
	       				$UserId,
	       				$CM_COMPLAINT_TYPE,
	       				$CM_COMPLAINT_SUB_TYPE,
	       				$CM_COMPLAINT_DESC,
	       				$CM_USER_LOCATION,
	       				$CM_USER_NANE,
	       				$CM_USER_MOBILE,
	       				$CM_USER_EMAIL,	       				
						$VerificationString
				);
				if ($data['message'] == 'OK') {

					$data['message'] = "An email has been sent to your Email Id Please login to your mailbox to verify your email and complete Registration.";
				}
	       		$this->load->view('auth/complaintReg',$data);
	       	}
	}
	// This function performs to fetch sub category of complaint
	public function getComplaintSubCategory(){
		$UserType= $_SESSION['usertype'];
		$postData = $this->input->post('v_MJ_COMPLAINT_TYPE');    
    	$data = $this->CM->getComplaintSubCat($postData,$UserType);        
    	echo json_encode($data); 
	}	
	

}
?>