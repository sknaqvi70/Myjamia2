<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ComplaintModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}
	//this function is use to fetch complaint category
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
  	//this function is use to fetch complaint sub category
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

  	//this function is to insert complaint into complaint_mst table and when check_fts_based is N then it also inserted complaint into FILE_MST and FILE_MV_DTL table
  	public function RegisterComplaint($dept,$UserId,$CM_COMPLAINT_TYPE,$CM_COMPLAINT_SUB_TYPE,$CM_COMPLAINT_DESC,$CM_USER_LOCATION,$CM_USER_NANE,$CM_USER_MOBILE,$CM_USER_EMAIL,&$VerificationString,&$TicketNo,&$FtsNo){
  		//current date of register
  		$reg_date=date('d-m-Y');
  		//Generate random string for email account verification
		$str = rand(); 
		$VerificationString = hash("sha256", $str); 	

		$TicketNo = $this->get_New_CM_NO();

		$check_fts_based = $this->check_fts_status($CM_COMPLAINT_SUB_TYPE);

		if($check_fts_based == 'N'){ //this function is to insert complaint without FTS number
			if (strlen($UserId) == 10) { //checking user
			$data = array(
		    	'CM_NO' 						=>  $TicketNo,
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
		    	'CM_COMPLAINT_DATE'				=>	$reg_date,
		    	'CM_STU_ID'						=>	'',
		    	'CM_CMM_ID'						=>	''
			);
			
			$result = $this->db->insert('COMPLAINT_MST', $data);

			}elseif (strlen($UserId) == 6) {
			$data = array(
		    	'CM_NO' 						=>  $TicketNo,
		    	'CM_DEP_ID' 					=> 	$dept,
		    	'CM_EMP_ID' 					=> 	'',
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
		    	'CM_COMPLAINT_DATE'				=>	$reg_date,
		    	'CM_STU_ID'						=>	'',
		    	'CM_CMM_ID'						=>	$UserId
			);
			
			$result = $this->db->insert('COMPLAINT_MST', $data);
			}else
			$data = array(
		    	'CM_NO' 						=>  $TicketNo,
		    	'CM_DEP_ID' 					=> 	$dept,
		    	'CM_EMP_ID' 					=> 	'',
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
		    	'CM_COMPLAINT_DATE'				=>	$reg_date,
		    	'CM_STU_ID'						=>	$UserId,
		    	'CM_CMM_ID'						=>	''
			);
			
			$result = $this->db->insert('COMPLAINT_MST', $data);
			
		return $result;
		}
		else  //this condition for to insert complaint with FTS number
		{
		$FtsNo = $this->get_New_FTS_No($CM_COMPLAINT_SUB_TYPE);

		$CM_COMPLAINT_TYPE_DESC= $this->fetch_complaint_type_desc($CM_COMPLAINT_TYPE);

		$CM_COMPLAINT_SUB_TYPE_DESC= $this->fetch_complaint_sub_type_desc($CM_COMPLAINT_SUB_TYPE);

		$data = array(
		    'CM_NO' 						=>  $TicketNo,
		    'CM_DEP_ID' 					=> 	$dept,
		    'CM_EMP_ID' 					=> 	$UserId,
		    'CM_COMPLAINT_CATEGORY' 		=> 	$CM_COMPLAINT_TYPE,
		    'CM_COMPLAINT_SUB_CATEGORY' 	=> 	$CM_COMPLAINT_SUB_TYPE,
		    'CM_COMPLAINT_TEXT'				=>	$CM_COMPLAINT_DESC,
		    'CM_COMPLAINT_LOCATION' 		=>	$CM_USER_LOCATION,
		    'CM_COMPLAINT_CONTACT_PERSON' 	=> 	$CM_USER_NANE,
		    'CM_COMPLAINT_CONTACT_MOBILE' 	=> 	$CM_USER_MOBILE,
		    'CM_COMPLAINT_CONTACT_EMAIL' 	=> 	$CM_USER_EMAIL,
		    'CM_COMPLAINT_FTS_NO' 			=> 	$FtsNo,
		    'CM_COMPLAINT_STATUS'			=>	'R',
		    'VERIFICATIONSTRING' 			=>	$VerificationString,
		    'CM_COMPLAINT_DATE'				=>	$reg_date
			);
			
			$result = $this->db->insert('COMPLAINT_MST', $data);

			if ($CM_COMPLAINT_TYPE == 1) {
        			$FILE_TYPE		= 'FTS016';
        		}else
        		{
        			$FILE_TYPE		= 'FTS023';
        		}

		if ($result) {
		//data insert into file_mst table
			$data_view = array(
        		'FM_FILE_ID' 		=> $FtsNo,
        		'FM_SENDER_ID' 		=> $UserId,
        		'FM_SIGNED_BY'		=> $UserId,
        		'FM_SUBJECT'		=> 'Complaint regarding '.$CM_COMPLAINT_SUB_TYPE_DESC,
        		'FM_DISPATCH_DT'	=> $reg_date,
        		'FM_FILE_TYPE'		=> $FILE_TYPE,
        		'FM_SENDER_DEPT'	=> $dept,
        		'FM_PAGES'			=> '',
        		'FM_REMARKS'		=> $CM_COMPLAINT_DESC.' Location '.$CM_USER_LOCATION.' Contact '
        							   .$CM_USER_NANE.	' Number '.$CM_USER_MOBILE,
        		'FM_SENDER_OTH'		=> '',
        		'FM_EMAIL_ID'		=> $CM_USER_EMAIL
       		);
        	$filemst_result = $this->db->insert('FILE_MST', $data_view);

        	if ($filemst_result) {
        	//data insert into file_mv_dtl table
        		$PBNO= $this->getPBNO($dept);

        		if ($CM_COMPLAINT_TYPE == 1) {
        				$ADDRESSED_TO		= 'Hony. Director, FTK-CIT';
        				$RECD_DEP			= 'ADCIT';
        				$RECV_DT			= $reg_date;
        				$RECEIVER_ID		= 'BCOFTS';
        				$ACTUAL_RECV		= 'BCOFTS';
        			}else
        			{
        				$ADDRESSED_TO		= 'Professor Incharge, B&C';
        				$RECD_DEP			= 'ADBAC';
        				$RECV_DT			= $reg_date;
        				$RECEIVER_ID		= 'BCOFTS';
        				$ACTUAL_RECV		= 'BCOFTS';
        			}
        		
        		$data_view = array(
        			'FMD_FILE_ID' 			=> $FtsNo,
        			'FMD_PB_NO' 			=> $FtsNo.'/'.$dept.'-'.$PBNO,
        			'FMD_SENDER_DEPT'		=> $dept,
        			'FMD_SEND_DT'			=> $reg_date,
        			'FMD_SENDER_ID'			=> $UserId,
        			'FMD_ACTUAL_SEND'		=> $UserId,
        			'FMD_ADDRESSED_TO'		=> $ADDRESSED_TO,
        			'FMD_RECD_DEP'			=> $RECD_DEP,
        			'FMD_RECV_DT'			=> $RECV_DT,
        			'FMD_RECEIVER_ID'		=> $RECEIVER_ID,
        			'FMD_ACTUAL_RECV'		=> $ACTUAL_RECV,
        			'FMD_RECD_PAGES'		=> 0,
        			'FMD_RECD_STATUS'		=> 'Y',
        			'FMD_ACTION_TAKEN'		=> '',
        			'FMD_ACTION_DT'			=> '',
        			'FMD_REC_NO'			=> 1,
        			'FMD_LEVEL_NO'			=> 1,
        			'FMD_FWD_NO'			=> '',
        			'FMD_LEVEL_REC'			=> '',
        			'FMD_REMARKS'			=> '',
        			'FMD_ADDRESSED_TO_1'	=> '',
        			'FMD_PRINT_STATUS'		=> 'N'
       			);
        		return $this->db->insert('FILE_MV_DTL', $data_view);
        	}
        	return $filemst_result;
   		}
   		return $result;
		}
  	}

  	//This function Finds New COMPLAINT Id from COMPLAINT_MST table
	public function get_New_CM_NO(){

		$this->db->select_max('CM_NO');
		$query = $this->db->get('COMPLAINT_MST'); 

		$row = $query->row();

		if (isset($row))
		     return $row->CM_NO + 1;
	}

	//This function Finds Status of FTS_BASED  from COMPLAINT_SUB_CATEGORY table
	public function check_fts_status($CM_COMPLAINT_SUB_TYPE){
		$this->db->select('CSC_FTS_BASED');
		$this->db->where('CSC_NO',$CM_COMPLAINT_SUB_TYPE);
		$query = $this->db->get('COMPLAINT_SUB_CATEGORY');
  		$row = $query->row();
		if (isset($row))
		     return $row->CSC_FTS_BASED;
	}

	//This function Finds New FTS Number from FILE_MST table
	public function get_New_FTS_No(){

		$this->db->select_max('FM_FILE_ID');
		$query = $this->db->get('FILE_MST');
		$row = $query->row();

		if (isset($row))
		     return $row->FM_FILE_ID + 1;
	}

	// This function find complaint type desc from complaint_category table
	public function fetch_complaint_type_desc($CM_COMPLAINT_TYPE){
		$this->db->select('CC_NAME');
		$this->db->where('CC_NO',$CM_COMPLAINT_TYPE);
		$query = $this->db->get('COMPLAINT_CATEGORY');
  		$row = $query->row();
		if (isset($row))
		     return $row->CC_NAME;
	}

	// This function find complaint sub type desc from complaint_category table
	public function fetch_complaint_sub_type_desc($CM_COMPLAINT_SUB_TYPE){
		$this->db->select('CSC_NAME');
		$this->db->where('CSC_NO',$CM_COMPLAINT_SUB_TYPE);
		$query = $this->db->get('COMPLAINT_SUB_CATEGORY');
  		$row = $query->row();
		if (isset($row))
		     return $row->CSC_NAME;
	}

	// This function find departmental email id for from email id
	public function fetch_cc_email_id($CM_COMPLAINT_TYPE){
		$this->db->distinct('DEP_EMAIL');
		$this->db->select('DEP_EMAIL');
		$this->db->join('MJ_USER_COMP_TYPE_AUTH M','M.MJ_UCTA_DEPID=A.DEP_ID');
		$this->db->where('M.MJ_CC_NO',$CM_COMPLAINT_TYPE);
		$query = $this->db->get('ALL_DEP_MST A');
  		$row = $query->row();
		if (isset($row))
		     return $row->DEP_EMAIL;
	}

	// This function find complaint sub type desc from complaint_category table
	public function fetch_from_email_id($CM_COMPLAINT_SUB_TYPE){
		$this->db->select('EMAILCC');
		$this->db->where('CSC_NO',$CM_COMPLAINT_SUB_TYPE);
		$query = $this->db->get('COMPLAINT_SUB_CATEGORY');
  		$row = $query->row();
		if (isset($row))
		     return $row->EMAILCC;
	}


	// this function fine PBNo from table file_mv_dtl
	public function getPBNO($dept){	

		$response=$this->db->query("SELECT max(to_number(substr(FMD_PB_NO, instr(FMD_PB_NO,'-')+1))) PBNO 
					FROM FILE_MV_DTL
					WHERE FMD_SENDER_DEPT = '$dept'
					")->row(); 

        if (isset($response))
		return $response->PBNO;    
	}
}
?>