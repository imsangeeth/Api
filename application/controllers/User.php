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
			$this->load->library('encryption');
						//error_reporting(0);
	}
	 

	public function _404()
	 {
         $this->load->view('404.php');
	 }

	public function index()
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


	//start from here
	
	public function createcustomer()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		if($request)
		{ 
		  $name =  $request->name;
		  $lastName =  $request->lastName;
		  $DOB =  $request->DOB;
          $nationality =  $request->nationality;
		  $emiratesid =  $request->emiratesid;
		  $email =  $request->email;
		  $insurance =  $request->insurance;
          $insurancecompany =  $request->insurancecompany;
		  $homeaddress =  $request->homeaddress;
		  $companyaddress =  $request->companyaddress;
		  $mobilenumber = $request->mobilenumber;
		  $gender = $request->gender;

          $create = $this->User_model->Createcustomer($name,$lastName,$DOB,$nationality,$emiratesid,$email,$insurance,$insurancecompany,$homeaddress,$companyaddress,$mobilenumber,$gender);

		 if($create)
		 {
            echo json_encode('sucess');
		 }else
		 {
			echo json_encode('Failed');
		 }


		}
		
		
	}

	public function createcontact()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		if($request)
		{ 

		  $destinationNumbVal =  $request->destinationNumbVal;
		  $DialerVal =  $request->DialerVal;
		  $PrioVal =  $request->PrioVal;
          $StartTimeVal =  $request->StartTimeVal;
		  $StartDtval =  $request->StartDtval;
		  $StopTimeVal =  $request->StopTimeVal;
		  $StopDateVal =  $request->StopDateVal;
		  $CallTagVal =  $request->CallTagVal;
		  $CallTagtrackVal =  $request->CallTagtrackVal;
		

		  $insert = $this->User_model->createcontact($destinationNumbVal,$DialerVal,$PrioVal,$StartTimeVal,$StartDtval,$StopDateVal,$StopTimeVal,$CallTagVal,$CallTagtrackVal);
		
		  if($insert)
		   {
              echo json_encode(array('error' => false,'msg' => 'Sucessfully Created', 'bgclr' => '#4CAF50 !important'));
		   }	
		  else{

			echo json_encode(array('error' => true,'msg' => 'Something Wrong', 'bgclr' => '#d2382d !important'));
		  }
  
		}

	}



	public function createservices()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		if($request)
		{ 

		  $customername =  $request->customername;
		  $Reason =  $request->Reason;
		  $Description =  $request->Description;
          $Subject =  $request->Subject;
		  $Received =  $request->Received;
		  $priority =  $request->priority;
		  $assign =  $request->assign;
		  $department =  $request->department;
          $ticketstatus =  $request->ticketstatus;
		  $duedate =  $request->duedate;
		  $phonenumber =  $request->phonenumber;
		  $policynumber =  $request->policynumber;

		  $insert = $this->User_model->createservices($customername,$Reason,$Description,$Subject,$Received,$priority,$assign,$department,$ticketstatus,$duedate,$phonenumber,$policynumber);
		
		  if($insert)
		   {
              echo json_encode(array('error' => false,'msg' => 'Sucessfully Created', 'bgclr' => '#4CAF50 !important'));
		   }	
		  else{

			echo json_encode(array('error' => true,'msg' => 'Something Wrong', 'bgclr' => '#d2382d !important'));
		  }

		}
	}


    public function createcampaign()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		if($request)
		{ 

		  $Campaignname =  $request->Campaignname;
		  $Mode =  $request->Mode;
		  $Scheduletime =  $request->Scheduletime;
          $Campaigndate =  $request->Campaigndate;
		  $Scheduledate =  $request->Scheduledate;
		  $serviceprovider =  $request->serviceprovider;
		  $Campaigndes =  $request->Campaigndes;
		  $cmmpid = time().rand(1000,10000);

		  $insert = $this->User_model->createcampaign($cmmpid,$Campaignname,$Mode,$Scheduletime,$Campaigndate,$Scheduledate,$serviceprovider,$Campaigndes);
		
		  if($insert)
		   {
              echo json_encode(array('error' => false,'msg' => 'Sucessfully Created', 'bgclr' => '#4CAF50 !important'));
		   }	
		  else{

			echo json_encode(array('error' => true,'msg' => 'Something Wrong', 'bgclr' => '#d2382d !important'));
		  }

		}


	}






	public function viewcustomer()
	{
		$all_customer = $this->User_model->customer_details();
	   
		foreach($all_customer as $singlerow)
		  {
			  $all[] = array('id' => $singlerow->id,'firstname' => $singlerow->firstname,'email' => $singlerow->email,'phonenumber' => $singlerow->mobile_number);

		  }

		  $json = array('total_count' => '30','items' => $all);

      echo json_encode($json);

	}

	public function allcontacts($sort="2d242uyz",$order='asc',$page=1)
	 {

		 $totalcontact = $this->User_model->totalcontact();
		 $allcontacts = $this->User_model->allcontacts($sort,$order,$page);
		 $totalcount = count($allcontacts);
		 $totalcontact_ct = count($totalcontact);
		 $i = 0;
 
		 $pagestart = $page * 10;
		 $pageend = $pagestart - 10;

		 foreach($allcontacts as $singlerow)
		  {
			  $i++;
			  $all[] = array('userid' => $singlerow->id,'destinationumber' => $singlerow->destinationumber,'dialer' => $singlerow->dialer,'startTime' => $singlerow->startTime,'StartDate' => $singlerow->StartDate,'StopTime' => $singlerow->StopTime,'StopDate' => $singlerow->StopDate,'Prio' => $singlerow->Prio,'CallTag_name' =>$singlerow->CallTag_name,'CallTag_Trackid' => $singlerow->CallTag_Trackid );

		  }

		  $json = array('total_count' => $totalcontact_ct,'items' => $all,'sort' => $sort,'order' =>$order,'page' => $page,'pageend' => $pageend,'pagestart' => $pagestart);

          echo json_encode($json);
	 }

	 public function allservices($sort="2d242uyz",$order='asc',$page=1)
	 {
		if($sort == 'CustomerName') { $sort = 'customer_name'; }  
		 $totalservice = $this->User_model->totalservices();
		 $allservices = $this->User_model->allservices($sort,$order,$page);
		 $totalcount = count($allservices);
		 $totalservice_ct = count($totalservice);
		 $i = 0;
		 
        

		 $pagestart = $page * 10;
		 $pageend = $pagestart - 10;

		 foreach($allservices as $singlerow)
		  {
			  $i++;
			  $all[] = array('ticket_id' => $singlerow->ticket_id,'customer_name' => $singlerow->customer_name,'phonenumber' => $singlerow->phonenumber,'department' => $singlerow->department,'assign' => $singlerow->assign,'duedate' => $singlerow->duedate);

		  }

		  $json = array('total_count' => $totalservice_ct,'items' => $all,'sort' => $sort,'order' =>$order,'page' => $page,'pageend' => $pageend,'pagestart' => $pagestart);

          echo json_encode($json);
	 }


	 public function allcampaign($sort="342werd34",$order='asc',$page=1)
	 {
		if($sort == 'Campaignname') { $sort = 'campaign_name'; } 
		if($sort == 'ScheduleDate') { $sort = 'schedule_date'; }  
		if($sort == 'CampaignDate') { $sort = 'campaign_date'; }  
		if($sort == 'ServiceProvider') { $sort = 'service_provider'; }   
 

		 $totalcampaign = $this->User_model->totalcampaign();
		 $allcampaign = $this->User_model->allcampaign($sort,$order,$page);
		 $totalcount = count($allcampaign);
		 $totalservice_ct = count($totalcampaign);
		 $i = 0;
		 
		 $pagestart = $page * 10;
		 $pageend = $pagestart - 10;

		 foreach($allcampaign as $singlerow)
		  {
			  $i++;
			  $all[] = array('Campaignname' => $singlerow->campaign_name,'Mode' => $singlerow->mode,'ScheduleTime' => $singlerow->schedule_time,'ScheduleDate' => $singlerow->schedule_date,'CampaignDate' => $singlerow->campaign_date,'ServiceProvider' => $singlerow->service_provider);

		  }

		  $json = array('total_count' => $totalservice_ct,'items' => $all,'sort' => $sort,'order' =>$order,'page' => $page,'pageend' => $pageend,'pagestart' => $pagestart);

          echo json_encode($json);
	 }


	 public function editcontact($id=0)
	 {
		
	   $singlerow = $this->User_model->editcontact($id);
	   $all = '';

	   if($singlerow)
	     {
			//$StartDate = date('m/d/Y',strtotime($singlerow->StartDate));

			$all = array('userid' => $singlerow->id,'DestinatioNumber' => $singlerow->destinationumber,'dialer' => $singlerow->dialer,'StartTime' => $singlerow->startTime,'StartDate' => $singlerow->StartDate,'StopTime' => $singlerow->StopTime,'StopDate' => $singlerow->StopDate,'Prio' => $singlerow->Prio,'CallTag_name' =>$singlerow->CallTag_name,'CallTagTrackid' => $singlerow->CallTag_Trackid );
		 }
		 
      echo json_encode($all);
	 }
	 
	 public function updatecontact()
	 {
		 
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		if($request)
		{ 

		  $destinationNumbVal =  $request->destinationNumbVal;
		  $DialerVal =  $request->DialerVal;
		  $PrioVal =  $request->PrioVal;
          $StartTimeVal =  $request->StartTimeVal;
		  $StartDtval =  $request->StartDtval;
		  $StopTimeVal =  $request->StopTimeVal;
		  $StopDateVal =  $request->StopDateVal;
		  $CallTagVal =  $request->CallTagVal;
		  $CallTagtrackVal =  $request->CallTagtrackVal;
		  $contactId = $request->contactIdval;

		  $insert = $this->User_model->updatecontact($destinationNumbVal,$DialerVal,$PrioVal,$StartTimeVal,$StartDtval,$StopDateVal,$StopTimeVal,$CallTagVal,$CallTagtrackVal,$contactId);
		
		  if($insert)
		   {
              echo json_encode(array('error' => false,'msg' => 'Sucessfully Updated', 'bgclr' => '#4CAF50 !important'));
		   }	
		  else{

			echo json_encode(array('error' => true,'msg' => 'Something Wrong', 'bgclr' => '#d2382d !important'));
		  }
  
		}

	 }



}

?>