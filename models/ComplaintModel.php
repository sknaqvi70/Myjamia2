<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ComplaintModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}

	public function getComplaintCat($UserType){
    	$response = array();
    	$where="MJ_CSC_NO is NULL";
     	// Select record
		$this->db->order_by('CC_NAME', 'ASC');          			
		$this->db->select('CC_NO, CC_NAME');
		$this->db->join('MJ_USER_COMP_TYPE_AUTH M','M.MJ_CC_NO=C.CC_NO');
		$this->db->from('COMPLAINT_CATEGORY C');
		$this->db->where(['M.MJ_CC_USER_TYPE'=>$UserType]);
		$this->db->where($where);
		$q = $this->db->get();
		$CTList[0] = 'Select Complaint Type';
      	
      	foreach($q->result() as $ComplaintType) 
        	$CTList[$ComplaintType->CC_NO] = $ComplaintType->CC_NAME;     
    	return $CTList;
  	}

  	public function getComplaintSubCat($postData,$UserType){
    	$response = array();
     	// Select record
		$this->db->order_by('CSC_NAME', 'ASC');          			
		$this->db->select('CSC_NO, CSC_CC_NO, CSC_NAME, EMAILID, EMAILCC, RECEIVERID, CSC_FTS_BASED');
		$this->db->join('MJ_USER_COMP_TYPE_AUTH M','M.MJ_CSC_NO=A.CSC_NO');
		$this->db->from('COMPLAINT_SUB_CATEGORY A');
		$this->db->where(['A.CSC_CC_NO'=>$postData]);
		$this->db->where('M.MJ_CC_USER_TYPE',$UserType);
		$q = $this->db->get();				
    	$response = $q->result_array();
    	return $response;
  	}

  	public function RegisterComplaint($dept,$UserId,$CM_COMPLAINT_TYPE,$CM_COMPLAINT_SUB_TYPE,$CM_COMPLAINT_DESC,$CM_USER_LOCATION,$CM_USER_NANE,$CM_USER_MOBILE,$CM_USER_EMAIL,&$VerificationString){
  		//current date of register
  		$reg_date=date('d-m-Y');
  		//Generate random string for email account verification
		$str = rand(); 
		$VerificationString = hash("sha256", $str); 
		

		$CM_NO = $this->get_New_CM_NO();

		$data = array(
		    'CM_NO' 						=>  $CM_NO,
		    'CM_DEP_ID' 					=> 	$dept,
		    'CM_EMP_ID' 					=> 	$UserId,
		    'CM_COMPLAINT_CATEGORY' 		=> 	$CM_COMPLAINT_TYPE,
		    'CM_COMPLAINT_SUB_CATEGORY' 	=> 	$CM_COMPLAINT_SUB_TYPE,
		    'CM_COMPLAINT_TEXT'				=>	$CM_COMPLAINT_DESC,
		    'CM_COMPLAINT_LOCATION' 		=>	$CM_USER_LOCATION,
		    'CM_COMPLAINT_CONTACT_PERSON' 	=> 	$CM_USER_NANE,
		    'CM_COMPLAINT_CONTACT_MOBILE' 	=> 	$CM_USER_MOBILE,
		    'CM_COMPLAINT_CONTACT_EMAIL' 	=> 	$CM_USER_EMAIL,
		    'CM_COMPLAINT_FTS_NO' 			=> 	'',
		    'CM_COMPLAINT_STATUS'			=>	'R',
		    'VERIFICATIONSTRING' 			=>	$VerificationString,
		    'CM_COMPLAINT_DATE'				=>	$reg_date
			);
			
			$result = $this->db->insert('COMPLAINT_MST', $data);
			
		return $result;
  	}

  	//This function Finds New COMPLAINT Id from COMPLAINT_MST table
	public function get_New_CM_NO(){

		$this->load->database();
		$this->db->select_max('CM_NO');
		$query = $this->db->get('COMPLAINT_MST'); 

		$row = $query->row();

		if (isset($row))
		     return $row->CM_NO + 1;
	}
}
?>