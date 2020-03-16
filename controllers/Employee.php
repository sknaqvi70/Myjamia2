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
}
?>