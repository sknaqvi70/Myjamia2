<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddProgram extends CI_Controller {

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
		$this->load->model('AddProgramModel', 'APM');

	}
	public function addProgram(){
		$data['ProgramTypeList'] = $this->APM->getProgramTypeList();
		$data['DepartmentList'] = $this->APM->getDepartmentList();
		$data['message'] = '';
		$this->load->view('/program/addProgram', $data);

	}

	public function registerNewProgram(){
		// 1 UserType must be Selected
			$this->form_validation->set_rules('TP_Program_Type_Name','Program Name','required');

			// 2 User Name is required 
			$this->form_validation->set_rules('TP_Program_DESC','Program Description','required|max_length[50]');

			// 4 University Name is required 
			$this->form_validation->set_rules('TP_Program_Mode','Program Mode','required');

			// 5 Faculty/School/College Name is required 
			$this->form_validation->set_rules('TP_Program_Duration','','required');

			// 6 Depatment Name is required 
			$this->form_validation->set_rules('TP_Program_Start_Date','Program Start Date','required');

			// 7 Gender must be Selected
			$this->form_validation->set_rules('TP_Program_Start_Time','Program Start Time','required');

			//8 Valid DOB is required
			$this->form_validation->set_rules('TP_Program_End_Date','Program End Date','required');

			// 9 email id is required 
			$this->form_validation->set_rules('TP_Program_End_Time','Program End Time','required');

			// 10 Mobile Number is required 
			$this->form_validation->set_rules('TP_Program_Fee','Course Fee', 'required');

			$this->form_validation->set_rules('TP_Program_Organizing_Dept','Program Organizing Depatment','required');

			// 7 Gender must be Selected
			$this->form_validation->set_rules('TP_Program_Organizer_Name','Program Organizer Name','required');

			// 9 email id is required 
			$this->form_validation->set_rules('TP_Program_Organizer_EmailId','Program Organizer Email Id','required');

			// 10 Mobile Number is required 
			$this->form_validation->set_rules('TP_Program_Organizer_MobileNo','Program Organizer Mobile No.', 'required');

			//Set Error Delimeter

			$this->form_validation->set_error_delimiters("<p class='text-danger'>",'</p>');
			
			//Prepare User Type List
			$data['ProgramTypeList'] = $this->APM->getProgramTypeList();
			$data['DepartmentList'] = $this->APM->getDepartmentList();

			if ($this->form_validation->run() == FALSE) {		
	               
	     		//if(validation_errors()) echo validation_errors(); 

	            $data['message'] = 'Please review your data.' ;	 
				$this->load->view('/program/addProgram', $data);

	        }
	        else {
	       		$organizerEMail = $this->input->post('TP_Program_Organizer_EmailId');
	       		$Start 	= $this->input->post('TP_Program_Start_Date');
	       		$End 	= $this->input->post('TP_Program_End_Date');
	       		$MJ_User_ID = $_SESSION['login'];

	       		$timestampStart = strtotime($Start);
	       		$convertStartdate = date("d-m-Y", $timestampStart);
	       		$timestampEnd = strtotime($End);
	       		$convertStartEnd = date("d-m-Y", $timestampEnd);
	       		
				$data['message']  = $this->APM->RegisterProgram(					
					$this->input->post('TP_Program_Type_Name'),
					$this->input->post('TP_Program_DESC'),
					$this->input->post('TP_Program_Mode'),
					$this->input->post('TP_Program_Duration'),
					$convertStartdate,
					$this->input->post('TP_Program_Start_Time'),
					$convertStartEnd,
					$this->input->post('TP_Program_End_Time'),
					$this->input->post('TP_Program_Fee'),
					$MJ_User_ID,
					$this->input->post('TP_Program_Organizing_Dept'),
					$this->input->post('TP_Program_Organizer_Name'),
					$organizerEMail,
					$this->input->post('TP_Program_Organizer_MobileNo'),
					$TpdProgramKey
					);
				if ($data['message'] == 'OK') {
				
					$data = "Your Program Successfully Added, Your Program Regitration No. is - <b>".$TpdProgramKey.'</b>';

					$this->session->set_flashdata('message',$data);
					redirect('AddProgram/addProgram');
					
				}
				
	       		//$this->load->view('/program/addProgram', $data);
	        }	        
	}
}
?>