<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class StudentModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}
	//this function used for to view profile information
	public function stu_info($UserId){	          			
		$this->db->select('A.STU_ID,STU_NAME(A.STU_ID) NAME,A.STU_FATHER_NAME,A.STU_MOTHER_NAME,A.STU_HUSBAND_NAME,A.STU_SEX,A.STU_BLOOD_GR,A.STU_DOB,A.STU_DOA,A.STU_COMMU_ADDR.MAIL EMAIL,A.STU_PER_ADDR.ADDRLINE1 P_ADD1,A.STU_PER_ADDR.ADDRLINE2 P_ADD2,A.STU_PER_ADDR.DISTRICT P_CITY,E.GEM_DESC P_STATE,A.STU_PER_ADDR.PIN P_PINCODE,A.STU_PER_ADDR.RES_PHNO P_MOBILE,A.STU_COMMU_ADDR.ADDRLINE1 C_ADD1,A.STU_COMMU_ADDR.ADDRLINE2 C_ADD2,A.STU_COMMU_ADDR.DISTRICT C_CITY,F.GEM_DESC C_STATE,A.STU_COMMU_ADDR.PIN C_PINCODE,A.STU_COMMU_ADDR.RES_PHNO C_MOBILE,ltrim(rtrim(a.stu_nationality)) STU_NATIONALITY,course_name(A.STU_SSM_ID) COURSE,SUBSTR(A.STU_SSM_ID,1,8) SSM_ID,C.DEP_DESC,A.STU_DEPT,D.OFA_DESC');
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
		foreach($query->result() as $row){
    		if ($row->STU_ID==$UserId) {    			
			$this->session->set_userdata('STU_DEPT', $row->STU_DEPT);
            $this->session->set_userdata('SSM_ID', $row->SSM_ID);
			}	
		}
		return $query->result();			
	}
	//this function for fetch details of fee paid to download fee receipts
	public function getFeeReceipt($UserId)	{
		$id=$this->session->userdata('MJ_ID_NO');
		$this->db->select('course_name(SFD_SSM_ID) COURSE,SFD_RECP_NO, SFD_CHQ_NO,SFD_BANK,SFD_CHQ_AMT,SFD_CHQ_DT,SFD_LAST_FEE_SUB_DATE LAST_DT,SFD_PAY_MODE');		
		$this->db->join('RE_RGN_DTL R','R.RRD_RECEIPT_NO=A.SFD_RECP_NO');
		$this->db->where(['RRD_STU_ID'=>$UserId]);
		$query = $this->db->get('STU_FEE_DTL A');
		return $query->result();
	}

	//this function used for fetch sigle fee details to view and print
	public function fetch_single_fee_details($SFD_FRECP_NO,$UserId){
		$id=$this->session->userdata('MJ_ID_NO');
		$this->db->select('course_name(SFD_SSM_ID) COURSE,SFD_RECP_NO,RRD_STU_ID,STU_NAME(RRD_STU_ID) SNAME,STU_FATHER_NAME,SFD_CHQ_NO,SFD_BANK,SFD_CHQ_AMT,SFD_CHQ_DT,SFD_LAST_FEE_SUB_DATE LAST_DT,SFD_PAY_MODE,SFD_PAY_DONE');	
		$this->db->join('RE_RGN_DTL R','R.RRD_RECEIPT_NO=A.SFD_RECP_NO');	
		$this->db->join('STU_MST S','S.STU_ID=R.RRD_STU_ID');		
		$this->db->where(['R.RRD_STU_ID'=>$UserId]);
		$this->db->where('SFD_RECP_NO',$SFD_FRECP_NO);
		$data = $this->db->get('STU_FEE_DTL A');
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
                    <td valign="top" align="left">'.$v_spdtl->SFD_PAY_MODE.'</td>
                    <td valign="top" align="left"><strong>&nbsp;&nbsp;Pay Bank:</strong></td>
                    <td valign="top" align="left">'.$v_spdtl->SFD_BANK.'</td>
                  </tr>

                  <tr>
                    <td valign="top" height="20" align="left"><strong>&nbsp;&nbsp;Pay Status: </strong></td>
                    <td valign="top" align="left">'.$v_spdtl->SFD_PAY_DONE.'</td>
                    <td valign="top" align="left"><strong>&nbsp;&nbsp;Bank Refrence No:</strong></td>
                    <td valign="top" align="left">'.$v_spdtl->SFD_CHQ_NO.'</td>
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
		$year=date("Y");
		$id=$this->session->userdata('MJ_ID_NO');
		$this->db->select('course_name(SFD_SSM_ID) COURSE,SFD_RECP_NO, SFD_CHQ_AMT,SFD_LAST_FEE_SUB_DATE LAST_DT,SFD_PAY_MODE');
		$this->db->where(['SFD_STU_ID'=>$UserId]);
		$this->db->where('SFD_PAY_DONE','N');
		$this->db->where(array('SFD_HOS_ID'=> NULL));
		$query = $this->db->get('STU_FEE_DTL A');
		return $query->result();
		
	}

}
?>