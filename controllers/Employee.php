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
		$data['stu_dtl']=$this->emp->emp_info($UserId);
		$this->load->view('emp/profile', $data);
	}

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

			$html_content = '<!DOCTYPE html><html><body>
			<div class="container-fluid" id="listdown">
			<div class="col-md-8 ">
			<center>
            	<p style="font-size:25px; font-family:Calibri;">JAMIA MILLIA ISLAMIA</p>
            	<p style="font-size:20px; font-family:Calibri;">Finance & Account Office</p>
            	<img src="'.base_url().'Assets/img/appllogo1.jpg" alt="" style="width: 100px; height: 100px;">                                
            	<br><br>
          	</center>';

			//$data['emp_dtl']=$this->emp->emp_info($UserId);
			$html_content .= $this->emp->salary_info($UserId,$EmpDepid,$end_date,$month,$year);
			$html_content .=$this->emp->earning_head($UserId,$end_date);
			$html_content .='</div></div></body></html>';
			$this->pdf->loadHtml($html_content);
            $this->pdf->render();
            ob_end_clean();
            ob_start();
            $this->pdf->stream("".$UserId."'_'".$end_date.".pdf",array('Attachment' =>0));
		}
	}
}
?>