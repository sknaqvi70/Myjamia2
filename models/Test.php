<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_MODEL {
	public function test(){
	
	$this->load->database();
	$query = $this->db->query("Select * from emp_mail");
	print_r($query->result());
	echo "Lodaded";

	}
}
?>
