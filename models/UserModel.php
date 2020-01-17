<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_MODEL {
	
	public function GetUserTypeList(){
	
		$this->load->database();

		$this->db->select('MJ_USER_TYPE_ID, MJ_USER_TYPE_NAME');
		$this->db->order_by('MJ_USER_TYPE_NAME','ASC');
		$query = $this->db->get('MJ_USER_TYPE');

		$UTList[0] = 'Select User Type';
      	
      	foreach($query->result() as $UserType) 
        	$UTList[$UserType->MJ_USER_TYPE_ID] = $UserType->MJ_USER_TYPE_NAME; 
    
    	return $UTList;
	}

	public function RegisterUser($MJ_User_Type, $MJ_User_ID, $MJ_User_Name,     
		$MJ_User_DOB, &$UserEMail, &$VerificationString) {

		//Validate record to Check if Employee exists, DOB and Name Spell matches with master record
		//And Account has a registered Mail

		$ValidationResult = $this->ValidateRecord($MJ_User_Type, $MJ_User_ID, $MJ_User_Name,     
		$MJ_User_DOB, $UserEMail);

		//Generate random string for email account verification
		$str = rand(); 
		$VerificationString = hash("sha256", $str); 
		$str = rand();
		$VerificationString .= hash("sha256", $str);

		if($ValidationResult == 'OK') {
			$MJ_UR_ID = $this->get_New_MJUR_User_ID();

			$data = array(
		        'MJ_UR_ID' 					=>  $MJ_UR_ID,
		        'MJ_UR_USER_TYPE' 			=> 	$MJ_User_Type,
		        'MJ_UR_ID_NO' 				=> 	$MJ_User_ID,
		        'MJ_UR_USER_NAME' 			=> 	$MJ_User_Name,
		        'MJ_UR_DOB' 				=> 	$MJ_User_DOB,
		        'MJ_USER_EMAIL'				=>	$UserEMail,
		        'MJ_VERIFICATION_STRING' 	=>	$VerificationString

			);
			
			$result = $this->db->insert('MJ_USER_REGISTRATION', $data);
			
		}	
		return $ValidationResult;
	}

	//This function Add User to MJ_User_Mst
	public function AddUser($UID, $Password){

		//Find User Type
		$this->load->database();
		
		$this->db->select('MJ_USERID');
		$this->db->where('MJ_USER_LOGIN',$UID);
		$this->db->where('MJ_USER_ACCOUNT_STATUS','');

		$query = $this->db->get('MJ_USER_MST');
		if(!($query->result() == null || $query->result()->num_rows() == 0))
		{	
			$this->db->select('MJ_UR_USER_TYPE, MJ_USER_EMAIL');
			$this->db->where('MJ_UR_ID_NO',$UID);
			//
			//AND CHECK THAT NO RECORD EXISTS IN MJ_USER_ACCOUNT_STATUS WITH STATUS AS A
			$query = $this->db->get('MJ_USER_REGISTRATION');

			if($query->num_rows() == 1) {
				$data = array(
					'MJ_USERID'					=> 	$this->getNewUserId(),	
		 			'MJ_USER_TYPE'				=>	$query->row()->MJ_UR_USER_TYPE,		
		 			'MJ_USER_LOGIN'				=>	$UID,
					'MJ_USER_PASSWORD'			=>	$Password,
					'MJ_ID_NO'					=>	$UID,
					'MJ_REG_EMAIL'				=>	$query->row()->MJ_USER_EMAIL,
					//'MJ_USER_REG_DATE'	
					//'MJ_USER_EXPIRY_DATE'
					'MJ_USER_ACCOUNT_STATUS'	=>	'A' //Active
					);
				$this->db->insert('MJ_USER_MST', $data);
				return 'OK';
			}
			else
				return 'Failed';
		}
		return 'Duplicate';
	}
	
	//This function validates the Registration Informaion provided by the User. The following Checks //are applied:
	//	1.	There exists an email Id attached to the User Account
	//	2.	Date of Birth of the employee with given id matches with the User DOB
	//	3.	Spelling of name matches after trimming spaces

	function ValidateRecord($MJ_User_Type, $MJ_User_ID, $MJ_User_Name,     
		$MJ_User_DOB, &$User_EMail)  {
		
		$msg = 'OK';
		//Get User Email Id
		if ($MJ_User_Type == 2 ) {
			$query = 'Select EMP_EMAIL_ID, UPPER(EMP_FORENAME || EMP_MIDDLENAME || EMP_SURNAME) AS ENAME, to_char(EMP_DOB,\'dd/mm/yyyy\') AS EMPDOB from emp_mst where emp_id = '."'EMP\\".$MJ_User_ID."'";
			
			$result = $this->db->query($query)->row();
			
			//Check, if employee record exists
			if($result) {
				$User_EMail = $result->EMP_EMAIL_ID;
				if($User_EMail == '')
					$msg = "No Email Id found associted with your profile. Pl. get your email updated in CIT";
				else {
					if (strtoupper(str_replace(' ', '', $result->ENAME ))== strtoupper(str_replace(' ', '', $MJ_User_Name)))	{
						//Chhck if DOB Matches
						if($result->EMPDOB != $MJ_User_DOB) 
							$msg = "Your date of birth does nat match with our record.";		
					}
					else
						$msg = "Please spell your name as printed on your ID Card";	
				}
			}
			else
				$msg = "No employee exists with given Employee Id";
		}
		return $msg;
	}

	//This function Finds New User Id from MJ_User_Registration table
	public function get_New_MJUR_User_ID(){

		$this->load->database();
		$this->db->select_max('MJ_UR_ID');
		$query = $this->db->get('MJ_USER_REGISTRATION'); 

		$row = $query->row();

		if (isset($row))
		     return $row->MJ_UR_ID + 1;
	}

	//Get User Profile. The function fetches UserName, UserType from 
	//the database. 
	public function getUserType($UserId) {

		$this->db->select('MJ_USER_TYPE');
		$this->db->from('MJ_USER_MST');
		$this->db->where('MJ_USER_LOGIN',$UserId);
		
		$query = $this->db->get();

		if($query->num_rows() > 0) 
				return $query->row()->MJ_USER_TYPE;
			else
				return '-1'; //Error	
	}

	//This function fectches User (Student Type) Name added by Raquib
	public function getStuName($UserId) {

		$this->db->select('STU_FNAME, STU_MNAME, STU_LNAME');
		$this->db->from('STU_MST');
		$this->db->where('STU_ID',$UserId);
		 
		$query = $this->db->get();

		if($query->num_rows() > 0) 
				return 	$query->row()->STU_FNAME . ' ' .
						$query->row()->STU_MNAME . ' ' .
						$query->row()->STU_LNAME;
			else
				return '-1'; //Error	
	} 
	//This function fectches User (EMployee Type) Name
	public function getEmpName($UserId) {

		$this->db->select('EMP_FORENAME, EMP_MIDDLENAME, EMP_SURNAME ');
		$this->db->from('EMP_MST');
		$this->db->where('EMP_ID',$UserId);
		 
		$query = $this->db->get();

		if($query->num_rows() > 0) 
				return 	$query->row()->EMP_FORENAME . ' ' .
						$query->row()->EMP_MIDDLENAME . ' ' .
						$query->row()->EMP_SURNAME;
			else
				return '-1'; //Error	
	} 
	//This function Finds New User Id from MJ_User_Mst table
	public function getNewUserId(){

		$this->load->database();
		$this->db->select_max('MJ_USERID');
		$query = $this->db->get('MJ_USER_MST'); 

		$row = $query->row();

		if (isset($row))
		     return $row->MJ_USERID + 1;
	}

	//This function verifies if the link sent to the user has been generated by his/her email account
	public function VerifyEMailAccount($UID, $RTest) {

		$this->load->database();

		$this->db->select('MJ_ACCOUNT_STATUS');
		$this->db->where('MJ_UR_ID_NO',$UID);
		$this->db->where('MJ_VERIFICATION_STRING',$RTest);

		$query = $this->db->get('MJ_USER_REGISTRATION');

		if($query->num_rows() > 0) {
			// Return verified if Account Status is blank i.e. Account has not been created;
			if ($query->row()->MJ_ACCOUNT_STATUS == '')
				return 1;
			// Return -1 indicating that Account has already been created.
			else
				return -1;
		}
			
		else
			return 0;
	}

	//This function checks, if User is authrised to use the system
	public function isUserAuthorised($UserName, $Password) {
		$this->load->database();

		$this->db->select('MJ_USER_ACCOUNT_STATUS');
		$this->db->where('MJ_USER_LOGIN',$UserName);
		$this->db->where('MJ_USER_PASSWORD',$Password);

		$query = $this->db->get('MJ_USER_MST');

		if($query->num_rows() > 0) {
			if ($query->row()->MJ_USER_ACCOUNT_STATUS == 'A') //A->Active
				return 'OK'; //Active
			else
				return 'E'; //Expired
		}
		else
				return 'DNE'; //Does not exists
	}

	//This function Updates User Password
	public function updatePassword($UID, $Password){

		//Find User Type
		$this->load->database();
		
		$this->db->set('MJ_USER_PASSWORD', $Password);
		$this->db->where('MJ_USER_LOGIN', $UID);
		$this->db->update('MJ_USER_MST');

		//return $this->db->last_query();
	}
	// this function is used for fetch ssmid , dep id frm database
	public function getStuData($UserId){	          			
		$this->db->select('A.STU_SES_ID,A.STU_SSM_ID,A.STU_DEPT');
		$this->db->from('STU_MST A');
		$this->db->join('MJ_USER_MST B', 'B.MJ_ID_NO=A.STU_ID');
		$this->db->join('DEP_MST C', 'A.STU_DEPT= C.DEP_ID ');
		$this->db->where('MJ_USER_ACCOUNT_STATUS','A');
		$this->db->where(['A.STU_ID'=>$UserId]);
		$this->db->where('STU_ADMIN_WITHDRAWAL','N');
		$query = $this->db->get();		
		if($query->num_rows() > 0) 
				return $query->result();
			else
				return '-1'; //Error		
	}
}
?>
