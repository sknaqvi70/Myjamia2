<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class AdminModel extends CI_Model {
	/**
	 * Some Short Form used for Status of complaint in this Model.
	 *
	 * R - Registed Complaint
	 * A - Assigned Complaint
	 * P - Pending Complaint
	 * H - Put On Hold Complaints
	 * C - Closed Complaints
	 * O - Re open Complaints
	 */
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}
	//this function is use for fetch year of complaints
	public function getYear(){
		$cyear="TO_CHAR(CM_COMPLAINT_DATE, 'YYYY')";
		$cyear_desc="TO_CHAR(CM_COMPLAINT_DATE, 'YYYY') DESC";
		$this->db->select(''.$cyear.' YEAR');
		$this->db->group_by($cyear);
		$this->db->order_by(''.$cyear_desc.'');
		$data = $this->db->get('COMPLAINT_MST');
		//$YrList[0] = 'Select Year';      	
      	foreach($data->result() as $v_Year) 
        	$YrList[$v_Year->YEAR] = $v_Year->YEAR;     
    	return $YrList; 			
	}

	// This function find departmental email id for from email id
	public function fetch_cc_no($UserType, $DepId){
		$this->db->distinct('CSC_CC_NO');
		$this->db->select('CSC_CC_NO CCNO');
		$this->db->where('CSC_USER_TYPE',$UserType);
		$query1 = $this->db->get_compiled_select('COMPLAINT_SUB_CATEGORY');

		$this->db->distinct('MJ_CC_NO');
		$this->db->select('MJ_CC_NO CCNO');
		$this->db->join('ALL_DEP_MST A', 'A.DEP_ID=M.MJ_UCTA_DEPID');
		$this->db->where('M.MJ_UCTA_DEPID',$DepId);
		$query2 = $this->db->get_compiled_select('MJ_USER_COMP_TYPE_AUTH M');
		$data = $this->db->query($query1 . ' UNION ' . $query2);
  		$row = $data->row();
		if (isset($row))
		     return $row->CCNO;
	}
	//this function is use for fetch open complaints
	public function getOpenComplaint($cc_no, $UserType){
		$where = "CM_COMPLAINT_STATUS IN ('R')";
        $this->db->select('count(*) OPEN_COMPLAINT');
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=A.CM_COMPLAINT_SUB_CATEGORY');
		$this->db->from('COMPLAINT_MST A');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('C.CSC_USER_TYPE', $UserType);
		$this->db->where($where);
		$query = $this->db->get();		
		if($query->num_rows() > 0) 
				return $query->row()->OPEN_COMPLAINT;
			else
				return '0'; //Error	
	}
	//this function is use for fetch pending for Acceptance 
	public function getPendingAcceptance($cc_no, $UserType){
		$where = "CM_COMPLAINT_STATUS IN ('A')";
        $this->db->select('count(*) PENDING_COMPLAINT');
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=A.CM_COMPLAINT_SUB_CATEGORY');
		$this->db->from('COMPLAINT_MST A');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('C.CSC_USER_TYPE', $UserType);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->PENDING_COMPLAINT;
			else
				return '0'; //Error	
	}
	//this function is use for fetch pending for Acceptance 
	public function getPendingComplaint($cc_no, $UserType){
		$where = "CM_COMPLAINT_STATUS IN ('P')";
        $this->db->select('count(*) PENDING_COMPLAINT');
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=A.CM_COMPLAINT_SUB_CATEGORY');
		$this->db->from('COMPLAINT_MST A');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('C.CSC_USER_TYPE', $UserType);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->PENDING_COMPLAINT;
			else
				return '0'; //Error	
	}
	//this function is use for fetch on hold complaints due to shortage of parts
	public function getHoldComplaint($cc_no, $UserType){
		$where = "CM_COMPLAINT_STATUS IN ('H')";
        $this->db->select('count(*) PENDING_COMPLAINT');
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=A.CM_COMPLAINT_SUB_CATEGORY');
		$this->db->from('COMPLAINT_MST A');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('C.CSC_USER_TYPE', $UserType);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->PENDING_COMPLAINT;
			else
				return '0'; //Error	
	}
	//this function is use for fetch closed complaints
	public function getClosedComplaint($cc_no, $UserType){
		$where = "CM_COMPLAINT_STATUS IN ('C')";
        $this->db->select('count(*) CLOSED_COMPLAINT');
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=A.CM_COMPLAINT_SUB_CATEGORY');
		$this->db->from('COMPLAINT_MST A');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('C.CSC_USER_TYPE', $UserType);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->CLOSED_COMPLAINT;
			else
				return '0'; //Error	
	}
	//this function is use for fetch total complaints
	public function getTotalComplaint($cc_no, $UserType){
		$where = "CM_COMPLAINT_STATUS NOT IN ('O')";
        $this->db->select('count(*) TOTAL_COMPLAINT');
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=A.CM_COMPLAINT_SUB_CATEGORY');
		$this->db->from('COMPLAINT_MST A');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('C.CSC_USER_TYPE', $UserType);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->TOTAL_COMPLAINT;
			else
				return '0'; //Error	
	}
	
	//this function is use for fetch details Open Complaints 
	public function getOpenComplaints($cc_no, $UserType){          			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,CM_COMPLAINT_DATE,					A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('B.CSC_USER_TYPE', $UserType);
		$this->db->where('A.CM_COMPLAINT_STATUS','R');
		$this->db->order_by('CM_NO', 'DESC');
		$query = $this->db->get();				
		return $query->result();			
	}

	//this function is use for fetch details getPendingAtEngineer
	public function getPendingAtEngineer($cc_no, $UserType){          			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,CMM_DESC EMPNAME,				A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('MJ_COMPLAINT_ASSIGN_DTL C', 'A.CM_NO= C.MJ_CAD_CM_NO ');
		$this->db->join('DEP_MST D', 'A.CM_DEP_ID= D.DEP_ID ');
		$this->db->join('COMPANY_MST F', 'C.MJ_CAD_CMM_ID= F.CMM_ID ');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('B.CSC_USER_TYPE', $UserType);
		$this->db->where('A.CM_COMPLAINT_STATUS','A');
		//$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query1 = $this->db->get_compiled_select();

		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,EMP_NAME(EMP_ID) EMPNAME,				A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('MJ_COMPLAINT_ASSIGN_DTL C', 'A.CM_NO= C.MJ_CAD_CM_NO ');
		$this->db->join('DEP_MST D', 'A.CM_DEP_ID= D.DEP_ID ');
		$this->db->join('EMP_MST E', 'C.MJ_CAD_EMP_ID= E.EMP_ID ');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('B.CSC_USER_TYPE', $UserType);
		$this->db->where('A.CM_COMPLAINT_STATUS','A');
		//$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query2 = $this->db->get_compiled_select();
		$data = $this->db->query($query1 . ' UNION ' . $query2);		
		return $data->result();			
	}
	//this function is use for fetch details Pending Complaints
	public function getPendingComplaints($cc_no, $UserType){          			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,CMM_DESC EMPNAME,				A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('MJ_COMPLAINT_ASSIGN_DTL C', 'A.CM_NO= C.MJ_CAD_CM_NO ');
		$this->db->join('DEP_MST D', 'A.CM_DEP_ID= D.DEP_ID ');
		$this->db->join('COMPANY_MST F', 'C.MJ_CAD_CMM_ID= F.CMM_ID ');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('B.CSC_USER_TYPE', $UserType);
		$this->db->where('A.CM_COMPLAINT_STATUS','P');
		//$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query1 = $this->db->get_compiled_select();

		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,EMP_NAME(EMP_ID) EMPNAME,				A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('MJ_COMPLAINT_ASSIGN_DTL C', 'A.CM_NO= C.MJ_CAD_CM_NO ');
		$this->db->join('DEP_MST D', 'A.CM_DEP_ID= D.DEP_ID ');
		$this->db->join('EMP_MST E', 'C.MJ_CAD_EMP_ID= E.EMP_ID ');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('B.CSC_USER_TYPE', $UserType);
		$this->db->where('A.CM_COMPLAINT_STATUS','P');
		//$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query2 = $this->db->get_compiled_select();
		$data = $this->db->query($query1 . ' UNION ' . $query2);		
		return $data->result();			
	}
	//this function is use for fetch details Hold Complaints
	public function getHoldComplaints($cc_no, $UserType){          			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,				A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('B.CSC_USER_TYPE', $UserType);
		$this->db->where('A.CM_COMPLAINT_STATUS','H');
		$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query = $this->db->get();		
		return $query->result();			
	}
	//this function is use for fetch details Closed Complaints
	public function getClosedComplaints($cc_no, $UserType){          			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,					A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('B.CSC_USER_TYPE', $UserType);
		$this->db->where('A.CM_COMPLAINT_STATUS','C');
		$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query = $this->db->get();		
		return $query->result();			
	}
	//this function is use for fetch details Total Complaints
	public function getTotalNoComplaints($cc_no, $UserType){	     
		$where = "CM_COMPLAINT_STATUS NOT IN ('O')";     			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,					A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');
		$this->db->where('A.CM_COMPLAINT_CATEGORY', $cc_no);
		$this->db->where('B.CSC_USER_TYPE', $UserType);
		$this->db->where($where);
		$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query = $this->db->get();		
		return $query->result();			
	}

	public function getSingleComplaintDetails($cc_no, $cmData){	
	//for Employee 
		$where = "CM_EMP_ID IS NOT NULL";         			
		$this->db->select('CM_NO, "DEP_DESC", EMP_NAME(A.CM_EMP_ID) NAME,"CC_NAME","CSC_NAME", CM_COMPLAINT_TEXT, CM_COMPLAINT_LOCATION, CM_COMPLAINT_CONTACT_PERSON,CM_COMPLAINT_CONTACT_MOBILE, CM_COMPLAINT_CONTACT_EMAIL, CM_COMPLAINT_FTS_NO, CM_COMPLAINT_STATUS,CM_COMPLAINT_DATE');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_CATEGORY D', 'A.CM_COMPLAINT_CATEGORY=D.CC_NO');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',$cc_no);
		$this->db->where('A.CM_NO',$cmData);
		$this->db->where($where);
		$query1 = $this->db->get_compiled_select();	

		//for Student 
		$where = "CM_STU_ID IS NOT NULL";
		$this->db->select('CM_NO, "DEP_DESC", STU_NAME(A.CM_STU_ID) NAME,"CC_NAME","CSC_NAME", CM_COMPLAINT_TEXT, CM_COMPLAINT_LOCATION, CM_COMPLAINT_CONTACT_PERSON,CM_COMPLAINT_CONTACT_MOBILE, CM_COMPLAINT_CONTACT_EMAIL, CM_COMPLAINT_FTS_NO, CM_COMPLAINT_STATUS,CM_COMPLAINT_DATE');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_CATEGORY D', 'A.CM_COMPLAINT_CATEGORY=D.CC_NO');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',$cc_no);
		$this->db->where('A.CM_NO',$cmData);
		$this->db->where($where);
		$query2 = $this->db->get_compiled_select();

		//for contrator and profession staff
		$where = "CM_CMM_ID IS NOT NULL";
		$this->db->select('CM_NO, "DEP_DESC", CMM_DESC NAME,"CC_NAME","CSC_NAME", CM_COMPLAINT_TEXT, CM_COMPLAINT_LOCATION, CM_COMPLAINT_CONTACT_PERSON,CM_COMPLAINT_CONTACT_MOBILE, CM_COMPLAINT_CONTACT_EMAIL, CM_COMPLAINT_FTS_NO, CM_COMPLAINT_STATUS,CM_COMPLAINT_DATE');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_CATEGORY D', 'A.CM_COMPLAINT_CATEGORY=D.CC_NO');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('COMPANY_MST C', 'A.CM_CMM_ID = C.CMM_ID');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',$cc_no);
		$this->db->where('A.CM_NO',$cmData);
		$this->db->where($where);
		$query3 = $this->db->get_compiled_select();

		$data = $this->db->query($query1 . ' UNION ' . $query2 . ' UNION ' . $query3);		
		return $data->result();		
	}

	public function getAssignDetails($cmData){ 
		$this->db->select('CM_COMPLAINT_SUB_CATEGORY');
		$this->db->where('CM_NO',$cmData);
		$query = $this->db->get('COMPLAINT_MST');
		$res=$query->result();        
       	$str = "";
       	foreach ($res as $record)
       	$str .= $record->CM_COMPLAINT_SUB_CATEGORY ;

        /*$this->db->select('MJ_CHD_USER_ID,CMM_DESC NAME');	
		$this->db->join('COMPANY_MST C','C.CMM_ID=M.MJ_CHD_USER_ID');
		$this->db->where('M.MJ_CHD_CSC_NO',$str);
		$query1 = $this->db->get_compiled_select('MJ_COMPLAINT_HR_DTL M');

       	$this->db->select('MJ_CHD_USER_ID,EMP_NAME(EMP_ID) NAME');	
		$this->db->join('EMP_MST E','E.EMP_ID=M.MJ_CHD_USER_ID');
		$this->db->where('M.MJ_CHD_CSC_NO',$str);
		$query2 = $this->db->get_compiled_select('MJ_COMPLAINT_HR_DTL M');
		//making union both fee
		$data = $this->db->query($query1 . ' UNION ' . $query2);*/
		$data=$this->db->query("SELECT MJ_CHD_USER_ID, C.CMM_DESC||' - (No of Complaints - '||(SELECT COUNT(MJ_CAD_CMM_ID) FROM MJ_COMPLAINT_ASSIGN_DTL A WHERE A.MJ_CAD_CMM_ID=M.MJ_CHD_USER_ID AND MJ_CAD_COMPLAINT_STATUS IN ('Assigned','Accepted') )||')' NAME
			FROM MJ_COMPLAINT_HR_DTL M
			JOIN COMPANY_MST C ON C.CMM_ID=M.MJ_CHD_USER_ID
			WHERE M.MJ_CHD_CSC_NO = '$str' 
			UNION 
			SELECT MJ_CHD_USER_ID, EMP_NAME(EMP_ID)||' - (No of Complaints - '||(SELECT COUNT(MJ_CAD_CMM_ID) FROM MJ_COMPLAINT_ASSIGN_DTL A 
			WHERE A.MJ_CAD_CMM_ID=M.MJ_CHD_USER_ID AND MJ_CAD_COMPLAINT_STATUS IN ('Assigned','Accepted'))||')' NAME
			FROM MJ_COMPLAINT_HR_DTL M
			JOIN EMP_MST E ON E.EMP_ID=M.MJ_CHD_USER_ID
			WHERE M.MJ_CHD_CSC_NO = '$str'");		
		$EMPList[0] = 'Select User';
      	
      	foreach($data->result() as $User) 
        	$EMPList[$User->MJ_CHD_USER_ID] = $User->NAME;
    	return $EMPList;   	

	}

	public function AssignCompalintStatus($cmno, $emp_to_assign, $cm_priority ){

		$reg_date=date('d-m-Y');

		$AssignmentNo = $this->get_New_CAD_NO();
		$ActionTicketNo = $this->get_New_CA_NO();
		
		if (strlen($emp_to_assign) == 10) { 
		// when complaint assign to regular employee this else condition run
			$data = array(
		    'MJ_CAD_ID' 				=>  $AssignmentNo,
		    'MJ_CAD_CM_NO' 				=> 	$cmno,
		    'MJ_CAD_EMP_ID' 			=> 	$emp_to_assign,
		    'MJ_CAD_CMM_ID' 			=> 	'',
		    'MJ_CAD_ASSIGN_DATE' 		=> 	$reg_date,
		    'MJ_CAD_COMPLAINT_STATUS'	=>	'Assigned',	// Assign to Engineer
		    'MJ_CAD_CLOSED_DATE' 		=>	'',
		    'MJ_CAD_PRIORITY'			=>	$cm_priority,
		    'MJ_CAD_REMARKS'			=>	'Assigned To User ID- '.$emp_to_assign.', Updated On '.$reg_date
			);			
			$response = $this->db->insert('MJ_COMPLAINT_ASSIGN_DTL', $data);	
		if ($response) {
			$data = array(
		    'MJ_CA_ID' 			=>  $ActionTicketNo,
		    'MJ_CA_CAD_ID' 		=> 	$AssignmentNo,
		    'MJ_CA_CM_NO' 		=> 	$cmno,
		    'MJ_CA_ACTION' 		=> 	'Assigned',
		    'MJ_CA_ACTION_DATE' => 	$reg_date,
		    'MJ_CA_REMARKS'		=>	'Assigned To User ID- '.$emp_to_assign.', Assigned On '.$reg_date
			);			
			$result = $this->db->insert('MJ_COMPLAINT_ACTION_DTL', $data);
		}
		if ($result) {
			$status = 'A'; 
			$this->db->set('CM_COMPLAINT_STATUS', $status);
			$this->db->where('CM_NO', $cmno);
			$this->db->update('COMPLAINT_MST');			
		}		
		}
		else // when complaint assign to contractor employee this else condition run
		{
			$data = array(
		    'MJ_CAD_ID' 					=>  $AssignmentNo,
		    'MJ_CAD_CM_NO' 					=> 	$cmno,
		    'MJ_CAD_EMP_ID' 				=> 	'',
		    'MJ_CAD_CMM_ID' 				=> 	$emp_to_assign,
		    'MJ_CAD_ASSIGN_DATE' 			=> 	$reg_date,
		    'MJ_CAD_COMPLAINT_STATUS'		=>	'Assigned',	// Assign to Engineer
		    'MJ_CAD_CLOSED_DATE' 			=>	'',
		    'MJ_CAD_PRIORITY'				=>	$cm_priority,
		    'MJ_CAD_REMARKS'			=>	'Assigned To User ID- '.$emp_to_assign.', Assigned On '.$reg_date
			);			
			$response = $this->db->insert('MJ_COMPLAINT_ASSIGN_DTL', $data);			
		}	
		if ($response) {
			$data = array(
		    'MJ_CA_ID' 			=>  $ActionTicketNo,
		    'MJ_CA_CAD_ID' 		=> 	$AssignmentNo,
		    'MJ_CA_CM_NO' 		=> 	$cmno,
		    'MJ_CA_ACTION' 		=> 	'Assigned',
		    'MJ_CA_ACTION_DATE' => 	$reg_date,
		    'MJ_CA_REMARKS'		=>	'Assigned To User ID- '.$emp_to_assign.', Assigned On '.$reg_date
			);			
			$result = $this->db->insert('MJ_COMPLAINT_ACTION_DTL', $data);
		}
		if ($result) {
			$status = 'A'; 
			$this->db->set('CM_COMPLAINT_STATUS', $status);
			$this->db->where('CM_NO', $cmno);
			$this->db->update('COMPLAINT_MST');			
		}
		return $result;
	}

	//This function Finds New COMPLAINT ASSIGN Id from MJ_COMPLAINT_ASSIGN_DTL table
	public function get_New_CAD_NO(){

		$this->db->select_max('MJ_CAD_ID');
		$query = $this->db->get('MJ_COMPLAINT_ASSIGN_DTL'); 
		$row = $query->row();

		if (isset($row))
		     return $row->MJ_CAD_ID + 1;
	}

	// fetch employee  details
	public function fetch_emp_details($cmno, $emp_to_assign){
		$this->db->select('CM_COMPLAINT_SUB_CATEGORY');
		$this->db->where('CM_NO',$cmno);
		$query = $this->db->get('COMPLAINT_MST');
		$res=$query->result();        
       	$str = "";
       	foreach ($res as $record)
       	$str .= $record->CM_COMPLAINT_SUB_CATEGORY ;

		$this->db->select('C.CMM_ADDR.MAIL EMAIL,C.CMM_ADDR.RES_PHNO PHONE_NO,CMM_DESC EMPNAME');	
		$this->db->join('COMPANY_MST C','C.CMM_ID=M.MJ_CHD_USER_ID');
		$this->db->where('M.MJ_CHD_CSC_NO',$str);
		$this->db->where('M.MJ_CHD_USER_ID',$emp_to_assign);
		$query1 = $this->db->get_compiled_select('MJ_COMPLAINT_HR_DTL M');

       	$this->db->select('E.EMP_TEMPORARY_ADD.MAIL EMAIL,E.EMP_TEMPORARY_ADD.RES_PHNO PHONE_NO,EMP_NAME(EMP_ID) EMPNAME');	
		$this->db->join('EMP_MST E','E.EMP_ID=M.MJ_CHD_USER_ID');
		$this->db->where('M.MJ_CHD_CSC_NO',$str);
		$this->db->where('M.MJ_CHD_USER_ID',$emp_to_assign);
		$query2 = $this->db->get_compiled_select('MJ_COMPLAINT_HR_DTL M');
		//making union both fee
		$data = $this->db->query($query1 . ' UNION ' . $query2);
		return $data->result();
		}
		
//-----------------------------------------------------------------------------------------------------
			//For Assign Engineer Model codeigniter
//-----------------------------------------------------------------------------------------------------
	public function getPendingForAccept($UserId){
		$User = substr($UserId, 1,1);
		if (ord($User) >= 65 && ord($User) <= 90 ) {//checking user
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Assigned')";
        $this->db->select('count(*) PENDING_FOR_ACCEPT');
		$this->db->from('MJ_COMPLAINT_ASSIGN_DTL');
		$this->db->where('MJ_CAD_EMP_ID','EMP\\'.$UserId);
		$this->db->where($where);
		}else{
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Assigned')";
		$this->db->select('count(*) PENDING_FOR_ACCEPT');
		$this->db->from('MJ_COMPLAINT_ASSIGN_DTL');
		$this->db->where('MJ_CAD_CMM_ID',$UserId);
		$this->db->where($where);
		}		
		$query = $this->db->get();
				
		if($query->num_rows() > 0) 
				return $query->row()->PENDING_FOR_ACCEPT;
			else
				return '0'; //Error	
	
	}

	public function getAcceptedComplaint($UserId){
		$User = substr($UserId, 1,1);
		if (ord($User) >= 65 && ord($User) <= 90 ) {//checking user
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Accepted')";
        $this->db->select('count(*) ACCEPTED_COMPLAINT');
		$this->db->from('MJ_COMPLAINT_ASSIGN_DTL');
		$this->db->where('MJ_CAD_EMP_ID','EMP\\'.$UserId);
		$this->db->where($where);
		}else{
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Accepted')";
		$this->db->select('count(*) ACCEPTED_COMPLAINT');
		$this->db->from('MJ_COMPLAINT_ASSIGN_DTL');
		$this->db->where('MJ_CAD_CMM_ID',$UserId);
		$this->db->where($where);
		}			
		$query = $this->db->get();
				
		if($query->num_rows() > 0) 
				return $query->row()->ACCEPTED_COMPLAINT;
			else
				return '0'; //Error	
	
	}

	public function fetchClosedComplaint($UserId){
		$User = substr($UserId, 1,1);
		if (ord($User) >= 65 && ord($User) <= 90 ) {//checking user
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Closed')";
        $this->db->select('count(*) CLOSED_COMPLAINT');
		$this->db->from('MJ_COMPLAINT_ASSIGN_DTL');
		$this->db->where('MJ_CAD_EMP_ID','EMP\\'.$UserId);
		$this->db->where($where);
		$query = $this->db->get();
		}else{
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Closed')";
		$this->db->select('count(*) CLOSED_COMPLAINT');
		$this->db->from('MJ_COMPLAINT_ASSIGN_DTL');
		$this->db->where('MJ_CAD_CMM_ID',$UserId);
		$this->db->where($where);
		$query = $this->db->get();
		}
		if($query->num_rows() > 0) 
				return $query->row()->CLOSED_COMPLAINT;
			else
				return '0'; //Error	
	
	}

	public function getTotalAssign($UserId){
		$User = substr($UserId, 1,1);
		if (ord($User) >= 65 && ord($User) <= 90 ) { //checking user
        $this->db->select('count(*) TOTAL_ASSIGN');
		$this->db->from('MJ_COMPLAINT_ASSIGN_DTL');
		$this->db->where('MJ_CAD_EMP_ID','EMP\\'.$UserId);
		}else{
		$this->db->select('count(*) TOTAL_ASSIGN');
		$this->db->from('MJ_COMPLAINT_ASSIGN_DTL');
		$this->db->where('MJ_CAD_CMM_ID',$UserId);
		}
		$query = $this->db->get();				
		if($query->num_rows() > 0) 
				return $query->row()->TOTAL_ASSIGN;
			else
				return '0'; //Error	
	
	}

	public function getPendingComplaintForAccept($UserId){
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Assigned')";
		$orderBy = "MJ_CAD_PRIORITY DESC";
        $this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_CMM_ID',$UserId);
		$this->db->where($where);
		$query1 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');

		$this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_EMP_ID','EMP\\'.$UserId);
		$this->db->where($where);	
		$this->db->order_by($orderBy);	
		$query2 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');
		$data = $this->db->query($query1 . ' UNION ' . $query2);
		return $data->result();	
	
	}

	public function getAcceptedComplaints($UserId){
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Accepted')";
		$orderBy = "MJ_CAD_PRIORITY DESC";
        $this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_CMM_ID',$UserId);
		$this->db->where($where);
		$query1 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');

		$this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_EMP_ID','EMP\\'.$UserId);
		$this->db->where($where);	
		$this->db->order_by($orderBy);	
		$query2 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');
		$data = $this->db->query($query1 . ' UNION ' . $query2);
		return $data->result();	
	
	}

	public function getPutOnHoldComplaints($UserId){
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Put On Hold')";
		$orderBy = "MJ_CAD_PRIORITY DESC";
        $this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_CMM_ID',$UserId);
		$this->db->where($where);
		$query1 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');

		$this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_EMP_ID','EMP\\'.$UserId);
		$this->db->where($where);	
		$this->db->order_by($orderBy);	
		$query2 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');
		$data = $this->db->query($query1 . ' UNION ' . $query2);
		return $data->result();	
	
	}

	public function fetchClosedComplaints($UserId){
		$where = "MJ_CAD_COMPLAINT_STATUS IN ('Closed')";
		$orderBy = "MJ_CAD_PRIORITY DESC";
        $this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_CMM_ID',$UserId);
		$this->db->where($where);
		$query1 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');

		$this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_EMP_ID','EMP\\'.$UserId);
		$this->db->where($where);	
		$this->db->order_by($orderBy);	
		$query2 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');
		$data = $this->db->query($query1 . ' UNION ' . $query2);
		return $data->result();	
	
	}

	public function getToTNoAssign($cc_no,$UserId){
		$orderBy = "MJ_CAD_PRIORITY DESC";
        $this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_CMM_ID',$UserId);
		$query1 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');

		$this->db->select('MJ_CAD_ID, MJ_CAD_CM_NO,CSC_NAME,CM_COMPLAINT_TEXT, MJ_CAD_EMP_ID, MJ_CAD_CMM_ID, MJ_CAD_ASSIGN_DATE, MJ_CAD_COMPLAINT_STATUS,MJ_CAD_CLOSED_DATE, MJ_CAD_PRIORITY');  
        $this->db->join('COMPLAINT_MST B','A.MJ_CAD_CM_NO=B.CM_NO');      
        $this->db->join('COMPLAINT_SUB_CATEGORY C','C.CSC_NO=B.CM_COMPLAINT_SUB_CATEGORY');        
		$this->db->join('MJ_COMPLAINT_ACTION_DTL D', 'A.MJ_CAD_ID=D.MJ_CA_CAD_ID');
		$this->db->where('A.MJ_CAD_EMP_ID','EMP\\'.$UserId);
		$this->db->order_by($orderBy);	
		$query2 = $this->db->get_compiled_select('MJ_COMPLAINT_ASSIGN_DTL A');
		$data = $this->db->query($query1 . ' UNION ' . $query2);
		return $data->result();	
	
	}

	public function AssignCompalintAcceptance($cmno, $UserId, $UserName){

		$reg_date=date('d-m-Y');
		$ActionTicketNo = $this->get_New_CA_NO();
		$AssignmentNo 	= $this->getAssignNo($cmno);

		$data = array(
		    'MJ_CA_ID' 			=>  $ActionTicketNo,
		    'MJ_CA_CAD_ID' 		=> 	$AssignmentNo,
		    'MJ_CA_CM_NO' 		=> 	$cmno,
		    'MJ_CA_ACTION' 		=> 	'Accepted',
		    'MJ_CA_ACTION_DATE' => 	$reg_date,
		    'MJ_CA_REMARKS'		=>	'Accepted By- '.$UserName.', User ID- '.$UserId.', Updated On '.$reg_date
			);			
			$respose = $this->db->insert('MJ_COMPLAINT_ACTION_DTL', $data);			
		if ($respose) {
			$status 	= 'Accepted';
			$Remarks 	= 'Accepted By- '.$UserName.', User ID- '.$UserId.', Updated On '.$reg_date;
			$this->db->set('MJ_CAD_COMPLAINT_STATUS', $status);
			$this->db->set('MJ_CAD_REMARKS', $Remarks);
			$this->db->where('MJ_CAD_CM_NO', $cmno);
			$result = $this->db->update('MJ_COMPLAINT_ASSIGN_DTL');			
		}
		if ($result) {
			$status = 'P'; // P== Pending at Engineer
			$this->db->set('CM_COMPLAINT_STATUS', $status);
			$this->db->where('CM_NO', $cmno);
			$this->db->update('COMPLAINT_MST');			
		}
		return $result;		

	}

	//This function Finds New COMPLAINT ACTION Id from MJ_COMPLAINT_ACTION_DTL table
	public function get_New_CA_NO(){
		$this->db->select_max('MJ_CA_ID');
		$query = $this->db->get('MJ_COMPLAINT_ACTION_DTL'); 
		$row = $query->row();
		if (isset($row))
		     return $row->MJ_CA_ID + 1;
	}

	//This function Finds New COMPLAINT ASSIGN Id from MJ_COMPLAINT_ASSIGN_DTL table
	public function getAssignNo($cmno){

		$this->db->select('MJ_CAD_ID');
		$query = $this->db->get('MJ_COMPLAINT_ASSIGN_DTL'); 
		$this->db->where('MJ_CAD_CM_NO', $cmno);
		$row = $query->row();

		if (isset($row))
		     return $row->MJ_CAD_ID;
	}

	public function compalintStatusUpdated($cmno,$cm_status, $cm_Remarks){
		$reg_date		= date('d-m-Y');
		$UserId 		= $_SESSION['login'];
		$ActionTicketNo = $this->get_New_CA_NO();
		$AssignmentNo 	= $this->getAssignNo($cmno);
		if ($cm_status == 'P') {
		$data = array(
		    'MJ_CA_ID' 			=>  $ActionTicketNo,
		    'MJ_CA_CAD_ID' 		=> 	$AssignmentNo,
		    'MJ_CA_CM_NO' 		=> 	$cmno,
		    'MJ_CA_ACTION' 		=> 	'Accepted',
		    'MJ_CA_ACTION_DATE' => 	$reg_date,
		    'MJ_CA_REMARKS'		=>	$cm_Remarks
			);			
			$result = $this->db->insert('MJ_COMPLAINT_ACTION_DTL', $data);			
		}elseif ($cm_status == 'H') {		
		$data = array(
		    'MJ_CA_ID' 			=>  $ActionTicketNo,
		    'MJ_CA_CAD_ID' 		=> 	$AssignmentNo,
		    'MJ_CA_CM_NO' 		=> 	$cmno,
		    'MJ_CA_ACTION' 		=> 	'Put On Hold',
		    'MJ_CA_ACTION_DATE' => 	$reg_date,
		    'MJ_CA_REMARKS'		=>	$cm_Remarks
			);			
			$respose = $this->db->insert('MJ_COMPLAINT_ACTION_DTL', $data);

			if ($respose) {
			$status 	= 'Put On Hold';
			$this->db->set('MJ_CAD_COMPLAINT_STATUS', $status);
			$this->db->set('MJ_CAD_REMARKS', $cm_Remarks);
			$this->db->where('MJ_CAD_CM_NO', $cmno);
			$result = $this->db->update('MJ_COMPLAINT_ASSIGN_DTL');			
			}
			if ($result) {
			$status = 'H'; // P== Pending at Engineer
			$this->db->set('CM_COMPLAINT_STATUS', $status);
			$this->db->where('CM_NO', $cmno);
			$this->db->update('COMPLAINT_MST');			
			}

		}else{		
		$data = array(
		    'MJ_CA_ID' 			=>  $ActionTicketNo,
		    'MJ_CA_CAD_ID' 		=> 	$AssignmentNo,
		    'MJ_CA_CM_NO' 		=> 	$cmno,
		    'MJ_CA_ACTION' 		=> 	'Closed',
		    'MJ_CA_ACTION_DATE' => 	$reg_date,
		    'MJ_CA_REMARKS'		=>	$cm_Remarks
			);			
			$respose = $this->db->insert('MJ_COMPLAINT_ACTION_DTL', $data);

			if ($respose) {
			$status 	= 'Closed';
			$this->db->set('MJ_CAD_COMPLAINT_STATUS', $status);
			$this->db->set('MJ_CAD_REMARKS', $cm_Remarks);
			$this->db->where('MJ_CAD_CM_NO', $cmno);
			$result = $this->db->update('MJ_COMPLAINT_ASSIGN_DTL');			
			}
			if ($result) {
			$status = 'C'; 
			$this->db->set('CM_COMPLAINT_STATUS', $status);
			$this->db->set('CM_COMPLAINT_CLOSE_DATE', $reg_date);
			$this->db->set('CM_COMPLAINT_CLOSED_BY', $UserId);
			$this->db->where('CM_NO', $cmno);
			$this->db->update('COMPLAINT_MST');			
			}
		}
		return $result;
	}
}