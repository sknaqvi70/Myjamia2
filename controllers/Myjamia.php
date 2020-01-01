<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myjamia extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		phpinfo();
	//	$this->load->model('Test');
	//$this->load->view('welcome_jmi');
	$this->load->helper("url");
	echo "Hello, how are you\n";
	$str = '28/2/2019.';
	
	//echo preg_match("/[0-31]{2}\/[0-12]{2}\/[0-9]{4}/", $str);
	list($day, $month, $year)=explode("/",$str);
	
	if (strpos($str,".") == true) {
		echo "Bad date: Point is not allowed.";
	}
	else {
		if (is_numeric($day) == 1 && is_numeric($month) == 1 & is_numeric($year) == 1) {
			if(checkdate($month,$day,$year)) 
				echo "good";
			else
				echo "Bad date";
		}
	else {
		echo "Bad date: Non numeric characters not allowed.";
	}
}
	
}

}