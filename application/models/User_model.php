<?php
class User_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
               
        }


       public function fetch_content()
       {
          return $this->db->query("SELECT * FROM tbl_User_Master")->result();
       }

       public function logincheck($user,$pass,$key)
       {
          $this->db->where('username',$user);
          $this->db->where('password',$pass);
          $this->db->where('admin_id',$key);
          return $this->db->get('company')->row();
       }

       public function Check_user($ky)
        {
          $this->db->where('admin_id',$ky);
          return $this->db->get('company')->row();
        }

       public function collectuserinformation($ky)
       {
         $this->db->where('company_id',$ky);
         return $this->db->get('call_user_details')->result();
       }

       public function addexpence($TypeofExp,$ExpDate,$PayeeName,$TRNNumber,$ExpAmount,$TaxAmount,$CompanyCode,$CreatedBy,$ReceiverName,$Voucher,$ExpMode,$CreatedDate,$File_Name)
       {
                  $TypeofExp ="'".$TypeofExp."'";
                  $ExpDate ="'".$ExpDate."'";
                  $PayeeName ="'".$PayeeName."'";
                  $TRNNumber ="'".$TRNNumber."'";
                  $ExpAmount ="'".$ExpAmount."'";
                  $TaxAmount ="'".$TaxAmount."'";
                  $CompanyCode ="'".$CompanyCode."'";
                  $CreatedBy ="'".$CreatedBy."'";
                  $ReceiverName ="'".$ReceiverName."'";
                  $Voucher ="'".$Voucher."'";
                  $ExpMode ="'".$ExpMode."'";
                  $CreatedDate ="'".$CreatedDate."'";
                  $File_Name ="'".$File_Name."'";
                  
           return $this->db->query("INSERT INTO TaxExpense (TypeofExp,ExpDate,PayeeName,TRNNumber,ExpAmount,TaxAmount,CompanyCode,CreatedBy,ReceiverName,Voucher,ExpMode,CreatedDate,File_Name) VALUES ($TypeofExp,$ExpDate,$PayeeName,$TRNNumber,$ExpAmount,$TaxAmount,$CompanyCode,$CreatedBy,$ReceiverName,$Voucher,$ExpMode,$CreatedDate,$File_Name)");
       }

       public function updateexpence($TypeofExp,$ExpDate,$PayeeName,$TRNNumber,$ExpAmount,$TaxAmount,$CompanyCode,$CreatedBy,$ReceiverName,$Voucher,$ExpMode,$CreatedDate)
       {

        $TypeofExp ="'".$TypeofExp."'";
        $ExpDate ="'".$ExpDate."'";
        $PayeeName ="'".$PayeeName."'";
        $TRNNumber ="'".$TRNNumber."'";
        $ExpAmount ="'".$ExpAmount."'";
        $TaxAmount ="'".$TaxAmount."'";
        $CompanyCode ="'".$CompanyCode."'";
        $CreatedBy ="'".$CreatedBy."'";
        $ReceiverName ="'".$ReceiverName."'";
        $Voucher ="'".$Voucher."'";
        $ExpMode ="'".$ExpMode."'";
        $CreatedDate ="'".$CreatedDate."'";
        $File_Name ="'".$File_Name."'";
        
       return $this->db->query("update TaxExpense set TypeofExp,ExpDate,PayeeName,TRNNumber,ExpAmount,TaxAmount,CompanyCode,CreatedBy,ReceiverName,Voucher,ExpMode,CreatedDate,File_Name) VALUES ($TypeofExp,$ExpDate,$PayeeName,$TRNNumber,$ExpAmount,$TaxAmount,$CompanyCode,$CreatedBy,$ReceiverName,$Voucher,$ExpMode,$CreatedDate,$File_Name)");


       }

       //start here
        
       public function customer_details()
       {
         //$this->db->where('admin_id',$ky);
         return $this->db->get('csp_createcustomer')->result();
       }
      
       public function allcontacts($sort,$order,$page)
       {
        $page = $page - 1;
        $pagestart = $page * 10;
        $pageend = $pagestart - 10;

        if($sort == "2d242uyz" || $sort == "created")
        {
          return $this->db->get('csp_createcontact',10,$pagestart)->result();
        }
        else{
          $this->db->order_by($sort,$order);
          return $this->db->get('csp_createcontact',10,$pagestart)->result();
        }
          
             //  $this->db->order_by($sort,$order);
       }


       public function allservices($sort,$order,$page,$name,$assignsort)
       {
        $page = $page - 1;
        $pagestart = $page * 10;
        $pageend = $pagestart - 10;

        if($name !='Imp')
        {
          $this->db->like('ticket_id',$name);
          $this->db->or_like('customer_name',$name);
          
          $this->db->or_like('Duedate',$name);	
          return $this->db->get('csp_services',10,$pagestart)->result();
        }
        else if($assignsort !='0')
        {
          $this->db->or_like('assign',$assignsort);	
          return $this->db->get('csp_services',10,$pagestart)->result();
        }
        else if($sort == "2d242uyz" || $sort == "created")
        {        
          $this->db->order_by('id','desc');
          return $this->db->get('csp_services',10,$pagestart)->result();
        }
        
        else{
          $this->db->order_by($sort,$order);
          return $this->db->get('csp_services',10,$pagestart)->result();
        }
          
             //  $this->db->order_by($sort,$order);
       }


       public function allcampaign($sort,$order,$page)
       {
        $page = $page - 1;
        $pagestart = $page * 10;
        $pageend = $pagestart - 10;

        if($sort == "342werd34" || $sort == "created")
        {
          return $this->db->get('csp_campaign',10,$pagestart)->result();
        }
        else{
          $this->db->order_by($sort,$order);
          return $this->db->get('csp_campaign',10,$pagestart)->result();
        }
          
             //  $this->db->order_by($sort,$order);
       }


       public function totalcontact()
        {
          return $this->db->get('csp_createcontact')->result();
        }

        public function totalservices()
        {
          return $this->db->get('csp_services')->result();
        }
  
        public function totalcampaign()
        {
          return $this->db->get('csp_campaign')->result();
        }


       public function createcustomer($name,$lastName,$DOB,$nationality,$emiratesid,$email,$insurance,$insurancecompany,$homeaddress,$companyaddress,$mobilenumber,$gender)
        {
           $data = array('firstname' => $name,'lastname' => $lastName,'DOB' => $DOB,'email' => $email,'mobile_number' => $mobilenumber,'gender' =>$gender,'nationality' =>$nationality,'emirates_id' => $emiratesid,'insurance_card_no' =>$insurance,'insurance_company' => $insurancecompany,'home_address' => $homeaddress,'company_address' => $companyaddress  );
           return $this->db->insert('csp_createcustomer',$data);
        }

       

        public function createservices($customername,$Reason,$Description,$Subject,$Received,$priority,$assign,$department,$ticketstatus,$duedate,$phonenumber,$policynumber)
        {
          $ticktid = time();

           $data = array('user_id'=> '1','ticket_id' => $ticktid,'user_type' => 'admin','customer_name' => $customername,'reasonforcall' => $Reason,'description' => $Description,'subject' => $Subject,'received' => $Received,'priority' =>$priority,'assign' =>$assign,'department' => $department,'duedate' => $duedate,'ticketstatus' =>$ticketstatus,'phonenumber' =>$phonenumber,'policynumber' =>$policynumber,'createtime' => date('Y-m-d h:i:s'));
           return $this->db->insert('csp_services',$data);
        }

        public function Updateservices($ticketid,$customername,$Reason,$Description,$Subject,$Received,$priority,$assign,$department,$ticketstatus,$duedate,$phonenumber,$policynumber)
        {
         

           $data = array('customer_name' => $customername,'reasonforcall' => $Reason,
           'description' => $Description,'subject' => $Subject,'received' => $Received,'priority' =>$priority,'assign' =>$assign,
           'department' => $department,'duedate' => $duedate,'ticketstatus' =>$ticketstatus,'phonenumber' =>$phonenumber,
           'policynumber' =>$policynumber);

                  $this->db->where('ticket_id', $ticketid);
           return $this->db->update('csp_services',$data);
        }
       

        public function createcontact($destinationNumbVal,$DialerVal,$PrioVal,$StartTimeVal,$StartDtval,$StopDateVal,$StopTimeVal,$CallTagVal,$CallTagtrackVal)
        {
           $data = array('destinationumber' => $destinationNumbVal,'dialer' => $DialerVal,'Prio' => $PrioVal,'startTime' => $StartTimeVal,'StartDate' => $StartDtval,'StopTime' =>$StopTimeVal,'StopDate' =>$StopDateVal,'CallTag_name' => $CallTagVal,'CallTag_Trackid' =>$CallTagtrackVal);
           return $this->db->insert('csp_createcontact',$data);
        }


        public function updatecontact($destinationNumbVal,$DialerVal,$PrioVal,$StartTimeVal,$StartDtval,$StopDateVal,$StopTimeVal,$CallTagVal,$CallTagtrackVal,$contactId)
        {

           

           $data = array('destinationumber' => $destinationNumbVal,'dialer' => $DialerVal,'Prio' => $PrioVal,'startTime' => $StartTimeVal,'StartDate' => $StartDtval,'StopTime' =>$StopTimeVal,'StopDate' =>$StopDateVal,'CallTag_name' => $CallTagVal,'CallTag_Trackid' =>$CallTagtrackVal);

                   $this->db->where('id',$contactId);
           return $this->db->update('csp_createcontact',$data);
        }
         
        public function createcampaign($cmmpid,$Campaignname,$Mode,$Scheduletime,$Campaigndate,$Scheduledate,$serviceprovider,$Campaigndes)
        {
           
           $data = array('camp_id' => $cmmpid , 'campaign_name' => $Campaignname,'mode' => $Mode,'schedule_time' => $Scheduletime,'schedule_date' => $Scheduledate,'campaign_date' => $Campaigndate,'service_provider' =>$serviceprovider,'campaign_description' =>$Campaigndes );
           return $this->db->insert('csp_campaign',$data);
        }


        public function editcontact($id)
         {
            $this->db->where('id',$id);
            return $this->db->get('csp_createcontact')->row();
         }
        
         public function singledeatils($id)
         {
            $this->db->where('ticket_id',$id);
            return $this->db->get('csp_services')->row();
         }

         public function taskcomments($id)
         {
            $this->db->order_by('id','desc');
            $this->db->where('ticket_id',$id);
            return $this->db->get('csp_task_comment')->result();
         }

         public function auditdeatils($id)
         {
            
            $this->db->where('ticket_id',$id);
            return $this->db->get('csp_audit')->result();
         }

         public function addcomment($comment,$taskid)
          {
            $data = array('message' => $comment,'ticket_id' =>$taskid,'comment_time' => date('d-m-Y h:s') );
            return  $this->db->insert('csp_task_comment',$data);
          }

          public function checkUser($username,$password)
          {
              $this->db->where('username',$username);
              $this->db->where('password',$password);
              return $this->db->get('csp_users')->row();
          }



    


}