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
}
?>
