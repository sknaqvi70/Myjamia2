<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class EmployeeModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}
	//this function used for to view profile information
	public function emp_info($UserId){	          			
		$this->db->select('EMP_ID, EMP_TITLE,EMP_NAME(EMP_ID) NAME, EMP_DOB,EMP_RET_DATE, EMP_GENDER, EMP_SPOUSE, EMP_FATHER,EMP_MOTHER,DEP_DESC ,OFA_DESC,desig(EMP_ID) EMP_DESIGNATION, A.EMP_PERMANENT_ADD.MAIL EMAIL,A.EMP_PERMANENT_ADD.ADDRLINE1 P_ADD1,A.EMP_PERMANENT_ADD.ADDRLINE2 P_ADD2,A.EMP_PERMANENT_ADD.DISTRICT P_CITY, E.GEM_DESC P_STATE,A.EMP_PERMANENT_ADD.PIN P_PINCODE,A.EMP_PERMANENT_ADD.RES_PHNO P_MOBILE,A.EMP_TEMPORARY_ADD.ADDRLINE1 C_ADD1,A.EMP_TEMPORARY_ADD.ADDRLINE2 C_ADD2, A.EMP_TEMPORARY_ADD.DISTRICT C_CITY,F.GEM_DESC C_STATE,   A.EMP_TEMPORARY_ADD.PIN C_PINCODE, A.EMP_TEMPORARY_ADD.RES_PHNO C_MOBILE,EMP_NATIONALITY,EMP_EMAIL_ID');
		$this->db->from('EMP_MST A');
		$this->db->join('DEP_MST C', 'A.EMP_DEPARTMENT= C.DEP_ID ');
		$this->db->join('OFF_FAC_MST D', 'C.DEP_OFA_ID=D.OFA_ID ');		
		$this->db->join('GEN_MST E', 'A.EMP_PERMANENT_ADD.STATE=E.GEM_ID');
		$this->db->join('GEN_MST F', 'A.EMP_TEMPORARY_ADD.STATE=F.GEM_ID');
		$this->db->where(['A.EMP_ID'=>'EMP\\'.$UserId]);
		$this->db->where('EMP_STATUS','C');
		$query = $this->db->get();
		return $query->result();			
	}
}