<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class AddProgramModel extends CI_Model {
	/**
	 * Some Short Form used for Status of complaint in this Model.
	 *
	 *
	 */
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}

	public function getProgramTypeList(){
		$this->db->select('TP_PROGRAM_SHORT_NAME, TP_PROGRAM_NAME');
		$this->db->from('TP_PROGRAM_MST');
		$this->db->order_by('TP_PROGRAM_NAME', 'ASC');
		$query = $this->db->get();

		$PList[0] = 'Select Program';      	
      	foreach($query->result() as $Type) 
        	$PList[$Type->TP_PROGRAM_SHORT_NAME] = $Type->TP_PROGRAM_NAME;     
    	return $PList;
	}

	public function getDepartmentList(){
		$this->db->select('DEP_ID, DEP_DESC');
		$this->db->from('ALL_DEP_MST');
		$query = $this->db->get();

		$DList[0] = 'Select Department';      	
      	foreach($query->result() as $Dept) 
        	$DList[$Dept->DEP_ID] = $Dept->DEP_DESC;     
    	return $DList;
	}

	public function RegisterProgram($programShortName,$programDESC,$programMode,$programDuration,$programStartDate,$programStartTime,$programEndDate,$programEndTime,$programFee,$MJ_User_ID,$programOrganizingDept,$programOrganizerName,$organizerEMail,$programOrganizerMobileNo,&$TpdProgramKey){

		$ValidationResult = $this->ValidateRecord($MJ_User_ID,$programShortName, $programDESC);

		if($ValidationResult == 'OK') {
			$programId = $this->getProgramId($programShortName);
			$TpdId	= $this->getNewTpdId();
			$TpdProgramKey	= $this->getNewTpdProgramKey($programShortName);		

			$data = array(
			    'TP_TPD_ID' 			=>  $TpdId,
			    'TP_TPD_PID' 			=> 	$programId,
			    'TP_TPD_PROGRAM_KEY' 	=> 	$TpdProgramKey,
			    'TP_TPD_PROGRAM_DESC' 	=> 	$programDESC,
			    'TP_TPD_MODE'			=>	$programMode,
			    'TP_TPD_DURATION'		=>	$programDuration,
			    'TP_TPD_PROGRAM_FEE'	=>	$programFee,
			    'TP_TPD_START_DATE'		=>	$programStartDate,
			    'TP_TPD_START_TIME'		=>	$programStartTime,
			    'TP_TPD_END_DATE'		=>	$programEndDate,
			    'TP_TPD_END_TIME'		=>	$programEndTime,
			    'TP_TPD_ADDED_BY' 		=>	$MJ_User_ID,
			    'TP_TPD_STATUS'			=>	'A'
				);			
				$result = $this->db->insert('TP_PROGRAM_DTL', $data);

			if ($result) {
				$data = array(
			    'TPOD_DEP_ID' 				=>  $programOrganizingDept,
			    'TPOD_PID' 					=> 	$programId,
			    'TPOD_TPD_ID' 				=> 	$TpdId,
			    'TPOD_ORGANIZER_NAME' 		=> 	$programOrganizerName,
			    'TPOD_ORGANIZER_EMAIL_ID'	=>	$organizerEMail,
			    'TPOD_ORGANIZER_MOBILE_NO'	=>	$programOrganizerMobileNo
				);			
				$result = $this->db->insert('TP_ORGANIZING_DEPT', $data);
			}
			return $result;
		}		
	}

	public function ValidateRecord($MJ_User_ID,$programName, $programDESC){
		$msg = 'OK';
		
		return $msg;
	}

	public function getProgramId($programShortName){

		$this->db->select_max('TP_PROGRAM_ID');
		$this->db->where('TP_PROGRAM_SHORT_NAME',$programShortName);
		$query = $this->db->get('TP_PROGRAM_MST'); 
		$row = $query->row();

		if (isset($row))
		     return $row->TP_PROGRAM_ID;
	}

	//This function Finds new program registration No from table
	public function getNewTpdId(){
		$select	=	date('Y')."||lpad(TP_TPD_ID_SEQ.NEXTVAL, 3, '0') TP_TPD_ID";
		$this->db->select($select);
		$this->db->from('DUAL');
		$query = $this->db->get();

		if($query->num_rows() > 0) 
				return $query->row()->TP_TPD_ID;
			else
				return 'null'; //Error
	}

	//This function Finds new program registration key from table
	public function getNewTpdProgramKey($programShortName){
		$shortNameAndYear = $programShortName.''.date('y');
		$select	=	"'$shortNameAndYear'"."||lpad(TP_APP_REG_KEY_SEQ.NEXTVAL, 3, '0') TPD_PROGRAM_KEY";
		$this->db->select($select);
		$this->db->from('DUAL');
		$query = $this->db->get();

		if($query->num_rows() > 0) 
				return $query->row()->TPD_PROGRAM_KEY;
			else
				return 'null'; //Error
	}
}