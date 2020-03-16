<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Feedback extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('FeedbackModel', 'FM');
	}



public function complaintFeedback(){
		//Get Value of EncryptedResourceID from URL
		$RID = $this->MyJamiaDecrypt($this->input->get('RID'));
		//Get Value of EncryptedResourceName from URL
		$Rntext = $this->MyJamiaDecrypt($this->input->get('rntext'));
		//Get value of rtext from URL
		$RText = $this->input->get('rtext');
		//Get value of rtext from URL
		$cmno = $this->input->get('CM');
		//Get Value of EncryptedCUserID from URL
		$CUID = $this->MyJamiaDecrypt($this->input->get('CUID'));
		//Get Value of Encryptedsend mail to from URL
		$to = $this->MyJamiaDecrypt($this->input->get('to'));
		//Get Value of Current Time from URL
		$cttext = $this->MyJamiaDecrypt($this->input->get('cttext'));
		date_default_timezone_set('Asia/Kolkata');
		$CurrentTime = date("d-m-Y H:i:s");
		$LinkExpireTime = date('d-m-Y H:i:s',strtotime('+48 hour',strtotime($cttext)));
		$ValidationResult = $this->FM->ValidateRecordForFeedback($CUID,$cmno,$RID);
		
		if ($CurrentTime<$LinkExpireTime) {
		if ($ValidationResult == 0) {
			$data['VerificationResult'] = $this->FM->VerifyEMail($cmno, $RText, $to);
			$data['RegistrationDate'] = $this->FM->ComplaintRegistrationDate($cmno, $RText);
			$data['AssignedDate'] = $this->FM->ComplaintAssignedDate($cmno, $RID);
			$data['ClousreDate'] = $this->FM->ComplaintClousreDate($cmno, $RID);
			$data['RID'] 	= $RID;
			$data['Rntext'] = $Rntext;
			$data['CUID'] 	= $CUID;
			$data['cmno'] 	= $cmno;
			$data['cttext']	= $cttext;
			$data['RText']	= $RText;
			$data['to']		= $to;

			$data['message'] = 'Please give your feedback';
			$data['messageType'] = 'I';
		}else{
			$data['message'] = 'Please give your feedback';
			$data['messageType'] = 'I';
			$data['feedbackdone'] = 'You Already given feedback. Thanks for giving feedback';	
		}
	
	}else{
		$data['message'] = 'Please give your feedback';
		$data['messageType'] = 'E';
		$data['expired'] = 'Link was expired';
	}
	$this->load->view('public/feedbackForm',$data);
	}

	// this function is used for insert the feedback crossponding employee
	public function setComplaintFeedback(){
		$CUID 		 = $this->input->post('CUID');
		$cmno 		 = $this->input->post('cmno');
		$RID 		 = $this->input->post('RID');
		$Rntext 	 = $this->input->post('Rntext');
		$RText 		 = $this->input->post('RText');
		$to 		 = $this->input->post('to');
		$Q1_feedback = $this->input->post('Q1_feedback');
		$Q2_feedback = $this->input->post('Q2_feedback');
		$Q3_feedback = $this->input->post('Q3_feedback');
		$Q4_feedback = $this->input->post('Q4_feedback');
		$Q5_feedback = $this->input->post('Q5_feedback');
		$FEEDBACK_SUGGESTION = $this->input->post('FEEDBACK_SUGGESTION');

		//Set Validation Rules
		$this->form_validation->set_rules('Q1_feedback','Please select ','required');
		$this->form_validation->set_rules('Q2_feedback','Please select ','required');
		$this->form_validation->set_rules('Q3_feedback','Please select ','required');
		$this->form_validation->set_rules('Q4_feedback','Please select','required');
		$this->form_validation->set_rules('Q5_feedback','Please select','required');

		//Set Error Delimeter

		$this->form_validation->set_error_delimiters("<p class='text-danger'>",'</p>');
		 
		$data['RID'] 	= $RID;
		$data['Rntext'] = $Rntext;
		$data['CUID'] 	= $CUID;
		$data['cmno'] 	= $cmno;
		$data['RText']	= $RText;
		$data['to']		= $to;
		$data['VerificationResult'] = $this->FM->VerifyEMail($cmno, $RText, $to);
		$data['RegistrationDate'] = $this->FM->ComplaintRegistrationDate($cmno, $RText);
		$data['AssignedDate'] = $this->FM->ComplaintAssignedDate($cmno, $RID);
		$data['ClousreDate'] = $this->FM->ComplaintClousreDate($cmno, $RID);
		
		if ($this->form_validation->run() == FALSE) {		
	               
	    	//if(validation_errors()) echo validation_errors(); 
           	$data['message'] = 'Please review your data.' ;
           	$data['messageType'] = 'D';
			$this->load->view('/public/feedbackForm',$data);
        }
        else {
	       		$this->load->model('UserModel','UM');
				$data['message']  = $this->FM->AddResourceFeedback(
						$CUID,
						$cmno,
						$RID,
						$Q1_feedback,
						$Q2_feedback,
						$Q3_feedback,
						$Q4_feedback,
						$Q5_feedback,
						$FEEDBACK_SUGGESTION
				);
				if ($data['message'] == 'OK') {
				
					$data['message'] = 'Thank you for giving feedback. We received Your feedback successfully.';
					$data['messageType'] = 'S';
					$this->load->view('/public/feedbackForm',$data);
				}
				else
				{
					$data['message'] = 'Error Please give your feedback through mail.';
					$data['messageType'] = 'D';
					$this->load->view('/public/feedbackForm',$data);

				}
	       			
	        }

	}

	//Function to Decrypt a string
	function MyJamiaDecrypt($str) {

		// Store the cipher method 
		$ciphering = "AES-128-CTR"; 
  
		// Use OpenSSl Encryption method 
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
				
		// Non-NULL Initialization Vector for decryption 
		$decryption_iv = '1234567891011121'; 
		  
		// Store the decryption key 
		$decryption_key = "MyJamiaEncryptionString"; 
		  
		// Use openssl_decrypt() function to decrypt the data 
		return openssl_decrypt ($str, $ciphering,  
		        $decryption_key, $options, $decryption_iv); 	  
	}
}