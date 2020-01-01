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
		$MJ_User_DOB) {

		$msg = '';
		//Get User Email Id
		if ($MJ_User_Type == 2 ) {
			$query = 'Select EMP_EMAIL_ID, UPPER(EMP_FORENAME || EMP_MIDDLENAME || EMP_SURNAME) AS ENAME, to_char(EMP_DOB,\'dd/mm/yyyy\') AS EMPDOB from emp_mst where emp_id = '."'EMP\\".$MJ_User_ID."'";
			echo $query;
			$result = $this->db->query($query)->row();
			$IsRecordValid = false;
			if($result) {
				if($result->EMP_EMAIL_ID == '')
					$msg = "No Email Id found associted with your profile. Pl. get your email updated in CIT";
				else {
					if ($result->ENAME == strtoupper(str_replace(' ', '', $MJ_User_Name)))	{
						//Chheck if DOB Matches
						if($result->EMPDOB == $MJ_User_DOB) 
							$IsRecordValid = true;
						else
							$msg = "Your date of bith does nat match with our record.";		
					}
					else
						$msg = "Please spell your name as printed on your ID Card";	
				}
			}
		}

		if($IsRecordValid == true) {
			$MJ_UR_ID = $this->get_New_MJUR_User_ID();
			//Generate random string for email account verification
			$str = rand(); 
			$MJ_Verification_string = hash("sha256", $str); 
			
			$data = array(
		        'MJ_UR_ID' 					=>  $MJ_UR_ID,
		        'MJ_UR_USER_TYPE' 			=> 	$MJ_User_Type,
		        'MJ_UR_ID_NO' 				=> 	$MJ_User_ID,
		        'MJ_UR_USER_NAME' 			=> 	$MJ_User_Name,
		        'MJ_UR_DOB' 				=> 	$MJ_User_DOB,
		        'MJ_User_Email'				=>	$result->EMP_EMAIL_ID,
		        'MJ_Verification_string'	=>	$MJ_Verification_string
			);
			
			//$result = $this->db->insert('MJ_USER_REGISTRATION', $data);
			echo "here";
			$this->SendMail($result->EMP_EMAIL_ID, $MJ_Verification_string);
			echo "there";

		}		

		echo "Success".$msg;
		die();
}

	public function get_New_MJUR_User_ID(){

		$this->load->database();
		$this->db->select_max('MJ_UR_ID');
		$query = $this->db->get('MJ_USER_REGISTRATION'); 

		$row = $query->row();

		if (isset($row))
		     return $row->MJ_UR_ID + 1;
	}

	public function SendMail($to, $RandomChallengeText){
		$this->load->library('email');
		$this->email->from('kazim.jmi@gmail.com', 'Additional Director, CIT');
		$this->email->to('sknaqvi@jmi.ac.in');
		$this->email->subject('MyJamia Account Verification Mail.');
		$this->email->message('Dear Sir/Madam,<br>
								With refernce to your request to account creation on MyJamia Portal, please click <br><br> <a href=\'http://localhost:8080/verifyAccount?=\'.$RandomChallengeTextto verify your account. <br><br>CIT, JMI');
		
		echo "Sending....";
		$this->email->send();
		echo "Sent";
		echo $this->email->print_debugger();
	}



}
?>
