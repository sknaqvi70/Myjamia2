<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->model('AdminModel', 'admin');

	}

	public function dashboard() {
		$data['year_list']=$this->admin->getYear();
		$data['open']=$this->admin->getOpenComplaint();
		//$data['pending']=$this->admin->getPendingComplaint();
		$data['hold']=$this->admin->getHoldComplaint();
		$data['closed']=$this->admin->getClosedComplaint();
	 	$data['total']=$this->admin->getTotalComplaint();

	 	/*$query = $this->db->query("SELECT COUNT(*) as COUNT FROM COMPLAINT_MST WHERE CM_COMPLAINT_CATEGORY=1
					GROUP BY TO_CHAR(CM_COMPLAINT_DATE, 'YYYY') ORDER BY TO_CHAR(CM_COMPLAINT_DATE, 'YYYY')"); 
        $data['total_data'] = json_encode(array_column($query->result(), 'COUNT'),JSON_NUMERIC_CHECK);

        $query = $this->db->query("SELECT COUNT(*) as COUNT FROM COMPLAINT_MST WHERE CM_COMPLAINT_CATEGORY=1 AND CM_COMPLAINT_STATUS IN ('R','O') GROUP BY TO_CHAR(CM_COMPLAINT_DATE, 'YYYY') ORDER BY TO_CHAR(CM_COMPLAINT_DATE, 'YYYY')"); 
        $data['opend_data'] = json_encode(array_column($query->result(), 'COUNT'),JSON_NUMERIC_CHECK);

        $query = $this->db->query("SELECT COUNT(*) as COUNT FROM COMPLAINT_MST WHERE CM_COMPLAINT_CATEGORY=1 and CM_COMPLAINT_STATUS = 'P' GROUP BY TO_CHAR(CM_COMPLAINT_DATE, 'YYYY') ORDER BY TO_CHAR(CM_COMPLAINT_DATE, 'YYYY')"); 
        $data['hold_data'] = json_encode(array_column($query->result(), 'COUNT'),JSON_NUMERIC_CHECK);

        $query = $this->db->query("SELECT COUNT(*) as COUNT FROM COMPLAINT_MST WHERE CM_COMPLAINT_CATEGORY=1 and CM_COMPLAINT_STATUS = 'C' GROUP BY TO_CHAR(CM_COMPLAINT_DATE, 'YYYY') ORDER BY TO_CHAR(CM_COMPLAINT_DATE, 'YYYY')"); 
        $data['closed_data'] = json_encode(array_column($query->result(), 'COUNT'),JSON_NUMERIC_CHECK);*/


		$this->load->view('admin/welcomeAdmin', $data);	
	}

	/*public function fetch_data(){
		$cyear = $this->input->post('year');
		$total_data=$this->admin->fetch_total_comp($cyear);	 	
		foreach ($total_data->result_array() as $row)
        {
        	echo $row["MONTHS"];
        	//echo $row["COMPLAINTS"];
        	$output[]= array(
        		'MONTH'			=>	$row["MONTHS"],
        		'COMPLAINTS'	=>	$row["COMPLAINTS"]
        	);
        	
        }
        echo json_encode($total_data);
	}*/

	public function complaintStatus(){		
        $data['open_no_comp']=$this->admin->getOpenComplaints();
        $data['pending_no_comp']=$this->admin->getPendingComplaints();
        $data['closed_no_comp']=$this->admin->getClosedComplaints();
		$data['tot_no_comp']=$this->admin->getTotalNoComplaints();
		$this->load->view('admin/complaintStatus', $data);
	}

	// This function use for to fetch single data to view in details
	public function viewComplaintDetails(){
		$cmData = $this->input->post('v_cm_no');
		if(isset($cmData) and !empty($cmData)){
		$data['single_comp']=$this->admin->getSingleComplaintDetails($cmData);
		$this->load->view('admin/viewComplaint', $data);
		}
	}

	// This function use for to Assign the complaint and fetch the details
	public function AsignComplaints(){
		$cmData = $this->input->post('v_cm_no');
		if(isset($cmData) and !empty($cmData)){
		$data['single_comp']=$this->admin->getSingleComplaintDetails($cmData);
		$data['UserList']=$this->admin->getAssignDetails($cmData);
		$this->load->view('admin/assignComplaint', $data);
		}
	}

	//this function is use for insert assign details
	public function complaintAssignTo(){

		//Show Screen data
		$cmno 	= $this->input->post('CM_NO');
		$cm_priority 	= $this->input->post('frm_Complaint_Priority');
		$emp_to_assign 	= $this->input->post('frm_MJ_User');
		
		// 1 Employee must be select
		$this->form_validation->set_rules('frm_MJ_User','Employee','required|min_length[5]|max_length[10]');
		// 1 Priority must be select
		$this->form_validation->set_rules('frm_Complaint_Priority','Priority','required');		

		if ($this->form_validation->run() == FALSE) {		
			//if(validation_errors()) echo validation_errors(); 
	        $array = array(
		        'error'							=> 	true,
		        'frm_MJ_User_Error'				=>	form_error('frm_MJ_User'),
		        'frm_Complaint_priority_Error'	=>	form_error('frm_Complaint_Priority'),
		        'message' 						=>	'Please review your data.'
		       	);
			}
	        else {

	        	$data['insert']  = $this->admin->AssignCompalintStatus($cmno,$emp_to_assign, $cm_priority );
	        	if ($data['insert'] == 'OK') {
		        	$array = array(
		        	'success'		=>	true,
		        	'message' 		=>	'Complaint Assigned Successfully'
		        );
		        }
		        else
		        {
		        	$array = array(
		        	'error'							=> 	true,
		        	'message' 						=>	'Complaint not Assigned!'
		       		);
		        } 
	        }	        
	        echo json_encode($array);	
	} 

}