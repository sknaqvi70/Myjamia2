<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 //def("DOMPDF_ENABLE_REMOTE", true);
require_once 'dompdf/autoload.inc.php';
//require_once 'dompdf/dompdf_config.inc.inc.php';



use Dompdf\Dompdf;
use Dompdf\Image;


class Pdf extends Dompdf
{
	public function __construct(){
		parent::__construct();

	}
}