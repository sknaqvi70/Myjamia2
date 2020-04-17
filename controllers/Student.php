<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Student extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['login'])) {
			echo 'Unauthorised access is not allowed! Click <a href="'.base_url().'">here</a> to login';
			redirect(base_url());
			
		}
		$this->load->model('StudentModel', 'stu');
	}
	//this function used for to view profile
	public function profile(){
		$UserId				= $_SESSION['login'];
		$data['stu_dtl']	=$this->stu->stu_info($UserId);
		$data['filePath']	=$this->stu->filePath();
		$this->load->view('stu/profile', $data);
	}
	//this function used for fetch details of program fee paid to display
	public function feereciept(){	
		$UserId= $_SESSION['login'];
		$data['stu_fee_dtl']=$this->stu->getFeeReceipt($UserId);		
		$this->load->view('stu/feereciept', $data);
	}
	public function getImage(){
		$img = $_GET['i'];
		$ext = substr($img, -4);
		switch ($ext) {
  			case 'JFIF':
    			$mime = 'image/JFIF';
    			break;
  			case 'jpg':
    			$mime = 'image/jpeg';
    			break;
  			case 'gif':
    			$mime = 'image/gif';
    			break;
  			case 'png':
    			$mime = 'image/png';
    			break;
  			default: $mime = false;
		}
		if ($mime) {
  			header('Content-type: '.$mime);
			header('Content-length: '.filesize($img));
			$file = @fopen($img, 'rb');
			if ($file) {
  				fpassthru($file);
  				exit; 
			}
		}
	}

	//this function used for to fetch fee paid to view in details
	public function get_pfee_view(){
		if ($this->uri->segment(3)) {
			$SFD_FRECP_NO=$this->uri->segment(3);
			$UserId= $_SESSION['login'];
			$data['stu_pfee_dtl']=$this->stu->fetch_single_fee_details($SFD_FRECP_NO,$UserId);
			$this->load->view('stu/feereciept', $data);
		}
	}

	//this function used for to generate pdf of fee paid details to print
	public function get_pfee_pdf(){	
		$this->load->library('Pdf');
		if ($this->uri->segment(3)) {
			$SFD_FRECP_NO=$this->uri->segment(3);
			$UserId= $_SESSION['login'];			
			$html_content = '<center>
                <h3>JAMIA MILLIA ISLAMIA</h3>
                <h4>Fee Payment Acknowledge Receipt</h4>
                <img  src="'.__DIR__.'/../assets/images/appllogo1.png" alt="" style="width: 100px; height:100px;">                                
                <br><br>
            	</center>
            	<p align="left" style="font-size:14px; font-family:Calibri;">This is to acknowledge the receipt of fee as per the</p>
            ';
            $html_content .= $this->stu->fetch_single_fee_details($SFD_FRECP_NO,$UserId);
            $this->pdf->loadHtml($html_content);
            $this->pdf->render();
            ob_end_clean();
            ob_start();
            $this->pdf->stream("".$SFD_FRECP_NO.".pdf",array('Attachment' =>1));            
		}
	}

	//this function used for to pay program fee
	public function feepayment(){
		$UserId= $_SESSION['login'];
		$data['stu_fee_pay']=$this->stu->stu_fee_pay($UserId);
		$this->load->view('stu/feepayment', $data);
		
	}
	//this function used for to get semester/year of student and redirect to Attendence page
	public function attendance(){
		$UserId= $_SESSION['login'];
		$SsmId= $_SESSION['ssmid'];			
		$data['semester'] = $this->stu->getSemester($UserId, $SsmId);			
		$this->load->view('stu/Attendance', $data);
	}

	//this function used for to get session on the basis of semester/year of student
	public function getSession(){     
		$UserId= $_SESSION['login'];
		$SsmId= $_SESSION['ssmid'];
    	$postData = $this->input->post('v_semester');    
    	$data = $this->stu->getSess($postData,$UserId,$SsmId);        
    	echo json_encode($data); 
  	}

  	//this function used for to get Month on the basis of session
  	public function getMonths(){ 
    	// POST data 
  		$postData = $this->input->post('v_session');
     	// get data 
    	$data = $this->stu->getMonths($postData);
    	echo json_encode($data); 
  	}

  	//this function used for to get attendance of the student
  	public function getStuAttendance(){
  		$UserId= $_SESSION['login'];
  		$SsmId = $_SESSION['ssmid'];
  		$Depid = $_SESSION['depid'];
  		$SesId = $_SESSION['sesid'];
  		$postData = $this->input->post('v_month');
		$data=$this->stu->getStuAttendance($postData, $UserId, $SsmId, $Depid, $SesId);
		//$data=$this->stu->getStuTotAtt($postData, $UserId, $SsmId, $Depid, $SesId);
		echo json_encode($data);
  	}

  	// this function used for feedback
  	public function feedback(){
  		$this->load->view('stu/Feedback');
  	}
}
?>
