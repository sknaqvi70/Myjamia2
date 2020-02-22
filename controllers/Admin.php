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
		$UserRole= $_SESSION['userrole'];
		if ($UserRole == 'A') {
			$data['year_list']	=$this->admin->getYear();
			$DepId 				= 'ADCIT'; //$_SESSION['login'];
			$UserType			= $_SESSION['usertype'];
			$cc_no 				=$this->admin->fetch_cc_no($DepId);
			$data['open']		=$this->admin->getOpenComplaint($cc_no, $UserType);
			$data['pending']	=$this->admin->getPendingComplaint($cc_no, $UserType);
			$data['hold']		=$this->admin->getHoldComplaint($cc_no, $UserType);
			$data['closed']		=$this->admin->getClosedComplaint($cc_no, $UserType);
	 		$data['total']		=$this->admin->getTotalComplaint($cc_no, $UserType);
		$this->load->view('admin/welcomeAdmin', $data);	
		}else{
			$UserId 					= $_SESSION['login'];
			$data['pending_comp']		= $this->admin->getPendingForAccept($UserId);
			$data['accepted_comp']		= '1'; //$this->admin->getPendingComplaint($cc_no);
			$data['closed_comp']		= '1'; //$this->admin->getClosedComplaint($cc_no);
	 		$data['total_assigned']		= '3'; //$this->admin->getTotalComplaint($cc_no);
		$this->load->view('admin/welcomeHR', $data);
		}
		
	}

	public function complaintStatus(){
		$DepId 						= 'ADCIT'; //$_SESSION['login'];
		$UserType					= $_SESSION['usertype'];
		$cc_no 						=$this->admin->fetch_cc_no($DepId);
		$data['open_no_comp']		=$this->admin->getOpenComplaints($cc_no, $UserType);
        $data['pending_no_comp']	=$this->admin->getPendingComplaints($cc_no, $UserType);
        $data['hold_comp']			=$this->admin->getHoldComplaints($cc_no, $UserType);
        $data['closed_no_comp']		=$this->admin->getClosedComplaints($cc_no, $UserType);
		$data['tot_no_comp']		=$this->admin->getTotalNoComplaints($cc_no, $UserType);
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
	        	$ComplaintData= $this->admin->getSingleComplaintDetails($cmno);
		    	foreach($ComplaintData as $cdata):
					$CM_USER_EMAIL= $cdata->CM_COMPLAINT_CONTACT_EMAIL;
					$CM_USER_NANE= $cdata->NAME;
					$deptdesc= $cdata->DEP_DESC;
					$CM_COMPLAINT_TYPE_DESC= $cdata->CC_NAME;
					$CM_COMPLAINT_SUB_TYPE_DESC= $cdata->CSC_NAME;
					$CM_COMPLAINT_DESC= $cdata->CM_COMPLAINT_TEXT;
					$CM_USER_LOCATION= $cdata->CM_COMPLAINT_LOCATION;
					$CM_USER_MOBILE= $cdata->CM_COMPLAINT_CONTACT_MOBILE;
					$FtsNo= $cdata->CM_COMPLAINT_FTS_NO;
					$Reg_DATE= $cdata->CM_COMPLAINT_DATE;
				endforeach;	
	        	$EmpUserData= $this->admin->fetch_emp_details($cmno,$emp_to_assign);
					foreach($EmpUserData as $eudata):
						$EmpName= $eudata->EMPNAME;
    					$EmpEmailId= $eudata->EMAIL;
    					$EmpPhnoeNo= $eudata->PHONE_NO;
					endforeach;	
				$this->SendMailToUserAndEngineer($cmno,$EmpName,$EmpEmailId,$CM_USER_EMAIL,$CM_USER_NANE,$deptdesc,$CM_COMPLAINT_TYPE_DESC,$CM_COMPLAINT_SUB_TYPE_DESC,$CM_COMPLAINT_DESC,$CM_USER_LOCATION,$CM_USER_MOBILE,$FtsNo,$Reg_DATE);
				}
	        	if ($data['insert'] == 'OK') {
		        	$array = array(
		        	'success'		=>	true,
		        	'message' 		=>	'Complaint Assigned Successfully To '.$EmpName
		        	);      	       		
		        }		        
	        }	        
	        echo json_encode($array);
	        //$this->SendMailToUserAndEngineer($cmno,$emp_to_assign,$cm_priority);	
	} 

	function SendMailToUserAndEngineer($cmno,$EmpName,$EmpEmailId,$CM_USER_EMAIL,$CM_USER_NANE,$deptdesc,$CM_COMPLAINT_TYPE_DESC,$CM_COMPLAINT_SUB_TYPE_DESC,$CM_COMPLAINT_DESC,$CM_USER_LOCATION,$CM_USER_MOBILE,$FtsNo,$Reg_DATE){		
		$this->load->library('email');
		$to = $CM_USER_EMAIL;
		$cc = $EmpEmailId;
		$subject = 'MyJamia Complaint Registration.';
		$from = 'raquib4u@gmail.com';
		$emailContaint ='<!DOCTYPE><html><head></head><body>';       
        $emailContaint .='Dear '.$CM_USER_NANE.',<br><br>'.
						'With refrence to Your Ticket No '.$cmno.', dated '.$Reg_DATE.' this is to update you that the ticket has been assigned to '.$EmpName.'  :<br><br>';
		$emailContaint .='Mr '.$EmpName.' will get in touch with you soon.';
		$emailContaint .='Details about your ticket as fellows :<br><br>';
		$emailContaint .='<table table-striped table-bordered table-hover " width="600"style="font-size:14px; font-family:Calibri; border-radius: 10px;border: 1px solid;">
						<tr>
					  		<td ><strong>&nbsp;&nbsp;Ticket No. :</strong></td><td>'.$cmno.'</std>
					  	</tr>
						<tr>
							<td><strong>&nbsp;&nbsp;Department : </b></strong><td>'.$deptdesc.'<td>
						</tr>
						<tr>
							<td><strong>&nbsp;&nbsp;Complaint Type : </strong></td>
							<td>'.$CM_COMPLAINT_TYPE_DESC.'</td>					  		
						</tr>
						<tr>
							<td><strong>&nbsp;&nbsp;Complaint Sub Type : </strong></td>
							<td>'.$CM_COMPLAINT_SUB_TYPE_DESC.'</td>					  		
						</tr>
						<tr>
							<td ><strong>&nbsp;&nbsp;Complaint Description :</strong></td>
							<td>'.$CM_COMPLAINT_DESC.'</td>							  		
						</tr>
						<tr>
							<td><strong>&nbsp;&nbsp;Complaint Location :</strong></td>
							<td>'.$CM_USER_LOCATION.'</td>							  		
						</tr>
						</table>';
		if ($FtsNo) {
			$emailContaint .="You may track your complaint in MIS using File Number :'.$FtsNo.'<br>Any Complaint or suggestion may be sent to the <a href='mailto:skanqvi@jmi.ac.in'>Additional Director, FTK-CIT, JMI</a>.<br><br><br><br><b>FTK-Centre for Information Technology,<br>JMI</b>	
			</body></html>";
		}else{
		$emailContaint .="<br>Any Complaint or suggestion may be sent to the <a href='mailto:skanqvi@jmi.ac.in'>Additional Director, FTK-CIT, JMI</a>.<br><br><br><br><b>FTK-Centre for Information Technology,<br>JAMIA MILLIA ISLAMIA</b>	
			</body></html>";
		}

		$config['protocol']			='smtp';
		$config['smtp_host']		='ssl://smtp.googlemail.com';
		$config['smtp_port']		='465';
		$config['smtp_timeout']		='60';

		$config['smtp_user']		='raquib4u@gmail.com';
		$config['smtp_pass']		='Raquib*88';

		$config['charset']			='utf-8';
		$config['newline']			="\r\n";
		$config['mailtype']			='html';
		$config['validation']		=TRUE;

		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->from($from, 'Additional Director, CIT');
		$this->email->to($to);
		$this->email->cc($cc);
		$this->email->subject($subject);
		$this->email->message($emailContaint);
		$this->email->send();
		//echo $this->email->print_debugger();
		 /*https://www.google.com/settings/security*/
	}
//-----------------------------------------------------------------------------------------------------
			//For Assign Engineer controller codeigniter
//-----------------------------------------------------------------------------------------------------
 

}