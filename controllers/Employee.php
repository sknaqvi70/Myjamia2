<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Employee extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['login'])) {
			echo 'Unauthorised access is not allowed! Click <a href="'.base_url().'">here</a> to login';
			redirect(base_url());
			
		}
		$this->load->model('EmployeeModel', 'emp');
	}
	//this function used for to view profile
	public function profile(){
		$UserId= $_SESSION['login'];
		$data['emp_dtl']=$this->emp->emp_info($UserId);
		$data['edu_dtl']=$this->emp->emp_edu_dtl($UserId);
		$data['fam_dtl']=$this->emp->emp_fam_dtl($UserId);
		$data['bank_dtl']=$this->emp->emp_bank_dtl($UserId);
		$data['showrow'] =$this->emp->getEmpPic($UserId);


		/*if(!$showrow){
			return 'No Image';
		}else{
			//$image=$showrow->load();
			header("Content-type: image/jpeg");
			print $showrow;
		}
		exit();*/ 
		$this->load->view('emp/profile', $data);
	}

	/*public function getImage(){		
		$UserId 		= $_GET['id'];
		echo " User Id".$UserId;
		$showrow =$this->emp->getEmpPic($UserId);
		print $showrow;

	}*/

	//slary slip
	public function salary_slip(){
		$UserId= $_SESSION['login'];
		$data['year']=$this->emp->getSalYear($UserId);		
		$this->load->view('emp/salary_slip', $data);
	}
	public function getSalMonth(){
		if ($this->uri->segment(3)) {
			$year=$this->uri->segment(3);
			$UserId= $_SESSION['login'];
			$data['selectedyear'] = $year;
			$data['month']=$this->emp->getSalMonth($UserId,$year);		
			$this->load->view('emp/salary_slip', $data);
		}
	}

	public function getSalDetailsPdf(){
		$this->load->library('Pdf');
		if ($this->uri->segment(3)) {
			$value=$this->uri->segment(3);
			if (strlen((string) $value) == 6) {
				$monthNum  = substr($value, 0,2);
				$month = date("M", mktime(0, 0, 0, $monthNum, 10));
				$year = substr($value, 2);
			}else {
				$monthNum  = substr($value, 0,1);
				$month = date("M", mktime(0, 0, 0, $monthNum, 10));
				$year = substr($value, 1);
			}
			$UserId= $_SESSION['login'];
			$EmpDepid= $_SESSION['empdepid'];
			$start_date='01-'.$month.'-'.$year;
			$last_day= date('t',strtotime($start_date));
			$end_date=$last_day.'-'.$month.'-'.$year;
			$empDob = $this->emp->empDob($UserId);

			$html_content = '<!DOCTYPE html><html>
			<head>
				<style>
				#logoimage {
 					float: left ;
				}
				#headertext {
  					float: left ;
				}
				#headercontainer {
  					width: 400px ;
  					max-width: 100% ;
  					margin-left: auto ;
  					margin-right: auto ;
				}
				footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                color: black;
                text-align: center;
                line-height: 35px;
            	}
				</style>
			</head>
			<body>
			<div class="container-fluid" id="listdown">
			<div class="col-md-8 ">
			<div id="headercontainer">
				<img id="logoimage" src="'.__DIR__.'/../assets/images/appllogo1.png" alt="" style="width: 80px; height: 80px;">
					<ul id="headertext">
					<font size="25px" font-family:Calibri;">Finance & Account Office</font><br>
					<font size="20px" font-family:Calibri;">Jamia Millia Islamia,New Delhi</font>
					</ul>
					<br style="clear: both;">
				</div>';

			//$data['emp_dtl']=$this->emp->emp_info($UserId);
			$html_content .= $this->emp->salary_info($UserId,$EmpDepid,$end_date,$month,$year);
			$html_content .=$this->emp->earning_head($UserId,$end_date);
			$html_content .='</div></div></body></html>';
			$this->pdf->loadHtml($html_content);
            $this->pdf->render();
            //$password =$UserId.'@'.$empDob;
            $password =$this->emp->loginPwd($UserId);
            $this->pdf->get_canvas()->get_cpdf()->setEncryption($password, $password);
            ob_end_clean();
            ob_start();

            $this->pdf->stream("".$UserId."'_PaySlip_'".$month."-".$year.".pdf",array('Attachment' =>1));
		}
	}
}
?>