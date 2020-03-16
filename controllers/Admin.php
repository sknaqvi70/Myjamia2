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
			/*$data['year_list']	=$this->admin->getYear();
			$Complaint_year		= $this->input->post('CM_YEAR');
			if ($Complaint_year == '') {
				$Current_year = date('Y');
			}else{
				$Current_year = $this->input->post('CM_YEAR');
			}*/
			$DepId 				= $_SESSION['admindepid'];
			$UserType			= $_SESSION['usertype'];
			$cc_no 				=$this->admin->fetch_cc_no($UserType, $DepId);
			$data['open']		=$this->admin->getOpenComplaint($cc_no, $UserType);
			$data['pending_at']	=$this->admin->getPendingAcceptance($cc_no, $UserType);
			$data['pending']	=$this->admin->getPendingComplaint($cc_no, $UserType);
			$data['hold']		=$this->admin->getHoldComplaint($cc_no, $UserType);
			$data['closed']		=$this->admin->getClosedComplaint($cc_no, $UserType);
	 		$data['total']		=$this->admin->getTotalComplaint($cc_no, $UserType);
		$this->load->view('admin/welcomeAdmin', $data);	
		}else{
			$UserId 					= $_SESSION['login'];
			$data['pending_comp']		= $this->admin->getPendingForAccept($UserId);
			$data['accepted_comp']		= $this->admin->getAcceptedComplaint($UserId);
			$data['closed_comp']		= $this->admin->fetchClosedComplaint($UserId);
	 		$data['total_assigned']		= $this->admin->getTotalAssign($UserId);
		$this->load->view('admin/welcomeHR', $data);
		}
		
	}

	public function complaintStatus(){
		$DepId 				= $_SESSION['admindepid'];
		$UserType					= $_SESSION['usertype'];
		$cc_no 						=$this->admin->fetch_cc_no($UserType,$DepId);
		$data['open_no_comp']		=$this->admin->getOpenComplaints($cc_no, $UserType);
        $data['pending_for_accept']	=$this->admin->getPendingAtEngineer($cc_no, $UserType);
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
		$DepId 					= $_SESSION['admindepid'];
		$UserType				= $_SESSION['usertype'];
		$cc_no 					=$this->admin->fetch_cc_no($UserType,$DepId);
		$data['single_comp']	=$this->admin->getSingleComplaintDetails($cc_no, $cmData);
		$this->load->view('admin/viewComplaint', $data);
		}
	}

	// This function use for to Assign the complaint and fetch the details
	public function AsignComplaints(){
		$cmData = $this->input->post('v_cm_no');
		if(isset($cmData) and !empty($cmData)){
		$DepId 					= $_SESSION['admindepid'];	
		$UserType				= $_SESSION['usertype'];
		$cc_no 					=$this->admin->fetch_cc_no($UserType, $DepId);
		$data['single_comp']	=$this->admin->getSingleComplaintDetails($cc_no, $cmData);
		$data['unit_Assigned']	= $this->admin->get_Tot_Assign_Unit($cmData);
		$data['UserList']		=$this->admin->getAssignDetails($cmData);
		$this->load->view('admin/assignComplaint', $data);
		}
	}

	//this function is use for insert assign details
	public function complaintAssignTo(){	
		//Show Screen data
		$cmno 	= $this->input->post('CM_NO');
		$cm_priority 	= $this->input->post('frm_Complaint_Priority');
		$emp_to_assign 	= $this->input->post('frm_MJ_User');	
		$cm_no_unit 	= $this->input->post('frm_CM_No_Unit_Assign');
		$tot_Units 			= $this->admin->get_Tot_unit($cmno);
		$tot_Unit_Assign 	= $this->admin->get_Tot_Assign_Unit($cmno);
		$pending = $tot_Units-$tot_Unit_Assign;
		// 1 Employee must be select
		$this->form_validation->set_rules('frm_MJ_User','Employee','required|min_length[5]|max_length[10]');
		// 1 Priority must be select
		$this->form_validation->set_rules('frm_Complaint_Priority','Priority','required');	
		// 1 Priority must be select
		if ($pending == 0) {
		$this->form_validation->set_rules('frm_CM_No_Unit_Assign','Number of Unit to be Assign','required|less_than_equal_to['.$tot_Units.']');
		}else{
		$this->form_validation->set_rules('frm_CM_No_Unit_Assign','Number of Unit to be Assign','required|is_natural_no_zero|less_than_equal_to['.$pending.']');	
		}
		if ($this->form_validation->run() == FALSE) {		
			//if(validation_errors()) echo validation_errors(); 
	        $array = array(
		        'error'							=> 	true,
		        'frm_MJ_User_Error'				=>	form_error('frm_MJ_User'),
		        'frm_Complaint_priority_Error'	=>	form_error('frm_Complaint_Priority'),
		        'frm_CM_No_Unit_Assign_Error'	=>	form_error('frm_CM_No_Unit_Assign'),
		        'message' 						=>	'Please review your data.'
		       	);
			}
	        else {

	        	$data['insert']  = $this->admin->AssignCompalintStatus($cmno,$emp_to_assign, $cm_priority,$cm_no_unit,$tot_Units,$tot_Unit_Assign );

	        	if ($data['insert'] == 'OK') {
	        	$DepId 			= $_SESSION['admindepid'];	
				$UserType		= $_SESSION['usertype'];
				$cc_no 			=$this->admin->fetch_cc_no($UserType, $DepId);
	        	$ComplaintData	= $this->admin->getSingleComplaintDetails($cc_no, $cmno);
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
		$subject = 'MyJamia Complaint Notification for Assign to Resource.';
		$from = 'admin.myjamia@jmi.ac.in';
		$emailContaint ='<!DOCTYPE><html><head></head><body>';       
        $emailContaint .='Dear '.$CM_USER_NANE.',<br><br>'.
						'With refrence to Your <b>Ticket No '.$cmno.'</b>, dated '.$Reg_DATE.' this is to update you that the ticket has been assigned to <b>Mr '.$EmpName.'</b>  :<br><br>';
		$emailContaint .='<b>Mr '.$EmpName.'</b> will get in touch with you soon.';
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

		$config['smtp_user']		='admin.myjamia@jmi.ac.in';
		$config['smtp_pass']		='Comp!@#123';

		$config['charset']			='utf-8';
		$config['newline']			="\r\n";
		$config['mailtype']			='html';
		$config['validation']		=TRUE;

		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->from($from, 'Complaint Admin, JMI');
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
 	public function complaintStatusHR(){
 		$DepId 						= $_SESSION['admindepid'];
		$UserType					= $_SESSION['usertype'];
		$UserId						= $_SESSION['login'];
		$cc_no 						=$this->admin->fetch_cc_no($UserType, $DepId);
		$data['pending_accept']		=$this->admin->getPendingComplaintForAccept($UserId);
		$data['accepted_comp']		=$this->admin->getAcceptedComplaints($UserId);
		$data['hold_comp']			=$this->admin->getPutOnHoldComplaints($UserId);
		$data['closed_no_comp']		=$this->admin->fetchClosedComplaints($UserId);
		//$data['accepted_comp']
		$data['tot_no_assigned']	=$this->admin->getToTNoAssign($cc_no,$UserId);
		$this->load->view('admin/complaintStatusHR', $data);
	}

	public function hr_acceptance(){ 		
		$UserId				= $_SESSION['login'];
		$UserName			= $_SESSION['username'];		
		$cmno 				= $this->input->post('id');
		$tot_Units 			= $this->admin->get_Tot_unit($cmno);
		$tot_Unit_Assign 	= $this->admin->get_Tot_Accept_Unit($cmno);
		$Unit_Assign_hr 	= $this->admin->get_Unit_Assign_hr($cmno,$UserId);
		
		$data['insert']  	= $this->admin->AssignCompalintAcceptance($cmno, $UserId ,$UserName,$tot_Units,$tot_Unit_Assign,$Unit_Assign_hr);
		if ($data['insert'] == 'OK') {
		$this->session->set_flashdata('msg',"Complaint accepted successfully.");
    	$this->session->set_flashdata('msg_class','alert-success');
    	}
    	return redirect('Admin/complaintStatusHR');
	}

	public function complaintStatusUpdate(){
		$cmData = $this->input->post('v_cm_no');
		if(isset($cmData) and !empty($cmData)){
		$DepId 					= $_SESSION['admindepid'];	
		$UserType				= $_SESSION['usertype'];
		$cc_no 					=$this->admin->fetch_cc_no($UserType, $DepId);
		$data['single_comp']	=$this->admin->getSingleComplaintDetails($cc_no, $cmData);

		$this->load->view('admin/ComplaintStatusUpdate', $data);
		}
	}

	//this function is use for insert assign details
	public function complaintUpdateStatus(){		

		//Show Screen data
		$UserId				= $_SESSION['login'];
		$UserName			= $_SESSION['username'];
		$cmno 				= $this->input->post('CM_NO');
		$cm_status 			= $this->input->post('frm_Complaint_Status');
		$cm_Remarks 		= $this->input->post('CM_COMPLAINT_REMARKS');
		$tot_Units 			= $this->admin->get_Tot_unit($cmno);
		$tot_Unit_Closed 	= $this->admin->get_Tot_Closed_Unit($cmno);
		$Unit_Assign_hr 	= $this->admin->get_Unit_Assign_hr($cmno,$UserId);	
		
		// 1 Employee must be select
		$this->form_validation->set_rules('frm_Complaint_Status','Select Complaint Status','required');
		// 1 Priority must be select
		$this->form_validation->set_rules('CM_COMPLAINT_REMARKS','Please Update complaint Status in this box ','required');		

		if ($this->form_validation->run() == FALSE) {		
			//if(validation_errors()) echo validation_errors(); 
	        $array = array(
		        'error'							=> 	true,
		        'frm_Complaint_Status_Error'	=>	form_error('frm_Complaint_Status'),
		        'CM_COMPLAINT_REMARKS_Error'	=>	form_error('CM_COMPLAINT_REMARKS'),
		        'message' 						=>	'Please review your data.'
		       	);
			}
	        else {

	        	$data['insert']  = $this->admin->compalintStatusUpdated($cmno,$cm_status, $cm_Remarks,$UserId,$UserName, $tot_Units, $tot_Unit_Closed, $Unit_Assign_hr);

	        	if ($data['insert'] == 'OK' && $cm_status == 'C'){	        	
	        		$DepId 			= $_SESSION['admindepid'];	
					$UserType		= $_SESSION['usertype'];
					$EmpName		= $_SESSION['username'];
					$ResourceId 			= $_SESSION['login'];
					$EmpEmailId 	= $_SESSION['useremail'];
					$cc_no 			=$this->admin->fetch_cc_no($UserType, $DepId);
	        		$ComplaintData	= $this->admin->getSingleComplaintDetails($cc_no, $cmno);
		    			foreach($ComplaintData as $cdata):
							$COMPLAINT_USER_ID 			= $cdata->COMPLAINT_USER_ID;
							$CM_USER_EMAIL				= $cdata->CM_COMPLAINT_CONTACT_EMAIL;
							$CM_USER_NANE				= $cdata->NAME;
							$deptdesc					= $cdata->DEP_DESC;
							$CM_COMPLAINT_TYPE_DESC 	= $cdata->CC_NAME;
							$CM_COMPLAINT_SUB_TYPE_DESC = $cdata->CSC_NAME;
							$CM_COMPLAINT_DESC 			= $cdata->CM_COMPLAINT_TEXT;
							$CM_USER_LOCATION 			= $cdata->CM_COMPLAINT_LOCATION;
							$CM_USER_MOBILE 			= $cdata->CM_COMPLAINT_CONTACT_MOBILE;
							$FtsNo 						= $cdata->CM_COMPLAINT_FTS_NO;
							$Reg_DATE 					= $cdata->CM_COMPLAINT_DATE;
						endforeach;	
	        	
					$this->SendMailForStatus($cmno,$EmpName,$EmpEmailId,$CM_USER_EMAIL,$CM_USER_NANE,$deptdesc,$CM_COMPLAINT_TYPE_DESC,$CM_COMPLAINT_SUB_TYPE_DESC,$CM_COMPLAINT_DESC,$CM_USER_LOCATION,$CM_USER_MOBILE,$FtsNo,$Reg_DATE,$Unit_Assign_hr,$tot_Units);

					$VerificationString	= $this->admin->getVerificationString($cmno);
					$this->SendMailForFeedback($cmno,$EmpName,$ResourceId,$VerificationString,$CM_USER_EMAIL,$COMPLAINT_USER_ID,$CM_USER_NANE,$Unit_Assign_hr,$tot_Units);
				}					
	        	
	        	if ($data['insert'] == 'OK') {
		        	$array = array(
		        	'success'		=>	true,
		        	'message' 		=>	'Status of Complaint No - '.$cmno.' Updated Successfully.'
		        	);      	       		
		        }		        
	        }	        
	        echo json_encode($array);
	        //$this->SendMailToUserAndEngineer($cmno,$emp_to_assign,$cm_priority);	
	} 

	function SendMailForStatus($cmno,$EmpName,$EmpEmailId,$CM_USER_EMAIL,$CM_USER_NANE,$deptdesc,$CM_COMPLAINT_TYPE_DESC,$CM_COMPLAINT_SUB_TYPE_DESC,$CM_COMPLAINT_DESC,$CM_USER_LOCATION,$CM_USER_MOBILE,$FtsNo,$Reg_DATE,$Unit_Assign_hr,$tot_Units){		
		$this->load->library('email');
		$to = $CM_USER_EMAIL;
		$cc = $EmpEmailId;
		$subject = 'MyJamia Complaint Notification for Close.';
		$from = 'admin.myjamia@jmi.ac.in';
		$emailContaint ='<!DOCTYPE><html><head></head><body>';       
        $emailContaint .='Dear '.$CM_USER_NANE.',<br><br>'.
						'With refrence to Your <b>Ticket No '.$cmno.'</b>, dated '.$Reg_DATE.' raised by you as per details provided below of unit '.$Unit_Assign_hr.' out of total unit '.$tot_Units.' given by you has been Closed by <b>Mr '.$EmpName.'</b>  :<br><br>';			
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
						</table> <br><br>';
		
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

		$config['smtp_user']		='admin.myjamia@jmi.ac.in';
		$config['smtp_pass']		='Comp!@#123';

		$config['charset']			='utf-8';
		$config['newline']			="\r\n";
		$config['mailtype']			='html';
		$config['validation']		=TRUE;

		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->from($from, 'Complaint Admin, JMI');
		$this->email->to($to);
		$this->email->cc($cc);
		$this->email->subject($subject);
		$this->email->message($emailContaint);
		$this->email->send();
		//echo $this->email->print_debugger();
		 /*https://www.google.com/settings/security*/
	}

	// this function is used for to shoot mail for feedback
	function SendMailForFeedback($cmno,$ResourceName,$ResourceId,$RandomChallengeText,$sendto,$complaint_user_id,$complaint_user_name,$Unit_Assign_hr,$tot_Units){
		//Encode UserID
		$EncryptedResourceID 	= $this->MyJamiaEncrypt($ResourceId);
		$EncryptedRName 		= $this->MyJamiaEncrypt($ResourceName);
		$EncryptedCUserID 		= $this->MyJamiaEncrypt($complaint_user_id);
		$Encryptedsendto 		= $this->MyJamiaEncrypt($sendto);
		date_default_timezone_set('Asia/Kolkata');
		$currentTime = $this->MyJamiaEncrypt(date( 'd-m-Y h:i:s A', time () ));


		$this->load->library('email');
		$to 			= $sendto;
		$subject 		= 'MyJamia Complaint Notification for feedback.';
		$from 			= 'admin.myjamia@jmi.ac.in';
		$emailContaint 	='<!DOCTYPE><html><head></head><body>';       
        $emailContaint .='Dear '.$complaint_user_name.',<br><br>'.
							  'With reference to your complaint ticket No.<b> '.$cmno.'</b>, you are requested to provide the feeback about the services of <b>Mr. '.$ResourceName.'</b>, by <a href='.base_url().'Feedback/complaintFeedback?RID='.$EncryptedResourceID.'&rntext='.$EncryptedRName.'&rtext='.$RandomChallengeText.'&CM='.$cmno.'&CUID='.$EncryptedCUserID.'&to='.$Encryptedsendto.'&cttext='.$currentTime. '>clicking here</a> for '.$Unit_Assign_hr.' Unit of equipment/services out of total complaint Units '.$tot_Units.'.<br><br>';
		$emailContaint .='<br><font color="red">Please note that feedback link will remain active for 48 hours. In case no feedback is received from your side will assume that you were satisfied with the services.</font>';
		$emailContaint .="<br><br><br>FTK-Centre for Information Technology,<br>JAMIA MILLIA ISLAMIA</b></body></html>";
		
		//added by raquib
		$config['protocol']			='smtp';
		$config['smtp_host']		='ssl://smtp.googlemail.com';
		$config['smtp_port']		='465';
		$config['smtp_timeout']		='60';

		$config['smtp_user']		='admin.myjamia@jmi.ac.in';
		$config['smtp_pass']		='Comp!@#123';

		$config['charset']			='utf-8';
		$config['newline']			="\r\n";
		$config['mailtype']			='html';
		$config['validation']		=TRUE;
		//added by raquib
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->from($from, 'Complaint Admin JMI');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($emailContaint);

		$this->email->send();
		//echo $this->email->print_debugger();

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

	//function for revert back 
	public function complaintRevertBack(){
		$cmData = $this->input->post('v_cm_no');
		if(isset($cmData) and !empty($cmData)){
		$DepId 					= $_SESSION['admindepid'];	
		$UserType				= $_SESSION['usertype'];
		$cc_no 					=$this->admin->fetch_cc_no($UserType, $DepId);
		$data['single_comp']	=$this->admin->getSingleComplaintDetails($cc_no, $cmData);
		$data['AssignList']		=$this->admin->getAssignList($cmData);

		$this->load->view('admin/complaintRevertBack', $data);
		}
	}

	//this function is use for insert assign details
	public function complaintRevertStatus(){		

		//Show Screen data
		$cmno 				= $this->input->post('CM_NO');		
		$revert_user		= $this->input->post('frm_Revert_User');
		$cm_revert 			= $this->input->post('frm_Complaint_Revert');
		$cm_revert_Remarks 	= $this->input->post('CM_COMPLAINT_REMARKS');	
		
		// 1 Employee must be select
		$this->form_validation->set_rules('frm_Revert_User','Assign Employee must be select','required|min_length[5]|max_length[10]');
		// 2 Complaint status must be select
		$this->form_validation->set_rules('frm_Complaint_Revert','Select Complaint Status','required');
		// 3 Remarks
		$this->form_validation->set_rules('CM_COMPLAINT_REMARKS','Please Update complaint Status in this box ','required');		

		if ($this->form_validation->run() == FALSE) {		
			//if(validation_errors()) echo validation_errors(); 
	        $array = array(
		        'error'							=> 	true,
		        'frm_Revert_User_Error'			=>	form_error('frm_Revert_User'),
		        'frm_Complaint_Revert_Error'	=>	form_error('frm_Complaint_Revert'),
		        'CM_COMPLAINT_REMARKS_Error'	=>	form_error('CM_COMPLAINT_REMARKS'),
		        'message' 						=>	'Please review your data.'
		       	);
			}
	        else {

	        	$data['insert']  = $this->admin->complaintRevertBackStatus($cmno,$revert_user,$cm_revert, $cm_revert_Remarks );	        	
	        	if ($data['insert'] == 'OK') {
		        	$array = array(
		        	'success'		=>	true,
		        	'message' 		=>	'Status of Complaint No - '.$cmno.' Successfully Revert Back.'
		        	);      	       		
		        }		        
	        }	        
	        echo json_encode($array);
	        //$this->SendMailToUserAndEngineer($cmno,$emp_to_assign,$cm_priority);	
	} 

}