<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class EmployeeModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}
	//this function used for to view profile information
	public function emp_info($UserId){	
		$dateFormate 	= "DD-Mon-YYYY";          			
		$this->db->select('EMP_ID, EMP_TITLE,EMP_NAME(EMP_ID) NAME,TO_CHAR(EMP_DOB, '."'$dateFormate'".') EMPDOB,TO_CHAR(EMP_RET_DATE, '."'$dateFormate'".') EMPRETDATE, EMP_GENDER, EMP_SPOUSE, EMP_FATHER,EMP_MOTHER,DEP_DESC ,OFA_DESC,desig(EMP_ID) EMP_DESIGNATION, A.EMP_PERMANENT_ADD.MAIL EMAIL,A.EMP_PERMANENT_ADD.ADDRLINE1 P_ADD1,A.EMP_PERMANENT_ADD.ADDRLINE2 P_ADD2,A.EMP_PERMANENT_ADD.DISTRICT P_CITY, E.GEM_DESC P_STATE,A.EMP_PERMANENT_ADD.PIN P_PINCODE,A.EMP_PERMANENT_ADD.RES_PHNO P_MOBILE,A.EMP_TEMPORARY_ADD.ADDRLINE1 C_ADD1,A.EMP_TEMPORARY_ADD.ADDRLINE2 C_ADD2, A.EMP_TEMPORARY_ADD.DISTRICT C_CITY,F.GEM_DESC C_STATE,   A.EMP_TEMPORARY_ADD.PIN C_PINCODE, A.EMP_TEMPORARY_ADD.RES_PHNO C_MOBILE,EMP_NATIONALITY,EMP_EMAIL_ID,EMP_BLOOD_GROUP,EMP_PIC');
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

	//this function is used for fetch education details for the employee
	public function emp_edu_dtl($UserId){
		$this->db->select('EMQ_EMP_ID,EMQ_QUA_ID ,EMQ_DESC,EMQ_QIP,EMQ_YR_FROM,
			EMQ_YR_TO, EMQ_GRADE_PCT,EMQ_PCT,EMQ_UNIV_BRD,QUA_EDUCATION');		
		$this->db->join('QUA_MST C', 'A.EMQ_QUA_ID= C.QUA_ID ');
		$this->db->where(['EMQ_EMP_ID'=>'EMP\\'.$UserId]);
		$this->db->order_by('EMQ_YR_TO', 'DESC');
		$query = $this->db->get('EMP_QUAL A');
		return $query->result();

	}

	//this function is used to fetch employee family details
	public function emp_fam_dtl($UserId){
		$dateFormate 	= "DD-Mon-YYYY";          			
		$this->db->select('FAM_MEM_ID,FAM_EMP_ID,FAM_MEM_NAME,FAM_RELATIONSHIP,FAM_GENDER,FAM_MARITAL_STATUS,TO_CHAR(FAM_DOB, '."'$dateFormate'".') FAMDOB,FAM_DEPENDENT,FAM_NOMINEE,FAM_CPF,FAM_GPF,FAM_PENSION,FAM_ACCT_NO,FAM_BANK_NAME,FAM_INCOME,FAM_STATUS,FAM_REMARKS');
		$this->db->where(['FAM_EMP_ID'=>'EMP\\'.$UserId]);
		$this->db->order_by('FAM_MEM_ID', 'ASC');
		$query = $this->db->get('FAM_DTL');

		return $query->result();

	}

	//this funtion is used for fetch bank details of employee
	public function emp_bank_dtl($UserId){
		$this->db->select('EMP_ID, EMP_BANK_NAME,EMP_BRANCH ,EMP_ACC_TYPE,
			EMP_ACC_NO,EMP_BANK_ADDRESS');
		$this->db->where(['EMP_ID'=>'EMP\\'.$UserId]);
		$query = $this->db->get('EMP_MST');

		return $query->result();

	}

	//this function is used to fetch employee pic from database
	public function getEmpPic($UserId){
		$empid='EMP\\'.$UserId;
		$response=$this->db->query("SELECT EIC_PICS FROM EMP_ID_CARD
					WHERE EIC_ISS_DATE=(SELECT MAX(EIC_ISS_DATE) FROM EMP_ID_CARD
					WHERE EIC_EMP_ID='$empid')
					AND EIC_EMP_ID='$empid'");
		if($response->num_rows() > 0) 
				return $response->row()->EIC_PICS;
			else
				return "No Employee Image to show"; 
	}

	public function getSalYear($UserId){
		$cr_yr 	= date('Y');
		$where 	="EXTRACT( YEAR FROM EDH_DATE) !=".$cr_yr;
		$this->db->distinct('EXTRACT( YEAR FROM EDH_DATE)');
		$this->db->select('EXTRACT( YEAR FROM EDH_DATE) YEAR');
		$this->db->where(['EDH_EMP_ID'=>'EMP\\'.$UserId]);
		$this->db->where('EDH_EDM_ID','O006');
		$this->db->where($where);
		$this->db->order_by('YEAR', 'DESC');
		$query = $this->db->get('EMP_EARN_DED_HIST');

		return $query->result();
	}

	public function getSalMonth($UserId,$year){
		$where = "EXTRACT( YEAR FROM EDH_DATE)='$year'";
		$this->db->distinct('EXTRACT( MONTH FROM EDH_DATE) MONTH');
		$this->db->select('EXTRACT( MONTH FROM EDH_DATE) MONTH');
		$this->db->where(['EDH_EMP_ID'=>'EMP\\'.$UserId]);
		$this->db->where('EDH_EDM_ID','O006');
		$this->db->where($where);
		$this->db->order_by('MONTH', 'ASC');
		$query = $this->db->get('EMP_EARN_DED_HIST');

		return $query->result();
	}

	public function salary_info($UserId,$EmpDepid,$end_date,$month,$year){
		$dateFormate 		= "DD-MM-YYYY";
		$printDateFormate 	= "DAY, DD-Mon-YYYY HH:MI:SS am";
		$printdate	=date('d-m-Y');
		$array_edh_amt = array('2', '3');   		
		
		$this->db->select('EMP.EMP_ID, EMP_NAME(EMP_ID) NAME, DSG.DSG_DESC
		 	               DESIGNATION,INITCAP(SUBSTR(DEP_DESC(EMP_POST_DEP),1,40)) 
		 	               EMP_POST_DEP,INITCAP(SUBSTR(dep.dep_desc,1,40)) 
		 	               DEPARTMENT, EMP.EMP_AGENCY, EDH.EDH_STATUS,EDH. 
		 	               EDH_PAYSCALE , EDH.EDH_ACC_NO,EDH.EDH_PF_NO,EDH.EDH_DNI,
		 	               EDH.EDH_JOINING_TYPE STATUS,EMP.EMP_TITLE,EMP.EMP_PAN, 
		 	               OFA_DESC,EDH.EDH_DATE,EMP_PF_NO,TO_CHAR(TO_DATE('."'$printdate'".', '."'$dateFormate'".'), '."'$printDateFormate'".') PRINTDATE');
		$this->db->from('EMP_MST EMP');
		$this->db->join('EMP_EARN_DED_HIST EDH', 'EDH.EDH_EMP_ID = EMP.EMP_ID');
		$this->db->join('DSG_MST DSG', 'DSG.DSG_ID = EDH.EDH_DSG_ID');
		$this->db->join('DEP_MST DEP', 'DEP.DEP_ID = EMP.EMP_DEPARTMENT');
		$this->db->join('OFF_FAC_MST', 'OFA_ID= EMP.EMP_OFFICE');
		$this->db->where('EDH.EDH_EDM_ID','O004');
		$this->db->where('EDH.EDH_DATE',$end_date);
		$this->db->where('EMP_POST_DEP',$EmpDepid);
		$this->db->where_in('EDH.EDH_AMT', $array_edh_amt);
		$this->db->where('EMP_JOINING_TYPE','CONFIRMED');
		$this->db->where('EMP_ID','EMP\\'.$UserId); 	
		$query = $this->db->get();
		
		$output = '<table class="table table-striped table-hover" width="550" align="center" style="font-size:14px; font-family:Calibri; border-radius: 10px;border: 1px solid;">';
		 	foreach($query->result() as $v_sdtl){
		 	$output .='<tbody>
              <tr>
                <td valign="top" height="20" align="left"><strong>&nbsp;Name: </strong></td>
                <td valign="top" align="left"><b>'.$v_sdtl->EMP_TITLE.' '.ucwords(strtolower("$v_sdtl->NAME")).'</b></td>
                <td valign="top" align="left"><strong>&nbsp;Designation: </strong></td>
                <td valign="top" align="left">'.ucwords(strtolower("$v_sdtl->DESIGNATION")).'</td>
                <td valign="top" align="left"><strong>&nbsp;Month: </strong></td>
                <td valign="top" align="left">'.$month.', '.$year.'</td>
              </tr>              
              <tr>                
                <td valign="top" height="20" align="left"><strong>&nbsp;EMP id: </strong></td>
                <td valign="top" align="left">'.ucwords(strtoupper("$v_sdtl->EMP_ID")).
                '</td>
                <td valign="top" align="left"><strong>&nbsp;DNI: </strong></td>
                <td valign="top" align="left">'.ucwords(strtolower("$v_sdtl->EDH_DNI")).
                '</td>
          		<td valign="top" align="left"><strong>&nbsp;Scale/PB: </strong></td>
                <td valign="top" align="left">'.ucwords(strtolower("$v_sdtl->EDH_PAYSCALE")).'
                </td>                
              </tr>
              <tr>                
                <td valign="top" height="20"align="left"><strong>&nbsp;A/C No.: </strong></td>
                <td valign="top" align="left">'.ucwords(strtolower("$v_sdtl->EDH_ACC_NO")).
                '</td>
                <td valign="top" align="left"><strong>&nbsp;PAN: </strong></td>
                <td valign="top" align="left">'.ucwords(strtoupper("$v_sdtl->EMP_PAN")).
                '</td>
          		<td valign="top" align="left"><strong>&nbsp;Status: </strong></td>
                <td valign="top" align="left">'.ucwords(strtolower("$v_sdtl->STATUS")).
                '</td>                
              </tr>              
              <tr>
                <td valign="top" height="20" align="left"><strong>&nbsp;Post Dep: </strong></td>
                <td valign="top" align="left">'.ucwords(strtolower("$v_sdtl->EMP_POST_DEP")).'</td>
                <td valign="top" align="left"><strong>&nbsp;Sal Dep: <br><br>&nbsp;PF No:</strong></td>
                <td valign="top" align="left" colspan="3">'.ucwords(strtolower("$v_sdtl->DEPARTMENT")).'<br><br>'.($v_sdtl->EMP_PF_NO).'</td>
              </tr>
            </tbody>
            </table><br>
			<footer>
            Copyright &copy; Jamia Millia Islamia, Printed On : ('.$v_sdtl->PRINTDATE.') 
        	</footer>';
        }
		return $output;/*
		return $query->result();*/

	}
	public function earning_head($UserId,$end_date){
		$empid='EMP\\'.$UserId;
		$response=$this->db->query("SELECT EDM_INDX INDX, EDM.EDM_SHORT_DESC,
  					EDH.EDH_EMP_ID, nvl(EDH.EDH_AMT,0) EDH_AMT 
  					FROM EMP_EARN_DED_HIST EDH, EARN_DED_MST EDM
					WHERE EDH_EDM_ID(+) = EDM_ID AND
					substr(EDM_ID,1,1) = 'E' AND
					EDH_EMP_ID (+)= '$empid'  AND
					EDH.EDH_DATE(+) = last_day('$end_date') AND
					EDM.EDM_IN_PAYSLIP = 'Y' And 
					EDM_DED_TYPE <> 'EP'
			UNION
			SELECT EDM_INDX INDX, EDM.EDM_SHORT_DESC, EDH.EDH_EMP_ID, 
					nvl(EDH.EDH_AMT,0) EDH_AMT
					FROM EMP_EARN_DED_HIST EDH, EARN_DED_MST EDM
					WHERE EDH_EDM_ID(+) = EDM_ID AND
					substr(EDM_ID,1,1) = 'E' AND
					EDH_EMP_ID (+)= '$empid'  AND
					EDH.EDH_DATE(+) = last_day('$end_date') AND
					EDM.EDM_IN_PAYSLIP = 'W' AND
					nvl(EDH.EDH_AMT,0) > 0 And
					EDM_DED_TYPE <> 'EP'
			UNION
			SELECT 50 INDX, 'Others', EDH.EDH_EMP_ID, 
					SUM(nvl(EDH.EDH_AMT,0)) EDH_AMT
					FROM EMP_EARN_DED_HIST EDH, EARN_DED_MST EDM
					WHERE EDH_EDM_ID(+) = EDM_ID AND
					substr(EDM_ID,1,1) = 'E' AND
					EDH_EMP_ID (+)= '$empid'  AND
					EDH.EDH_DATE(+) = last_day('$end_date') AND
					EDM.EDM_IN_PAYSLIP = 'N' and 
					edh.edh_emp_id Is Not Null And
					EDM_DED_TYPE <> 'EP'
					GROUP BY EDH.EDH_EMP_ID
					ORDER BY INDX")->result();

		$response1=$this->db->query("SELECT EDM_INDX INDX, EDM.EDM_SHORT_DESC,
  					EDH.EDH_EMP_ID, nvl(EDH.EDH_AMT,0) EDH_AMT ,EDM_DED_TYPE
					FROM EMP_EARN_DED_HIST EDH, EARN_DED_MST EDM
					WHERE EDH_EDM_ID(+) = EDM_ID AND
					substr(EDM_ID,1,1) = 'D' AND
					EDH_EMP_ID (+)= '$empid'  AND
					EDM_DED_TYPE <> 'EP' AND
					EDH.EDH_DATE(+) = last_day('$end_date') AND
					EDM.EDM_IN_PAYSLIP = 'Y'
			UNION
			SELECT EDM_INDX INDX, EDM.EDM_SHORT_DESC,
  					EDH.EDH_EMP_ID, nvl(EDH.EDH_AMT,0) EDH_AMT ,EDM_DED_TYPE
					FROM EMP_EARN_DED_HIST EDH, EARN_DED_MST EDM
					WHERE EDH_EDM_ID(+) = EDM_ID AND
					substr(EDM_ID,1,1) = 'D' AND
					EDH_EMP_ID (+)= '$empid'  AND
					EDM_DED_TYPE <> 'EP' AND
					EDH.EDH_DATE(+) = last_day('$end_date') AND
					EDM.EDM_IN_PAYSLIP = 'W' AND
					nvl(EDH.EDH_AMT,0) > 0
			UNION
			SELECT 50 INDX, 'Others', EDH.EDH_EMP_ID, 
					SUM(nvl(EDH.EDH_AMT,0)) EDH_AMT,''
					FROM EMP_EARN_DED_HIST EDH, EARN_DED_MST EDM
					WHERE EDH_EDM_ID(+) = EDM_ID AND
					EDH_EMP_ID (+)= '$empid'  AND
					substr(EDM_ID,1,1) = 'D' AND
					EDM_DED_TYPE <> 'EP' AND
					EDH.EDH_DATE(+) = last_day('$end_date') AND
					EDM.EDM_IN_PAYSLIP = 'N' and 
					edh.EDH_EMP_ID Is Not Null 
					GROUP BY EDH.EDH_EMP_ID
					ORDER BY INDX")->result();

		$response2=$this->db->query(" SELECT nvl(SUM(nvl(EDH_AMT,0)),0) amt
					FROM  EMP_EARN_DED_HIST
					WHERE EDH_EMP_ID = '$empid'
					AND substr(EDH_EDM_ID,1,1) = 'E' 
					AND EDH_DATE = last_day('$end_date')")->result();

		$response3=$this->db->query(" SELECT nvl(SUM(nvl(EDH_AMT,0)),0) AMT
					FROM  EMP_EARN_DED_HIST
					WHERE EDH_EMP_ID = '$empid'
					AND substr(EDH_EDM_ID,1,1) = 'D' 
					AND EDH_DATE = last_day('$end_date')")->result();
  		
  		$response4=$this->db->query(" Select EMP_PF_NO
					From   EMP_MST
					Where  EMP_ID='$empid'")->result();

  		$output = '<div class="row">
  		<div class="col-sm-2 table-responsive">
  		<table class="table table-striped table-hover"  align="center"width="550" style="font-size:14px; font-family:Calibri; border-radius: 10px; border: 1px solid;">';
  		$output .= '<tr>
	  					<th   align="left">-----------------E A R N I N G S-----------------</th>
	  					<th>&nbsp;&nbsp;</th>
	  					<th   align="left">--------------D E D U C T I O N S--------------</th>
  					</tr>';
  		$output .= '<tr><td  valign="top">';

  		$output .= '<table>';
  		$column = 1;
  			foreach ($response as $v_ehead) {

  				$output .= '<tr><td align="left">';
			  	$output .= $v_ehead->EDM_SHORT_DESC; 
			  	$output .= '</td><td>&nbsp;&nbsp;</td><td align="right">';
			  	$output .= $v_ehead->EDH_AMT;
			  	$output .= '</td><td>&nbsp;&nbsp;</td>';
			}		  	
		  	
  		$output .= '</table><td>&nbsp;&nbsp;</td><td>';

  		$output .= '<table>';
  		$column = 1;
  			foreach ($response1 as $v_dhead) {

  				if($column == 1) {
			  		$output .= '<tr><td align="left">';
			  		$output .= $v_dhead->EDM_SHORT_DESC; 
			  		$output .= '</td><td>&nbsp;&nbsp;</td><td align="right">';
			  		$output .= $v_dhead->EDH_AMT;
			  		$output .= '</td><td>&nbsp;&nbsp;</td>';
			  		$column = 2;
			  	} else {
			  		$output .= '<td align="left">';
			  		$output .= $v_dhead->EDM_SHORT_DESC; 
			  		$output .= '</td><td>&nbsp;&nbsp;</td><td align="right">';
			  		$output .= $v_dhead->EDH_AMT;
			  		$output .= '</td></tr>';
			  		$column = 1;
			  	}			  	
		  	}
		$output .= '</table></td></tr></table>';

		$output .='<div class="colspam">
  		<table table class="table table-striped table-hover" width="550" align="center" style="font-size:14px; font-family:Calibri; border-radius: 10px;border: 1px solid;">';
  		foreach($response2 as $v_gpay){
  		$output .='<tfoot>
        	<tr>
	            <th scope="row">&nbsp;Gross Pay:</th>
	            <td>'.($v_gpay->AMT).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	    foreach($response3 as $v_dpay){
	    $output .='<th scope="row">&nbsp;&nbsp;&nbsp;</th>
	        	<td>&nbsp;&nbsp;&nbsp;</td>
	        	<th scope="row">&nbsp;&nbsp;&nbsp;</th>
	        	<td>&nbsp;&nbsp;&nbsp;</td>
	        	<th scope="row">&nbsp;&nbsp;&nbsp;</th>
	        	<td>&nbsp;&nbsp;&nbsp;</td>
	        	<th scope="row">&nbsp;Deductions:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	            <td>'.$v_dpay->AMT.'</td>';
	         }
	    $output .='<th scope="row">Net Pay:&nbsp;&nbsp;&nbsp;&nbsp;</th>
	            <td>'.(($v_gpay->AMT)-($v_dpay->AMT)).'</td>';
       	 	
        $output .='</tr></tfoot>';
  		}
  		$output .='</table></div>';
  		$output .='<div class="colspam"><br><br><br><br><br><br><table>
  			<tr> 
  				<td> <font size="1" font-family:Calibri;>REQUIRES AUTHORIZATION</font></td>
  				<td> <font size="4" font-family:Calibri;>SECTION OFFICER(SALARIES)</font></td>
  			</tr>
		</div>';
		return $output;

	}

	// this function is used for fetch DOB of employee
	public function empDob($UserId){
		$select = "TO_CHAR(EMP_DOB, 'DDMMYYYY') DOB";
		$this->db->select($select);
		$this->db->from('EMP_MST');
		$this->db->where(['EMP_ID'=>'EMP\\'.$UserId]);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->DOB;
			else
				return '0'; //Error
		

	}

	//this function is used to get login password
	public function loginPwd($UserId){
		$this->db->select('MJ_USER_PASSWORD PWD');
		$this->db->from('MJ_USER_MST');
		$this->db->where(['MJ_USER_LOGIN'=>$UserId]);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
				return $query->row()->PWD;
			else
				return '0'; //Error
		


	}
}