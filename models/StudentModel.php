<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class StudentModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}
	//this function used for to view profile information
	public function stu_info($UserId){	          			
		$this->db->select('A.STU_ID,STU_NAME(A.STU_ID) NAME,A.STU_FATHER_NAME,A.STU_MOTHER_NAME,A.STU_HUSBAND_NAME,A.STU_SEX,A.STU_SES_ID,A.STU_BLOOD_GR,A.STU_DOB,A.STU_DOA,A.STU_COMMU_ADDR.MAIL EMAIL,A.STU_PER_ADDR.ADDRLINE1 P_ADD1,A.STU_PER_ADDR.ADDRLINE2 P_ADD2,A.STU_PER_ADDR.DISTRICT P_CITY,E.GEM_DESC P_STATE,A.STU_PER_ADDR.PIN P_PINCODE,A.STU_PER_ADDR.RES_PHNO P_MOBILE,A.STU_COMMU_ADDR.ADDRLINE1 C_ADD1,A.STU_COMMU_ADDR.ADDRLINE2 C_ADD2,A.STU_COMMU_ADDR.DISTRICT C_CITY,F.GEM_DESC C_STATE,A.STU_COMMU_ADDR.PIN C_PINCODE,A.STU_COMMU_ADDR.RES_PHNO C_MOBILE,ltrim(rtrim(a.stu_nationality)) STU_NATIONALITY,course_name(A.STU_SSM_ID) COURSE,SUBSTR(A.STU_SSM_ID,1,8) SSM_ID,A.STU_SSM_ID ,C.DEP_DESC,A.STU_DEPT,D.OFA_DESC');
		$this->db->from('STU_MST A');
		$this->db->join('MJ_USER_MST B', 'B.MJ_ID_NO=A.STU_ID');
		$this->db->join('DEP_MST C', 'A.STU_DEPT= C.DEP_ID ');
		$this->db->join('OFF_FAC_MST D', 'C.DEP_OFA_ID=D.OFA_ID ');
		$this->db->join('GEN_MST E', 'A.STU_PER_ADDR.STATE=E.GEM_ID');
		$this->db->join('GEN_MST F', 'A.STU_COMMU_ADDR.STATE=F.GEM_ID');
		$this->db->where('MJ_USER_ACCOUNT_STATUS','A');
		$this->db->where(['A.STU_ID'=>$UserId]);
		$this->db->where('STU_ADMIN_WITHDRAWAL','N');
		$query = $this->db->get();		
		return $query->result();			
	}
	//this function for fetch details of fee paid to download fee receipts
	public function getFeeReceipt($UserId)	{
		$this->db->select('course_name(SFD_SSM_ID) COURSE,SFD_RECP_NO, SFD_CHQ_NO,SFD_BANK,SFD_CHQ_AMT,SFD_CHQ_DT,SFD_LAST_FEE_SUB_DATE LAST_DT,SFD_PAY_MODE');	
		$this->db->join('RE_RGN_DTL R','R.RRD_RECEIPT_NO=A.SFD_RECP_NO');
		$this->db->where(['RRD_STU_ID'=>$UserId]);
		$query = $this->db->get('STU_FEE_DTL A');
		return $query->result();
	}

	//this function used for fetch sigle fee details to view and print
	public function fetch_single_fee_details($SFD_FRECP_NO,$UserId){	
		//counter fee details		
		$where = "SFD_PAY_MODE is  NOT NULL";
		$this->db->select('course_name(SFD_SSM_ID) COURSE,SFD_RECP_NO,RRD_STU_ID,STU_NAME(RRD_STU_ID) SNAME,STU_FATHER_NAME,SFD_CHQ_NO CHQ_NO,SFD_BANK BANK_NAME,SFD_CHQ_AMT,SFD_CHQ_DT,SFD_LAST_FEE_SUB_DATE LAST_DT,SFD_PAY_MODE BANK_PAY_MODE,SFD_PAY_DONE');
		$this->db->join('RE_RGN_DTL R','R.RRD_RECEIPT_NO=A.SFD_RECP_NO');	
		$this->db->join('STU_MST S','S.STU_ID=R.RRD_STU_ID');		
		$this->db->where(['R.RRD_STU_ID'=>$UserId]);
		$this->db->where('SFD_RECP_NO',$SFD_FRECP_NO);
		$this->db->where($where);
		$query1 = $this->db->get_compiled_select('STU_FEE_DTL A');
		//online fee details
		$PAY_MODE='Online';
		$this->db->select('course_name(SFD_SSM_ID) COURSE,SFD_RECP_NO,RRD_STU_ID,STU_NAME(RRD_STU_ID) SNAME,STU_FATHER_NAME,BANK_REF_NO CHQ_NO,BANK BANK_NAME,SFD_CHQ_AMT,SFD_CHQ_DT,SFD_LAST_FEE_SUB_DATE LAST_DT,'."'$PAY_MODE'".' BANK_PAY_MODE,SFD_PAY_DONE');	
		$this->db->join('RE_RGN_DTL R','R.RRD_RECEIPT_NO=A.SFD_RECP_NO');	
		$this->db->join('STU_MST S','S.STU_ID=R.RRD_STU_ID');	
		$this->db->join('BANKLOG B','SUBSTR(B.RECEIPT_NO,1,10)=A.SFD_RECP_NO');	
		$this->db->where(['R.RRD_STU_ID'=>$UserId]);
		$this->db->where('SFD_RECP_NO',$SFD_FRECP_NO);
		$this->db->where('B.TRANSACTION_STATUS','Success');
		$query2 = $this->db->get_compiled_select('STU_FEE_DTL A');
		//making union both fee
		$data = $this->db->query($query1 . ' UNION ' . $query2);
		$output = '<table class="table table-striped table-bordered table-hover " width="550" align="center" style="font-size:14px; font-family:Calibri; border-radius: 10px;
  			border: 1px solid;">';
		 	foreach($data->result() as $v_spdtl){
		 	$output .='<tbody>
		 		  <tr>
                    <td valign="top" height="20" align="left"><strong>&nbsp;&nbsp;Receipt/AC No: </strong></td>
                    <td valign="top" align="left">'.$v_spdtl->SFD_RECP_NO.'</td>
                    <td valign="top" align="left"><strong>&nbsp;Student ID No.: </strong></td>
                    <td valign="top" align="left">'.$v_spdtl->RRD_STU_ID.'</td>
                  </tr>
                 
                  <tr>
                    <td valign="top" height="20" align="left"><strong>&nbsp;&nbsp;Student Name: </strong></td>
                    <td valign="top" align="left">'.$v_spdtl->SNAME.'</td>
                    <td valign="top" align="left"><strong>&nbsp;Fathers Name </strong></td>
                    <td valign="top" align="left">'.ucwords(strtolower("$v_spdtl->STU_FATHER_NAME")).'</td>
                  </tr>

                  <tr>
                    <td valign="top" height="20" align="left" ><strong>&nbsp;&nbsp;Program Name: </strong></td>
                    <td valign="top" align="left" colspan="3">'.$v_spdtl->COURSE.'</td>
                  </tr>

                  <tr>
                    <td valign="top" height="20" align="left"><strong>&nbsp;&nbsp;Fee Amount: </strong></td>
                    <td valign="top" align="left">'.$v_spdtl->SFD_CHQ_AMT. "/-".'</td>
                    <td valign="top" align="left"><strong>Bank Posting Date:</strong></td>
                    <td valign="top" align="left">'.$v_spdtl->SFD_CHQ_DT.'</td>
                  </tr>

                  <tr>
                    <td valign="top" height="20" align="left"><strong>&nbsp;&nbsp;Pay Mode: </strong></td>
                    <td valign="top" align="left">'.$v_spdtl->BANK_PAY_MODE.'</td>
                    <td valign="top" align="left"><strong>&nbsp;&nbsp;Pay Bank:</strong></td>
                    <td valign="top" align="left">'.$v_spdtl->BANK_NAME.'</td>
                  </tr>

                  <tr>
                    <td valign="top" height="20" align="left"><strong>&nbsp;&nbsp;Pay Status: </strong></td>
                    <td valign="top" align="left">'.$v_spdtl->SFD_PAY_DONE.'</td>
                    <td valign="top" align="left"><strong>&nbsp;&nbsp;Bank Refrence No:</strong></td>
                    <td valign="top" align="left">'.$v_spdtl->CHQ_NO.'</td>
                  </tr>
                </tbody>
              ';
		 	} 
		$output .= '</table>';
		$output .= '<p style="font-size:14px; font-family:Calibri;"><font style="font-size:14px; 	font-family:Calibri;color: red;font-weight: bold;">NOTE: </font>It is only for the information to the concern office, Signature is not required.</p>';
		return $output; 
	}

	//this function used for pay program fee
	public function stu_fee_pay($UserId){
		$this->db->select('course_name(SFD_SSM_ID) COURSE,SFD_RECP_NO, SFD_CHQ_AMT,SFD_LAST_FEE_SUB_DATE LAST_DT,SFD_PAY_MODE');
		$this->db->where(['SFD_STU_ID'=>$UserId]);
		$this->db->where('SFD_PAY_DONE','N');
		$this->db->where(array('SFD_HOS_ID'=> NULL));
		$query = $this->db->get('STU_FEE_DTL A');
		return $query->result();		
	}

	//this function used for to get semester of the student
	public function getSemester($UserId, $SsmId){
    	$response = array();
     	// Select record
    	$ssmid=substr($SsmId,0,8);
		$this->db->order_by('SSM_YEAR_SEMNO', 'ASC');          			
		$this->db->select('SSM_YEAR_SEMNO,YEAR_NAME('."'$ssmid'".',SSM_YEAR_SEMNO) YEAR_SEM');
		$this->db->join('RE_RGN_DTL R','R.RRD_SSM_ID=S.SSM_ID');
		$this->db->from('SCHEME_TERM S');
		$this->db->where(['RRD_STU_ID'=>$UserId]);
		$q = $this->db->get();				
    	$response = $q->result_array();
    	return $response;
  	}

  	//this function used for to get session of the student
  	public function getSess($postData, $UserId, $SsmId){
        $ssmid=substr($SsmId,0,8);
        $res=$this->db->query("SELECT C.CSG_ID 
                    FROM RE_RGN_DTL R,COURSE_SUB_GROUPS C,SCHEME_TERM S
                    WHERE C.CSG_SSM_ID=R.RRD_SSM_ID
                    AND R.RRD_SSM_ID=S.SSM_ID
                    AND R.RRD_STU_ID= '$UserId'
                    AND S.SSM_SCH_ID = '$ssmid'
                    AND S.SSM_YEAR_SEMNO = '$postData'")->result();        
       	$str = "";
       	foreach ($res as $record)
       	$str .= $record->CSG_ID . ", ";        
       	$response=$this->db->query("SELECT DISTINCT A.ATD_SES_ID, SES_NAME(A.ATD_SES_ID) SESDESC,
					S.SES_START_DT FROM SESSION_MST S, ATTENDANCE A,ATTENDANCE_DTL B
					WHERE ATD_SES_ID = SES_ID
					AND AND_ATD_ID=ATD_ID
					AND AND_STU_ID='$UserId'
					AND A.ATD_CSG_ID IN (".rtrim($str,", ").")
        			ORDER BY SES_START_DT DESC")->result();         			
        return $response;        
  	}
  	
  	//this function used for to get Month on the basis of session
  	public function getMonths($postData){
  		$this->session->set_userdata('sesid', $postData);
  		$Sesid=substr($postData,5);
    	$response = array();    	    	 
    	// Select record
    	$this->db->select('SM_ID,SM_DESC');
    	$this->db->where('SM_SEM_TYPE', $Sesid);
    	$q = $this->db->get('SESSION_MONTH');    	     	   	
    	$response = $q->result_array();
    	return $response;
  	}

  	//this function used for to get attendance of the student
  	public function getStuAttendance($postData, $UserId, $SsmId, $Depid, $SesId){
  		$year= SUBSTR($SesId,0,4);
		$start_date='01-'.$postData.'-'.$year;
		$last_day= date('t',strtotime($start_date));
		$end_date=$last_day.'-'.$postData.'-'.$year;
		$this->db->order_by('SBD_PAPER', 'ASC');          			
		$this->db->select('COURSE_NAME(RRD_SSM_ID) COURSE,ATD_SBD_ID PAPER_CODE,SBD_PAPER, NVL(SUM(NVL(ATD_NO_CLASSES,0)),0) TOTAL_CLASSES,NVL(SUM(NVL(AND_CLASS_ATTEND,0)),0) ATTEND,ROUND(( NVL(SUM(NVL(AND_CLASS_ATTEND, 0)), 0)/NVL(SUM(NVL(ATD_NO_CLASSES, 0)), 0))*100,2) PER');
		$this->db->from('RE_RGN_DTL R');
		$this->db->join('ATTENDANCE A', 'A.ATD_SES_ID = R.RRD_SES_ID');
		$this->db->join('ATTENDANCE_DTL C', 'C.AND_ATD_ID = A.ATD_ID');
		$this->db->join('DEP_MST D', 'D.DEP_ID=R.RRD_DEP_ID');
		$this->db->join('SUBJECT_PAPERS E', 'A.ATD_SBD_ID = E.SBD_ID');
		$this->db->where(['RRD_STU_ID'=>$UserId]);
		$this->db->where(['RRD_SES_ID' =>$SesId]);
		$this->db->where(['AND_STU_ID'=>$UserId]);
		$this->db->where(['RRD_SSM_ID'=>$SsmId]);
		$this->db->where(['RRD_DEP_ID'=>$Depid]);
		$this->db->where('A.ATD_FROM_DT BETWEEN '."'$start_date'". ' and '.  "'$end_date'".'');
		$this->db->where('A.ATD_TO_DT BETWEEN '. "'$start_date'". ' and '. "'$end_date'".'');
		$this->db->group_by(array("RRD_DEP_ID","RRD_SSM_ID","RRD_REG_EX","RRD_STU_ID","ATD_SBD_ID","ATD_CSG_ID","DEP_DESC","SBD_PAPER")); 
		$q = $this->db->get();
		$response = $q->result_array();
    	return $response;	
	}
	

}
?>