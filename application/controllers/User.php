<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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

	  
	public function __construct()
	{
			parent::__construct();
			$this->load->model('User_model');
			$this->load->helper('url_helper');
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');
	}
	 

	public function _404()
	 {
         $this->load->view('404.php');
	 }

	public function index($ky='0')
	{

	 $all = $this->User_model->Check_user($ky);
	 
	 if(count($all)!=0)
	  {
		  $data['name'] = $all->name;
		  $data['image'] = $all->company_image;  
		  $data['key'] = $ky;  
		  $this->load->view('check',$data);
	  }
	  else
	  {
		 $this->_404();
		 
	  }
	} 

	

	public function ClientLogin()
	{
	   $UserEmail = $this->input->post('UserEmail');
	   $UserPassword = $this->input->post('UserPassword');
	   $key = $this->input->post('Key');

	  if(trim($UserEmail) !='' &&  trim($UserPassword) !='')
	  {
		$checklg = $this->User_model->logincheck($UserEmail,$UserPassword,$key);

		if(count($checklg)!=0)
		{
		  $logstatus = 'Success';
		  $userID  = $checklg->id;
		  $this->session->set_userdata('un_ce_id',$checklg->id);
		  $this->session->set_userdata('companyname',$checklg->name);
		  redirect(base_url().'index.php/user/home/'.$key);

		// echo $this->session->userdata('un_ce_id');;

		}
		else
		{
			$this->session->set_flashdata('error','Username and password is not matching..');
			$logstatus = 'Failed';
			$userID  = 0;
			redirect(base_url().'index.php/login/'.$key);
		}
       
	  }
	  else{
		$this->session->set_flashdata('error', 'please check username password');
	  }
    

	}


	public function home($ky)
	{
	   $user = $this->session->userdata('un_ce_id');
	  // echo $user; return;	  

	if($user)
	 {
	   $checklg = $this->User_model->collectuserinformation($user);
	   $data['companyname'] = $this->session->userdata('companyname');

     if($checklg)
	 {
		 $data['alldata'] = $checklg;
		 $data['ky'] = $ky;
	  }
	  else{
		$data['alldata'] = array();
		$data['ky'] = $ky;
	  }

	  $this->load->view('home',$data);
	}
	else{
		redirect(base_url().'index.php/login/'.$ky);
	}

    
	}

	public function logout($ky)
	{
		  $this->session->unset_userdata('un_ce_id');
		  $this->session->unset_userdata('companyname');
		  redirect(base_url().'index.php/login/'.$ky);
	}






   public function checkupload()
   {

	if($_FILES["filename"]["name"])
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["filename"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image

	if (move_uploaded_file($_FILES['filename']['tmp_name'], $target_file)) {
		echo "File is valid, and was successfully uploaded.\n";
	} else {
		echo "Possible file upload attack!\n";
	}

	}

	
   }

   public function checkupload_code()
    {
		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		//$config['file_name']  = 'saga';
		//$config['max_size']             = 100;
		//$config['max_width']            = 1024;
		//$config['max_height']           = 768;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('filename'))
		{
			echo $this->upload->display_errors();

				//$this->load->view('upload_form', $error);
		}
		else
		{
			 $this->upload->data();
			 echo $this->upload->data('file_name'); 

				//$this->load->view('upload_success', $data);
		}
	}
	 
	public function AddExpence()
	{
	  
		$TypeofExp = $this->input->post('TypeofExp');
		$ExpDate = $this->input->post('ExpDate');
		$PayeeName = $this->input->post('PayeeName');
		$TRNNumber = $this->input->post('TRNNumber');
		$ExpAmount = $this->input->post('ExpAmount');
		$TaxAmount = $this->input->post('TaxAmount');
		$CompanyCode = $this->input->post('CompanyCode');
		$CreatedBy = $this->input->post('CreatedBy');
		$ReceiverName = $this->input->post('ReceiverName');
		$Voucher = $this->input->post('Voucher');
		$ExpMode = $this->input->post('ExpMode');
		$CreatedDate = $this->input->post('CreatedDate');
        


		$File_Name = ''; 
		

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		//$config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('File_Name'))
		{
			//echo $this->upload->display_errors();

				//$this->load->view('upload_form', $error);
		}
		else
		{
			 $this->upload->data();
			 $File_Name = $this->upload->data('file_name'); 

				//$this->load->view('upload_success', $data);
		}

		$create = $this->User_model->updateexpence($TypeofExp,$ExpDate,$PayeeName,$TRNNumber,$ExpAmount,$TaxAmount,$CompanyCode,$CreatedBy,$ReceiverName,$Voucher,$ExpMode,$CreatedDate,$File_Name);

		if($create)
		{
          echo json_encode(array('Error'=> false ,'status' => 'create successfully' ));
		}else{
			echo json_encode(array('Error'=> false ,'status' => 'something went wrong'));
		}




	}


	public function Edit_Expence()
	{
	  
		$TypeofExp = $this->input->post('TypeofExp');
		$ExpDate = $this->input->post('ExpDate');
		$PayeeName = $this->input->post('PayeeName');
		$TRNNumber = $this->input->post('TRNNumber');
		$ExpAmount = $this->input->post('ExpAmount');
		$TaxAmount = $this->input->post('TaxAmount');
		$CompanyCode = $this->input->post('CompanyCode');
		$CreatedBy = $this->input->post('CreatedBy');
		$ReceiverName = $this->input->post('ReceiverName');
		$Voucher = $this->input->post('Voucher');
		$ExpMode = $this->input->post('ExpMode');
		$CreatedDate = $this->input->post('CreatedDate');
		

		$updateId = $this->input->post('ExpenceId');

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		//$config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('File_Name'))
		{
            $File_Name = ''; 
			//echo $this->upload->display_errors();

				//$this->load->view('upload_form', $error);
		}
		else
		{
			 $this->upload->data();
			 $File_Name = $this->upload->data('file_name'); 

				//$this->load->view('upload_success', $data);
		}

		$create = $this->User_model->addexpence($TypeofExp,$ExpDate,$PayeeName,$TRNNumber,$ExpAmount,$TaxAmount,$CompanyCode,$CreatedBy,$ReceiverName,$Voucher,$ExpMode,$CreatedDate,$File_Name);

		if($create)
		{
          echo json_encode(array('Error'=> false ,'status' => 'create successfully' ));
		}else{
			echo json_encode(array('Error'=> false ,'status' => 'something went wrong'));
		}
	}

}

?>