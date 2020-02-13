<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class AdminModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}

	public function getYear(){
		$cyear="TO_CHAR(CM_COMPLAINT_DATE, 'YYYY')";
		$this->db->select(''.$cyear.' YEAR');
		$this->db->from('COMPLAINT_MST');
		$this->db->group_by($cyear);
		$this->db->order_by(''.$cyear.'');
		return $this->db->get();			
	}

	public function getOpenComplaint(){
		$where = "CM_COMPLAINT_STATUS IN ('R','O')";
		$this->db->order_by('CM_COMPLAINT_DATE', 'ASC');
        $this->db->select('count(*) OPEN_COMPLAINT');
		$this->db->from('COMPLAINT_MST');
		$this->db->where('CM_COMPLAINT_CATEGORY',1);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->OPEN_COMPLAINT;
			else
				return '0'; //Error	
	}

	public function getHoldComplaint(){
		$where = "CM_COMPLAINT_STATUS IN ('P')";
		$this->db->order_by('CM_COMPLAINT_DATE', 'ASC');
        $this->db->select('count(*) PENDING_COMPLAINT');
		$this->db->from('COMPLAINT_MST');
		$this->db->where('CM_COMPLAINT_CATEGORY',1);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->PENDING_COMPLAINT;
			else
				return '0'; //Error	
	}

	public function getClosedComplaint(){
		$where = "CM_COMPLAINT_STATUS IN ('C')";
		$this->db->order_by('CM_COMPLAINT_DATE', 'ASC');
        $this->db->select('count(*) CLOSED_COMPLAINT');
		$this->db->from('COMPLAINT_MST');
		$this->db->where('CM_COMPLAINT_CATEGORY',1);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->CLOSED_COMPLAINT;
			else
				return '0'; //Error	
	}

	public function getTotalComplaint(){
		$this->db->order_by('CM_COMPLAINT_DATE', 'ASC');
        $this->db->select('count(*) TOTAL_COMPLAINT');
		$this->db->from('COMPLAINT_MST');
		$this->db->where('CM_COMPLAINT_CATEGORY',1);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->TOTAL_COMPLAINT;
			else
				return '0'; //Error	
	}

	/*public function fetch_total_comp($cyear){
		$query = $this->db->query("SELECT TO_CHAR(CM_COMPLAINT_DATE, 'MM') MONTHS,COUNT(*) COMPLAINTS FROM COMPLAINT_MST WHERE CM_COMPLAINT_CATEGORY=1 AND TO_CHAR(CM_COMPLAINT_DATE, 'YYYY') = '".$cyear."' GROUP BY TO_CHAR(CM_COMPLAINT_DATE, 'MM') ORDER BY TO_CHAR(CM_COMPLAINT_DATE, 'MM')");
		return $query;
	}*/
	
	
	public function getOpenComplaints(){ 
		$where = "CM_COMPLAINT_STATUS IN ('R','O')";         			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,					A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',1);
		$this->db->where($where);
		$this->db->order_by('CM_NO', 'DESC');
		$query = $this->db->get();		
		return $query->result();			
	}

	public function getPendingComplaints(){          			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,					A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',1);
		$this->db->where('A.CM_COMPLAINT_STATUS','P');
		$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query = $this->db->get();		
		return $query->result();			
	}

	public function getClosedComplaints(){          			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,					A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',1);
		$this->db->where('A.CM_COMPLAINT_STATUS','C');
		$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query = $this->db->get();		
		return $query->result();			
	}

	public function getTotalNoComplaints(){	          			
		$this->db->select('A.CM_NO, DEP_DESC, EMP_NAME(A.CM_EMP_ID) NAME,CSC_NAME, A.CM_COMPLAINT_TEXT,					A.CM_COMPLAINT_LOCATION,A.CM_COMPLAINT_CONTACT_PERSON,A.CM_COMPLAINT_CONTACT_MOBILE, 				A.CM_COMPLAINT_CONTACT_EMAIL');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',1);
		$this->db->order_by('CM_COMPLAINT_DATE', 'DESC');
		$query = $this->db->get();		
		return $query->result();			
	}

	public function getSingleComplaintDetails($cmData){	
	//for Employee 
		$where = "CM_EMP_ID IS NOT NULL";         			
		$this->db->select('CM_NO, "DEP_DESC", EMP_NAME(A.CM_EMP_ID) NAME,"CSC_NAME", CM_COMPLAINT_TEXT, CM_COMPLAINT_LOCATION, CM_COMPLAINT_CONTACT_PERSON,CM_COMPLAINT_CONTACT_MOBILE, CM_COMPLAINT_CONTACT_EMAIL, CM_COMPLAINT_FTS_NO, CM_COMPLAINT_STATUS,CM_COMPLAINT_DATE');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',1);
		$this->db->where('A.CM_NO',$cmData);
		$this->db->where($where);
		$query1 = $this->db->get_compiled_select();	

		//for Student 
		$where = "CM_STU_ID IS NOT NULL";
		$this->db->select('CM_NO, "DEP_DESC", STU_NAME(A.CM_STU_ID) NAME,"CSC_NAME", CM_COMPLAINT_TEXT, CM_COMPLAINT_LOCATION, CM_COMPLAINT_CONTACT_PERSON,CM_COMPLAINT_CONTACT_MOBILE, CM_COMPLAINT_CONTACT_EMAIL, CM_COMPLAINT_FTS_NO, CM_COMPLAINT_STATUS,CM_COMPLAINT_DATE');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',1);
		$this->db->where('A.CM_NO',$cmData);
		$this->db->where($where);
		$query2 = $this->db->get_compiled_select();

		//for contrator and profession staff
		$where = "CM_CMM_ID IS NOT NULL";
		$this->db->select('CM_NO, "DEP_DESC", CMM_DESC NAME,"CSC_NAME", CM_COMPLAINT_TEXT, CM_COMPLAINT_LOCATION, CM_COMPLAINT_CONTACT_PERSON,CM_COMPLAINT_CONTACT_MOBILE, CM_COMPLAINT_CONTACT_EMAIL, CM_COMPLAINT_FTS_NO, CM_COMPLAINT_STATUS,CM_COMPLAINT_DATE');
		$this->db->from('COMPLAINT_MST A');
		$this->db->join('COMPLAINT_SUB_CATEGORY B', 'A.CM_COMPLAINT_SUB_CATEGORY=B.CSC_NO');
		$this->db->join('COMPANY_MST C', 'A.CM_CMM_ID = C.CMM_ID');
		$this->db->join('DEP_MST C', 'A.CM_DEP_ID= C.DEP_ID ');		
		$this->db->where('A.CM_COMPLAINT_CATEGORY',1);
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

        $this->db->select('MJ_CHD_USER_ID,CMM_DESC NAME');	
		$this->db->join('COMPANY_MST C','C.CMM_ID=M.MJ_CHD_USER_ID');
		$this->db->where('M.MJ_CHD_CSC_NO',$str);
		$query1 = $this->db->get_compiled_select('MJ_COMPLAINT_HR_DTL M');

       	$this->db->select('MJ_CHD_USER_ID,EMP_NAME(EMP_ID) NAME');	
		$this->db->join('EMP_MST E','E.EMP_ID=M.MJ_CHD_USER_ID');
		$this->db->where('M.MJ_CHD_CSC_NO',$str);
		$query2 = $this->db->get_compiled_select('MJ_COMPLAINT_HR_DTL M');
		//making union both fee
		$data = $this->db->query($query1 . ' UNION ' . $query2);
		$EMPList[0] = 'Select User';
      	
      	foreach($data->result() as $User) 
        	$EMPList[$User->MJ_CHD_USER_ID] = $User->NAME; 
    
    	return $EMPList;   	

	}

}