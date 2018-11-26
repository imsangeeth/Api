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

	  if(trim($UserEmail) !='' &&  trim($UserPassword) !='')
	  {
		$checklg = $this->User_model->logincheck($UserEmail,$UserPassword);

		if(count($checklg)!=0)
		{
		  $logstatus = 'Success';
		  $userID  = $checklg->id;
		  $this->session->set_userdata('un_ce_id',$checklg->id);
		  $this->session->set_userdata('companyname',$checklg->name);
		  redirect("https://ipocc.inaipi.me/gitex/crm/master.php");

		// echo $this->session->userdata('un_ce_id');;

		}
		else
		{
			$this->session->set_flashdata('error','Username and password is not matching..');
			$logstatus = 'Failed';
			$userID  = 0;
			redirect("https://ipocc.inaipi.me/gitex/crm/master.php");
		}
       
	  }
	  else{
		$this->session->set_flashdata('error', 'please check username password');
		redirect("http://localhost/lab/Emirateshospital/crm/login/login.php");
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
		  $name =  $request->firstName;
		  $lastName =  $request->lastname;
		  $Title = $request->Title;
		  $companyname =  $request->companyname;
          $mobilenumber =  $request->mobilenumber;
		  $dob =  $request->dob;
		  $Gender =  $request->Gender;
		  $Nationality =  $request->Nationality;
          $email =  $request->email;
		  $Source =  $request->Source;
		  $Type =  $request->Type;
		  $emiratesId = $request->emiratesId;
		  $insurancecard = $request->insurancecard;
		  $insurancecompany =  $request->insurancecompany;
		  $homeaddress =  $request->homeaddress;
		  $Companyaddress = $request->Companyaddress;
		 

		  $create = $this->User_model->Createcustomer($name,$lastName,$Title,$companyname,$mobilenumber,$dob,$Gender,$Nationality,$email,$Source,$Type,$emiratesId,$insurancecard,$insurancecompany,$homeaddress,$Companyaddress);

		  if($create)
		  {
			 echo json_encode(array('error' => false,'msg' => 'Sucessfully Created', 'bgclr' => '#4CAF50 !important'));
		  }	
		 else{

		   echo json_encode(array('error' => true,'msg' => 'Something Wrong', 'bgclr' => '#d2382d !important'));
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

	public function Updateservices()
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
		  $ticketid = $request->ticketid;

		  $insert = $this->User_model->Updateservices($ticketid,$customername,$Reason,$Description,$Subject,$Received,$priority,$assign,$department,$ticketstatus,$duedate,$phonenumber,$policynumber);
		
		  if($insert)
		   {
              echo json_encode(array('error' => false,'msg' => 'Updated Sucessfully', 'bgclr' => '#4CAF50 !important'));
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

	public function allcontacts($sort="2d242uyz",$name='Imp', $page=1,$order='asc')
	 {


		if($sort == 'name') { $sort = 'firstname'; }
		if($sort == 'PolicyNumber') { $sort = 'title'; }
		if($sort == 'InsuredAmount') { $sort = 'emirates_id'; }

		 $totalcontact = $this->User_model->totalcontact();
		 $allcontacts = $this->User_model->allcontacts($sort,$order,$page,$name);
		 $totalcount = count($allcontacts);
		 $totalcontact_ct = count($totalcontact);
		 $i = 0;
 
		 $pagestart = $page * 10;
		 $pageend = $pagestart - 10;

		
			$iserviceview = 0;
		 

		 foreach($allcontacts as $singlerow)
		  {
			  $iserviceview++;

              $name = $singlerow->firstname.' '.$singlerow->lastname;

			  $all[] = array('slno' => $iserviceview ,'userid' => $singlerow->id,'name' => $name,'insurancecard' => $singlerow->insurance_card_no,
			  'companyname' => $singlerow->companyname,'PolicyNumber' => $singlerow->title,'InsuredAmount' => $singlerow->emirates_id);

		  }

		  $json = array('total_count' => $totalcontact_ct,'items' => $all,'sort' => $sort,'order' =>$order,'page' => $page,'pageend' => $pageend,'pagestart' => $pagestart);

          echo json_encode($json);
	 }

	 public function allservices($sort="2d242uyz",$name='Imp',$assignsort='0', $page=1,$order='asc')
	 {
   
		// echo $sort . '-' . $order .'-'.$page.'-'.$name; return;
		
		if($this->session->userdata('rewqfdsas'))
		  {
			if($sort == 'CustomerName') { $sort = 'customer_name'; }  
			if($sort == 'slno') { $sort = 'id'; }  
		
			 $totalservice = $this->User_model->totalservices();
			 $allservices = $this->User_model->allservices($sort,$order,$page,$name,$assignsort);
	
			// echo $allservices; return;
			 $totalcount = count($allservices);
			 $totalservice_ct = count($totalservice);
	
			 $iserviceview = 0;
			 $pagestart = $page * 10;
			 $pageend = $pagestart - 10;
	
			 if($totalcount != 0){
			   
				foreach($allservices as $singlerow)
			  {
				  $iserviceview++; 
			    if($singlerow->ticketstatus == 'Open') { $ticketcss = 'badge-success'; } else if($singlerow->ticketstatus == 'Closed') { $ticketcss = 'badge-warning'; }
			   
				  $this->db->where('id',$singlerow->department);
				  $csp_office_department =  $this->db->get('csp_office_department')->row();
				  
				  if(count($csp_office_department)!=0)
				  {
					  $csp_office_department_val = $csp_office_department->name;
				  }else{
					  $csp_office_department_val = '';
				  }
			  
				  $this->db->where('id',$singlerow->assign);
				  $csp_department_user =  $this->db->get('csp_department_user')->row();
				  
				  if(count($csp_department_user)!=0)
				  {
					  $csp_department_user_val = $csp_department_user->name;
				  }else{
					  $csp_department_user_val = '';
				  }

				  $all[] = array('slno' =>$iserviceview,'ticket_id' => $singlerow->ticket_id,'customer_name' => $singlerow->customer_name,
				  'phonenumber' => $singlerow->phonenumber,'department' => $csp_office_department_val,'assign' =>$csp_department_user_val,
				  'createdate' => $singlerow->createtime,'ticketStatus' => $singlerow->ticketstatus,'ticketstyle' =>  $ticketcss,'type' => $singlerow->ticket_sub_type);
			  }
	
			 }else{
	
				$all = array();
			 }
			  $json = array('total_count' => $totalservice_ct,'items' => $all,'sort' => $sort,'order' =>$order,'page' => $page,'pageend' => $pageend,'pagestart' => $pagestart);
			  echo json_encode($json);

		}else{

			$json = array('error' => true,'message' => 'User Not Login');
		   echo json_encode($json);
	      }

		
	 }

	 public function af_services($sort="2d242uyz",$name='Imp',$assignsort='0', $page=1,$order='asc')
	 {
	   $all_services = $this->User_model->allservices($sort,$order,$page,$name,$assignsort);
		


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


	public function contactsingledetails($key)
	{

		$contactde = $this->User_model->contactsingledetails($key);

		if(count($contactde)!=0)
		{ 
				
			 $name = $contactde->firstname.' '.$contactde->lastname;
			 $dateofbirth = date('d-M-Y',strtotime($contactde->DOB));
			 
		   echo json_encode(array('firstname' =>$name,'email' => $contactde->email,'PolicyNumber' => $contactde->title,'companyname' => $contactde->companyname,
		'mobile_number' => $contactde->mobile_number,'DOB' => $dateofbirth,'gender' => $contactde->gender,'nationality' => 'India',
		'insurance_amount' => $contactde->emirates_id,'insurance_card_no' => $contactde->insurance_card_no,'insurance_company' => $contactde->insurance_company,
		'home_address' => $contactde->home_address,'company_address' => $contactde->company_address ));

		}else{

			echo json_encode(array('error' =>true ));
		}
	
	}

	 public function servicesdetailedview($key)
     {
		$check_services_details = $this->User_model->singledeatils($key);

		if(count($check_services_details)!=0)
		{
		   if($check_services_details->ticketstatus == 'Open') { $ticketcss = 'badge-success'; } else if($check_services_details->ticketstatus == 'Closed') { $ticketcss = 'badge-warning'; }
		   
		   if($check_services_details->createtime) { $createdate = date('d-M-Y',strtotime($check_services_details->createtime));   }
		   else {
			$createdate = '' ;
		   }

		   $duedate = date('d-M-Y',strtotime($check_services_details->duedate));	
		   echo json_encode(array('error' => false ,'msg'=> 'services loading','Name' =>$check_services_details->customer_name,
		   'reason' => $check_services_details->reasonforcall,'Description' =>	$check_services_details->description,'createDate' => $createdate ,
		   'duedate' => $duedate,'subject' => $check_services_details->subject ,'Received' => $check_services_details->received,'Priority' => $check_services_details->priority,
		   'assign' => $assign,'department' => $check_services_details->department,'ticketstatus' => $check_services_details->ticketstatus,'phonenumber' => $check_services_details->phonenumber,
		   'policynumber' => $check_services_details->policynumber,'btnstyle' => $ticketcss ));
		}else{

			echo json_encode(array('error' => true ,'msg'=> 'services not loading'));

		}

	 }


	 public function servicesdetailededit($key)
     {
		$check_services_details = $this->User_model->singledeatils($key);

		if(count($check_services_details)!=0)
		{
           if($check_services_details->assign == 1) { $assign = 'Ram'; }else if($check_services_details->assign == 2){ $assign = 'Sangeeth';}else{ $assign ='';}
		   if($check_services_details->ticketstatus == 'Open') { $ticketcss = 'badge-success'; } else if($check_services_details->ticketstatus == 'Closed') { $ticketcss = 'badge-warning'; }
		   
		   if($check_services_details->createtime) { $createdate = date('d-M-Y',strtotime($check_services_details->createtime));   }
		   else {
			$createdate = '' ;
		   }

		   $duedate = date('d-M-Y',strtotime($check_services_details->duedate));	
		   echo json_encode(array('error' => false ,'msg'=> 'services loading','Name' =>$check_services_details->customer_name,
		   'reason' => $check_services_details->reasonforcall,'Description' =>	$check_services_details->description,'createDate' => $createdate ,
		   'duedate' => $duedate,'subject' => $check_services_details->subject ,'Received' => $check_services_details->received,'Priority' => $check_services_details->priority,
		   'assign' => $check_services_details->assign,'department' => $check_services_details->department,'ticketstatus' => $check_services_details->ticketstatus,'phonenumber' => $check_services_details->phonenumber,
		   'policynumber' => $check_services_details->policynumber,'btnstyle' => $ticketcss ));
		}else{

			echo json_encode(array('error' => true ,'msg'=> 'services not loading'));

		}

	 }


	 public function taskcomments($key)
	 {
		$allthekeycomments = $this->User_model->taskcomments($key);

		if(count($allthekeycomments)!=0)
		{
			foreach($allthekeycomments as $comments)
		    {
                 $all[] = array('comments' => $comments->message,'name' => 'Administrator', 'time' =>$comments->comment_time );
			}
			
			echo json_encode($all);

		}else{
            $all = array();
			echo json_encode($all);
		}
	 }

	public function auditdeatils($key)
	{
		$allauditdeatils = $this->User_model->auditdeatils($key);

		if(count($allauditdeatils)!=0)
		{
			foreach($allauditdeatils as $audit)
		    {
                 $all[] = array('heading' => $audit->heading,'message' => $audit->message, 'time' =>$audit->generate_date );
			}
			
			echo json_encode($all);

		}else{
            $all = array();
			echo json_encode($all);
		}
	}


	 public function createtaskcomment()
	 {
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		if($request)
		{
			$comment = $request->comment;
			$taskid = $request->tskid;
			$addcomment = $this->User_model->addcomment($comment,$taskid);

			if($addcomment)
			{
				echo json_encode(array('error' => false ,'msg'=> 'sucess'));
			}else{
				echo json_encode(array('error' => true ,'msg'=> 'something wrong'));
			}
		}
		else{

            echo json_encode("nothing to show");
		}
	 }


	 public function user_check_details()
	 {
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		 if($request){

		$username = $request->UsernameVal;
		$password = $request->PasswordVal;

		$check = $this->User_model->checkUser($username,$password);

		if(count($check)!=0)
		{
			$this->session->set_userdata('rewqfdsas',$check->id);
			//session_start();
			//$_SESSION["favcolor"] = "green";
			echo json_encode(array('error' => false,'message' => 'Sucess'));
		}
		else{
			echo json_encode(array('error' => true,'message' => 'somthing wrong'));
		}
		    }else{
			
			echo json_encode(array('error' => true,'message' => 'somthing missing'));
		     }

	 }


	 public function native_login()
	 {
	
		//$postdata = file_get_contents("php://input");
		//$request = json_decode($postdata);

		// if($request){

		$username = 'ram@imp.com'; //$request->UsernameVal;
		$password =  '123'; //$request->PasswordVal;

		$check = $this->User_model->checkUser($username,$password);

		if(count($check)!=0)
		{
			$this->session->set_userdata('rewqfdsas',$check->id);
			//session_start();
			//$_SESSION["favcolor"] = "green";
			echo json_encode(array('error' => false,'message' => 'Sucess','id' =>$this->session->userdata('rewqfdsas')));
		}
		else{
			echo json_encode(array('error' => true,'message' => 'somthing wrong'));
		}
		   // }else{
			
			//echo json_encode(array('error' => true,'message' => 'somthing missing'));
		    

	 }


	 public function sessionid()
	 {
		//$this->load->library('session');
		echo $this->session->userdata('rewqfdsas');
	 }



	 public function chceklg()
	 {
		// echo $this->session->userdata('rewqfdsa'); return;
		//session_start();
		 if($this->session->userdata('rewqfdsas'))
		 {
             echo json_encode(array('status' => true));
		 }
		 else{
			echo json_encode(array('status' => false));
		 }
	 }
   
	 public function chceklghome()
	 {
		// echo $this->session->userdata('rewqfdsa'); return;
		//session_start();
		 if($this->session->userdata('rewqfdsas'))
		 {
             echo json_encode(array('error' => true, 'message' => 'sucess'));
		 }
		 else{
			echo json_encode(array('error' => false, 'message' => 'failed'));
		 }
	 }

	public function collectthe()
	{

	   header("Content-Type: text/plain");

       $topic = $this->input->post('topic');
	   $date = $this->input->post('date');
	   $time = $this->input->post('time');
	   $participate = $this->input->post('participate');
	   $details = $this->input->post('details');

	  
	//echo $details;

	  

	   //redirect($_SERVER['HTTP_REFERER']);

	}
	 public function sendmail()
	 {
		$topic = $this->input->post('topic');
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		$participate = $this->input->post('participate');
		$details = $this->input->post('details');

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.zoho.com',
			'smtp_port' => 465,
			'smtp_user' => 'sanju@avayadxbdemo.ae',
			'smtp_pass' => 'Avaya123$',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		
		// Set to, from, message, etc.

		$this->email->from('emirateshospital@gmail.com', 'emirateshospital');
		$this->email->to('imsangeeth.ng@gmail.com'); 
		//$this->email->cc('avaya.sanju@gmail.com'); 

        $this->email->subject($topic);
        $this->email->message('<table border="0" cellspacing="0" cellpadding="0" align="center" id="m_-7884055993486135906email_table" style="border-collapse:collapse"><tbody><tr><td id="m_-7884055993486135906email_content" style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;background:#ffffff"><table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse"><tbody><tr><td height="20" style="line-height:20px" colspan="3">&nbsp;</td></tr><tr><td height="1" colspan="3" style="line-height:1px"></td></tr><tr><td><table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:solid 1px white;margin:0 auto 5px auto;padding:3px 0;text-align:center;width:430px"><tbody><tr><td width="15px" style="width:15px"></td><td style="line-height:0px;width:400px;padding:0 0 15px 0"><table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse"><tbody><tr><td style="width:100%;text-align:left;height:33px"><img height="65" src="https://www.emirateshospital.ae/wp-content/uploads/2018/08/ehg-logo.png" style="border:0" class="CToWUd"></td></tr></tbody></table></td><td width="15px" style="width:15px"></td></tr><tr><td width="15px" style="width:15px"></td><td style="border-top:solid 1px #c8c8c8"></td><td width="15px" style="width:15px"></td></tr></tbody></table></td></tr><tr><td><table border="0" width="430" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin:0 auto 0 auto"><tbody><tr><td><table border="0" width="430px" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin:0 auto 0 auto;width:430px"><tbody><tr><td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td></tr><tr><td><table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse"><tbody><tr><td><table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse"><tbody><tr><td width="20" style="display:block;width:20px">&nbsp;&nbsp;&nbsp;</td><td><table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse"><tbody><tr><td><p style="padding:0;margin:10px 0 10px 0;color:#565a5c;font-size:18px">Hi, '.$topic.' on '.$time.' '.$date.'  </p><p style="padding:0;margin:10px 0 10px 0;color:#565a5c;font-size:18px">'.$details.'</p></td></tr><tr><td height="20" style="line-height:20px" colspan="1">&nbsp;</td></tr><tr><td><a href="http://scopia.avaya.com/scopia/entry/index.jsp style="color:#3b5998;text-decoration:none;display:block;width:370px" target="_blank"><table border="0" width="390" cellspacing="0" cellpadding="0" style="border-collapse:collapse"><tbody><tr><td style="border-collapse:collapse;border-radius:3px;text-align:center;display:block;border:solid 1px #009fdf;padding:10px 16px 14px 16px;margin:0 2px 0 auto;min-width:80px;background-color:#47a2ea"><a href="http://scopia.avaya.com/scopia/entry/index.jsp" style="color:#3b5998;text-decoration:none;display:block" target="_blank"><center><font size="3"><span style="font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#fdfdfd;font-size:16px;line-height:16px">Connect To Meeting</span></font></center></a></td></tr></tbody></table></a></td></tr></tbody></table></td><td width="20" style="display:block;width:20px">&nbsp;&nbsp;&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td height="10" style="line-height:10px" colspan="1">&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td>');  
		
		$result = $this->email->send();
		echo $this->email->print_debugger();

		//redirect("http://localhost/lab/Emirateshospital/crm/scopiaconference.php?sucess");
	 }

	 
	 
	 public function gmailmailsend()
	 {
		 
$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.zoho.com',
	'smtp_port' => 465,
	'smtp_user' => 'sanju@avayadxbdemo.ae',
	'smtp_pass' => 'Avaya123$',
    'mailtype'  => 'html', 
    'charset'   => 'iso-8859-1'
);
$this->load->library('email', $config);
$this->email->set_newline("\r\n");

// Set to, from, message, etc.

$this->email->from('imsangeeth.ng@gmail.com', 'saga');
$this->email->to('sangeethsaga@gmail.com'); 

$this->email->subject('Email Test');
$this->email->message('Testing the email class.');

$result = $this->email->send();
echo $this->email->print_debugger();
	 }

	 public function testoracle()
	 {
		 
	 }

//Create New Survey Sangeeth 10/25/2018

public function newsurvey()
 {
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	
	$surveyname = $request->surveyname;
	$surveytype = $request->surveytype;

	$create = $this->User_model->createsurvey($surveyname,$surveytype);
	
	if($create)
	{
		foreach($request->ans1array as $row)
		{
			//echo $row->quest.'<br>';
			$createquestion = $this->User_model->insertquestion($row->quest,$create,$surveytype);
			foreach($row->answe as $rowa)
			{
			 // echo $rowa.'<br>';
			  $createnaswer = $this->User_model->insertanswer($rowa,$createquestion,$create);
			}
		}
	}else{


	}
	 
	 echo json_encode($create);

	//print_r($request->all);
    //echo count($request->ans1array);
 }



 //afnic
 
 public function office_department()
 {
	 $office_department = $this->User_model->office_department();

	 foreach($office_department as $office)
      {
         $all[] = array('id' => $office->id,'department' => $office->name);         
	  }

	 echo json_encode($all);
 }


 public function office_department_user($ky)
 {
	 $office_department_user = $this->User_model->office_department_user($ky);

	 foreach($office_department_user as $office)
      {
         $all[] = array('id' => $office->id,'department' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function officelocation()
 {
	 $officelocation = $this->User_model->officelocation();

	 foreach($officelocation as $office)
      {
         $all[] = array('locId' => $office->id,'name' => $office->name);         
	  }

	 echo json_encode($all);

 }

 public function officebranches($ky)
 {
	 $officebranches = $this->User_model->officebranches($ky);

	 foreach($officebranches as $office)
      {
         $all[] = array('branId'=>$office->id, 'name' => $office->branch_name);         
	  }

	 echo json_encode($all);

 }


 public function officebranchaddress($ky)
 {
	 $officebranchaddress = $this->User_model->officebranchaddress($ky);

	 foreach($officebranchaddress as $office)
      {
         $all[] = array('addressId'=>$office->id, 'name' => $office->branch_address);         
	  }

	 echo json_encode($all);

 }



 public function allinbound()
 {
	 $allinbound = $this->User_model->allinbound();

	 foreach($allinbound as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function cspinboundphase2($ky)
 {
	 $cspinboundphase2 = $this->User_model->cspinboundphase2($ky);

	 foreach($cspinboundphase2 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function cspinboundphase3($ky)
 {
	 $cspinboundphase3 = $this->User_model->cspinboundphase3($ky);

	 foreach($cspinboundphase3 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function cspinboundphase4($ky)
 {
	 $cspinboundphase4 = $this->User_model->cspinboundphase4($ky);

	 foreach($cspinboundphase4 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }


 public function allCopType()
 {
	 $onChangeCopType = $this->User_model->onChangeCopType();

	 foreach($onChangeCopType as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }


 public function cop_phase2($ky)
 {
	 $cop_phase2 = $this->User_model->cop_phase2($ky);

	 foreach($cop_phase2 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function cop_phase3($ky)
 {
	 $cop_phase3 = $this->User_model->cop_phase3($ky);

	 foreach($cop_phase3 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function cop_phase4($ky)
 {
	 $cop_phase4 = $this->User_model->cop_phase4($ky);

	 foreach($cop_phase4 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }


 public function cop_phase5($ky)
 {
	 $cop_phase5 = $this->User_model->cop_phase5($ky);

	 if(count($cop_phase5)!=0){

		foreach($cop_phase5 as $office)
		{
		   $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
		}
	 }else{

		$all = array();
	 }

	

	 echo json_encode($all);
 }




 public function insuranctype()
 {
	 $insuranctype = $this->User_model->insuranctype();

	 foreach($insuranctype as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->insurance_type);         
	  }

	 echo json_encode($all);

 }


 public function insurance_phase2($ky)
 {
	 $insurance_phase2 = $this->User_model->insurance_phase2($ky);

	 foreach($insurance_phase2 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->sub_type_name);         
	  }

	 echo json_encode($all);
 }

 public function insurance_phase3($ky)
 {
	 $insurance_phase3 = $this->User_model->insurance_phase3($ky);

	 foreach($insurance_phase3 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function insurance_phase4($ky)
 {
	 $insurance_phase4 = $this->User_model->insurance_phase4($ky);

	 foreach($insurance_phase4 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function insurance_phase5($ky)
 {
	 $insurance_phase5 = $this->User_model->insurance_phase5($ky);

	 foreach($insurance_phase5 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function insurance_phase6($ky)
 {
	 $insurance_phase6 = $this->User_model->insurance_phase6($ky);

	 foreach($insurance_phase6 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function insurance_phase7($ky)
 {
	 $insurance_phase7 = $this->User_model->insurance_phase7($ky);

	 foreach($insurance_phase7 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }


 public function insurance_phase8($ky)
 {
	 $insurance_phase8 = $this->User_model->insurance_phase8($ky);

	 foreach($insurance_phase8 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }


 public function insurance_phase9($ky)
 {
	 $insurance_phase9 = $this->User_model->insurance_phase9($ky);

	 foreach($insurance_phase9 as $office)
      {
         $all[] = array('typeID'=>$office->id, 'name' => $office->name);         
	  }

	 echo json_encode($all);
 }

 public function createservice_ind()
  {
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if($request)
	{
	$Insurancetype = $request->Insurancetype;
	$Individual_two = $request->Individual_two;
	$Individual_three = $request->Individual_three;
	$Individual_four = $request->Individual_four;
	$Individual_five = $request->Individual_five;
	$Individual_six = $request->Individual_six;
	$Individual_sevan = $request->Individual_sevan;
	$Individual_eight = $request->Individual_eight;
	$Individual_nine = $request->Individual_nine;
	$ser_assign = $request->ser_assign;
	$ser_department = $request->ser_department;
	$Remarks = $request->Remarks;
	$ser_comment = $request->ser_comment;

	$type = 'Individual';
	
   $insert_su = $this->User_model->createservice_ind($Insurancetype,$Individual_two,$Individual_three,$Individual_four,
   $Individual_five,$Individual_six,$Individual_sevan,$Individual_eight,$Individual_nine,$ser_assign,$ser_department,$Remarks);

   if($insert_su){

	$insert_ticket = $this->User_model->create_services_new($ser_department,$ser_assign,$type,$insert_su,$ser_comment);
	echo json_encode(array('error' => false, 'msg' => 'insert successfully'));
	 
   }else{
	echo json_encode(array('error' => true, 'msg' => 'something wrong'));
   }

    }else{
		echo json_encode(array('error' => true, 'msg' => 'something wrong'));
	   }


  }

  public function createservice_inbound()
  {
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if($request)
	{
	$inboundtype = $request->inboundtype;
	$inboundtype_two = $request->inboundtype_two;
	$inboundtype_three = $request->inboundtype_three;
	$inboundtype_four = $request->inboundtype_four;
	$inboundtype_assign = $request->inboundtype_assign;
	$inboundtype_department = $request->inboundtype_department;
	$inboundtypeRemarks = $request->inboundtypeRemarks;
	$inboundtypecomment = $request->inboundtypecomment;

	$type = 'inbound';

   $insert_su = $this->User_model->createservice_inbound($inboundtype,$inboundtype_two,$inboundtype_three,$inboundtype_four,
   $inboundtype_assign,$inboundtype_department,$inboundtypeRemarks,$inboundtypecomment);

   if($insert_su){
	 $insert_ticket = $this->User_model->create_services_new($inboundtype_department,$inboundtype_assign,$type,$insert_su,$inboundtypecomment);
     echo json_encode(array('error' => false, 'msg' => 'insert successfully'));
   }else{
	echo json_encode(array('error' => true, 'msg' => 'something wrong'));
   }

    }else{
		echo json_encode(array('error' => true, 'msg' => 'something wrong'));
	   }
  }

  public function createservice_cop()
  {
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	if($request)
	{
	$Corporatetype = $request->Corporatetype;
	$Corporate_two = $request->Corporate_two;
	$Corporate_three = $request->Corporate_three;
	$Corporate_four = $request->Corporate_four;
	$Corporate_five = $request->Corporate_five;
	$Corporate_assign = $request->Corporate_assign;
	$Corporate_department = $request->Corporate_department;
	$CorporateRemarks = $request->CorporateRemarks;
	$Corporatecomment = $request->Corporatecomment;

	$type = 'corporate';

   $insert_su = $this->User_model->createservice_cop($Corporatetype,$Corporate_two,$Corporate_three,$Corporate_four,
   $Corporate_five,$Corporate_assign,$Corporate_department,$CorporateRemarks,$Corporatecomment);

   if($insert_su){
	 $insert_ticket = $this->User_model->create_services_new($Corporate_department,$Corporate_assign,$type,$insert_su,$Corporatecomment);
     echo json_encode(array('error' => false, 'msg' => 'insert successfully'));
   }else{
	echo json_encode(array('error' => true, 'msg' => 'something wrong'));
   }

    }else{
		echo json_encode(array('error' => true, 'msg' => 'something wrong'));
	   }
  }

  public function createservice_cop_view($key)
  {

	//$all_cop = $this->User_model->createservice_cop_view($ky);

	$check_services_details = $this->User_model->singledeatils($key);

	if(count($check_services_details)!=0)
	  {
		   if($check_services_details->ticketstatus == 'Open') { $ticketcss = 'badge-success'; } else if($check_services_details->ticketstatus == 'Closed') { $ticketcss = 'badge-warning'; }
		   
		   if($check_services_details->createtime) { $createdate = date('d-M-Y',strtotime($check_services_details->createtime));   }
		   else {
			$createdate = '' ;
			  }
			  
	if($check_services_details->ticket_sub_type == 'corporate')	
    	{
			$this->db->where('id',$check_services_details->ticket_sub_id);
			$all =  $this->db->get('csp_af_services_cop')->row();
			
	$this->db->where('id',$all->csp_corporate_type);
	$csp_corporate_type =  $this->db->get('csp_corporate_type')->row();

	$csp_corporate_type_val = $csp_corporate_type->name;

	$this->db->where('id',$all->csp_corporate_phase1);
	$csp_corporate_phase1 =  $this->db->get('csp_corporate_phase1')->row();

	$csp_corporate_phase1_val = $csp_corporate_phase1->name;

	$this->db->where('id',$all->csp_corporate_phase2);
	$csp_corporate_phase2 =  $this->db->get('csp_corporate_phase2')->row();

	$csp_corporate_phase2_val = $csp_corporate_phase2->name;

	$this->db->where('id',$all->csp_corporate_phase3);
	$csp_corporate_phase3 =  $this->db->get('csp_corporate_phase3')->row();

	$csp_corporate_phase3_val = $csp_corporate_phase3->name;

	$this->db->where('id',$all->csp_corporate_phase4);
	$csp_corporate_phase4 =  $this->db->get('csp_corporate_phase4')->row();
	
	if(count($csp_corporate_phase4)!=0)
	{
		$csp_corporate_phase4_val = $csp_corporate_phase4->name;
	}else{
		$csp_corporate_phase4_val = '';
	}

	$this->db->where('id',$all->csp_office_department);
	$csp_office_department =  $this->db->get('csp_office_department')->row();
	
	if(count($csp_office_department)!=0)
	{
		$csp_office_department_val = $csp_office_department->name;
	}else{
		$csp_office_department_val = '';
	}

	$this->db->where('id',$all->csp_department_user);
	$csp_department_user =  $this->db->get('csp_department_user')->row();
	
	if(count($csp_department_user)!=0)
	{
		$csp_department_user_val = $csp_department_user->name;
	}else{
		$csp_department_user_val = 'Nil';
	}


	//echo json_encode(array('error' => false ,'msg'=> 'services loading','Name' =>$check_services_details->customer_name,
	//'reason' => $check_services_details->reasonforcall,'Description' =>	$check_services_details->description,'createDate' => $createdate ,
	//'duedate' => $duedate,'subject' => $check_services_details->subject ,'Received' => $check_services_details->received,'Priority' => $check_services_details->priority,
	//'assign' => $assign,'department' => $check_services_details->department,'ticketstatus' => $check_services_details->ticketstatus,'phonenumber' => $check_services_details->phonenumber,
	//'policynumber' => $check_services_details->policynumber,'btnstyle' => $ticketcss ));
	
	$all = array('error' => false ,'msg'=> 'services loading','Name' =>$check_services_details->customer_name,'csp_corporate_type' => $csp_corporate_type_val,
	'csp_corporate_phase1' => $csp_corporate_phase1_val,'csp_corporate_phase2' => $csp_corporate_phase2_val,'createDate' => $createdate,'ticketstatus' => $check_services_details->ticketstatus,
	'csp_corporate_phase3' => $csp_corporate_phase3_val,'csp_corporate_phase4' => $csp_corporate_phase4_val,'remarks' => $all->remarks,'csp_department_user' => $csp_department_user_val,
	'csp_office_department' => $csp_office_department_val,'type' => $check_services_details->ticket_sub_type,'btnstyle' => $ticketcss,'phonenumber' => $check_services_details->phonenumber);

	echo json_encode($all);
		
		}
		else if($check_services_details->ticket_sub_type == 'Individual')
		{
			$this->db->where('id',$check_services_details->ticket_sub_id);
			$all =  $this->db->get('csp_af_services_ind')->row();

			$this->db->where('id',$all->csp_insurance_type);
			$csp_insurance_type =  $this->db->get('csp_insurance_type')->row();
			
			if(count($csp_insurance_type)!=0)
	         {
	     	   $csp_insurance_type_val= $csp_insurance_type->insurance_type;
	         }else{
		       $csp_insurance_type_val = 'Nil';
			 }

			 $this->db->where('id',$all->csp_insurance_phase2);
			 $csp_insurance_phase2 =  $this->db->get('csp_insurance_phase2')->row();
			
			if(count($csp_insurance_phase2)!=0)
	         {
				$csp_insurance_phase2_val= $csp_insurance_phase2->sub_type_name;
				
	         }else{
			   $csp_insurance_phase2_val = 'Nil';
			   
			 }

			 $this->db->where('id',$all->csp_insurance_phase3);
			 $csp_insurance_phase3 =  $this->db->get('csp_insurance_phase3')->row();
			
			if(count($csp_insurance_phase3)!=0)
	         {
				$csp_insurance_phase3_val= $csp_insurance_phase3->name;
				
	         }else{
			   $csp_insurance_phase3_val = 'Nil';
			 }


			 $this->db->where('id',$all->phase_category1);
			 $phase_category1 =  $this->db->get('phase_category1')->row();
			
			if(count($phase_category1)!=0)
	         {
				$phase_category1_val= $phase_category1->name;
				
	         }else{
			    $phase_category1_val = 'Nil';
			 }


			 $this->db->where('id',$all->phase_category2);
			 $phase_category2 =  $this->db->get('phase_category2')->row();
			
			if(count($phase_category2)!=0)
	         {
				$phase_category2_val= $phase_category2->name;
				
	         }else{
			    $phase_category2_val = 'Nil';
			 }


			 $this->db->where('id',$all->phase_category3);
			 $phase_category3 =  $this->db->get('phase_category3')->row();
			
			if(count($phase_category3)!=0)
	         {
				$phase_category3_val= $phase_category3->name;
				
	         }else{
			    $phase_category3_val = 'Nil';
			 }

			 $this->db->where('id',$all->phase_category4);
			 $phase_category4 =  $this->db->get('phase_category4')->row();
			
			if(count($phase_category4)!=0)
	         {
				$phase_category4_val= $phase_category4->name;
				
	         }else{
			    $phase_category4_val = 'Nil';
			 }

			 $this->db->where('id',$all->phase_category5);
			 $phase_category5 =  $this->db->get('phase_category5')->row();
			
			if(count($phase_category5)!=0)
	         {
				$phase_category5_val= $phase_category5->name;
				
	         }else{
			    $phase_category5_val = 'Nil';
			 }

			 $this->db->where('id',$all->phase_category6);
			 $phase_category6 =  $this->db->get('phase_category6')->row();
			
			if(count($phase_category6)!=0)
	         {
				$phase_category6_val= $phase_category6->name;
				
	         }else{
			    $phase_category6_val = 'Nil';
			 }

			 $this->db->where('id',$all->csp_office_department);
			 $csp_office_department =  $this->db->get('csp_office_department')->row();
			
			if(count($csp_office_department)!=0)
	         {
				$csp_office_department_val= $csp_office_department->name;
				
	         }else{
			    $csp_office_department_val = 'Nil';
			 }

			 $this->db->where('id',$all->csp_department_user);
			 $csp_department_user =  $this->db->get('csp_department_user')->row();
			
			if(count($csp_department_user)!=0)
	         {
				$csp_department_user_val= $csp_department_user->name;
				
	         }else{
			    $csp_department_user_val = 'Nil';
			 }



			 $all = array('error' => false ,'msg'=> 'services loading','Name' =>$check_services_details->customer_name,
			 'csp_insurance_type_val' => $csp_insurance_type_val,'csp_insurance_phase2_val' => $csp_insurance_phase2_val,
			 'csp_insurance_phase3_val' => $csp_insurance_phase3_val,'phase_category1' => $phase_category1_val,'phase_category2' => $phase_category2_val,
			 'phase_category3' => $phase_category3_val,'phase_category4' => $phase_category4_val,'phase_category5' => $phase_category5_val,'phase_category6' => $phase_category6_val,
			 'createDate' => $createdate,'ticketstatus' => $check_services_details->ticketstatus,'remarks' => $all->remarks,
			 'csp_department_user' => $csp_department_user_val,'csp_office_department' => $csp_office_department_val,
			 'type' => $check_services_details->ticket_sub_type,'btnstyle' => $ticketcss,'phonenumber' => $check_services_details->phonenumber);

	          echo json_encode($all);


		}	   
		



		
      }


  }


}

?>