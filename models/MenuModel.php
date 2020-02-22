<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuModel extends CI_MODEL {
	

	public function getUserMenu($UserType){
	
		$this->load->database();

		$this->db->select('A.MJ_MENU_TEXT, A.MJ_MENU_URL, A.MJ_MENU_PARENT_ID, A.MJ_MENU_ORDER');
		$this->db->order_by('A.MJ_MENU_PARENT_ID ASC, A.MJ_MENU_ORDER ASC');
		$this->db->from('MJ_MENU_MST A');
		$this->db->where('A.MJ_TAG','K');
		$this->db->where('A.MJ_USER_TYPE',$UserType); //added by raquib
		$this->db->join('MJ_MENU_MST B', 'A.MJ_MENU_PARENT_ID = B.MJ_MENUID AND A.MJ_TAG = B.MJ_TAG' );
		$query = $this->db->get();
		
		if($query->num_rows() > 0) 
			return $query->result();
		else
			return -1;

	}

}
?>