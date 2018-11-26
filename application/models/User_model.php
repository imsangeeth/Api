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
          return $this->db->get('csp_users')->row();
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
      
       public function allcontacts($sort,$order,$page,$name)
       {
        $page = $page - 1;
        $pagestart = $page * 10;
        $pageend = $pagestart - 10;

        if($name !='Imp')
        {
          $this->db->like('firstname',$name);
          $this->db->or_like('companyname',$name);
          $this->db->or_like('title',$name);
          $this->db->or_like('emirates_id',$name);
          return $this->db->get('csp_createcustomer',10,$pagestart)->result();
          
        }
        else if($sort == "2d242uyz" || $sort == "created")
        {          $this->db->order_by('id','desc');
          return $this->db->get('csp_createcustomer',10,$pagestart)->result();
        }
        else{
          $this->db->order_by($sort,$order);
          return $this->db->get('csp_createcustomer',10,$pagestart)->result();
        }
          
             //  $this->db->order_by($sort,$order);
       }


       public function allservices($sort,$order,$page,$name,$assignsort)
       {
            $page = $page - 1;
            $pagestart = $page * 10;
            $pageend = $pagestart - 10;

               $id = $this->session->userdata('rewqfdsas');
               $this->db->where('id',$id);
               $type =  $this->db->get('csp_users')->row();

               if($type->type == 1)
                {

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

                }else if($type->type == 2){

                  if($name !='Imp')
                  {
                   $this->db->like('ticket_id',$name);
                   $this->db->or_like('customer_name',$name);
                   $this->db->or_like('Duedate',$name);	
                   $this->db->where('assign',$id);
                  return $this->db->get('csp_services',10,$pagestart)->result();
                  }
                 else if($assignsort !='0')
                  {
                   
                  $this->db->or_like('assign',$assignsort);	
                   $this->db->where('assign',$id);
                   return $this->db->get('csp_services',10,$pagestart)->result();
                  }
                 else if($sort == "2d242uyz" || $sort == "created")
                   {        
                   $this->db->order_by('id','desc');
                   $this->db->where('assign',$id);
                   return $this->db->get('csp_services',10,$pagestart)->result();
                   }
                else{
                 
                   $this->db->order_by($sort,$order);
                   $this->db->where('assign',$id);
                   return $this->db->get('csp_services',10,$pagestart)->result();
                   }

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
          return $this->db->get('csp_createcustomer')->result();
        }

        public function totalservices()
        {
               $id = $this->session->userdata('rewqfdsas');
               $this->db->where('id',$id);
               $type =  $this->db->get('csp_users')->row();

               if($type->type == 1)
                {
                   return $this->db->get('csp_services')->result();

                }elseif($type->type == 2){
                    $this->db->where('user_id',$id);
                   return $this->db->get('csp_services')->result();
                }
                else {
                   return 0;
                }
        }
  
        public function totalcampaign()
        {
          return $this->db->get('csp_campaign')->result();
        }


       public function createcustomer($name,$lastName,$Title,$companyname,$mobilenumber,$dob,$Gender,$Nationality,$email,$Source,$Type,$emiratesId,$insurancecard,$insurancecompany,$homeaddress,$Companyaddress)
        {
           $data = array('firstname' => $name,'lastname' => $lastName,'DOB' => $dob,'email' => $email,
           'mobile_number' => $mobilenumber,'gender' =>$Gender,'nationality' =>$Nationality,
           'emirates_id' => $emiratesId,'insurance_card_no' =>$insurancecard,'insurance_company' => $insurancecompany,
           'home_address' => $homeaddress,'company_address' => $Companyaddress,'title' => $Title,'companyname' => $companyname,'Source' => $Source,'Type' => $Type
             );

           return $this->db->insert('csp_createcustomer',$data);

        }

       

        public function createservices($customername,$Reason,$Description,$Subject,$Received,$priority,$assign,$department,$ticketstatus,$duedate,$phonenumber,$policynumber)
        {
           $ticktid = time();

           $data = array('user_id'=> '1','ticket_id' => $ticktid,'user_type' => 'admin','customer_name' => $customername,
           'reasonforcall' => $Reason,'description' => $Description,'subject' => $Subject,
           'received' => $Received,'priority' =>$priority,'assign' =>$assign,
           'department' => $department,'duedate' => $duedate,
           'ticketstatus' =>$ticketstatus,'phonenumber' =>$phonenumber,'policynumber' =>$policynumber,'createtime' => date('Y-m-d h:i:s'));

            $this->db->insert('csp_services',$data);
           
            $insert_id = $this->db->insert_id();
           
            $audit = array('heading' => 'Ticket created at','message' => 'Administration created','generate_date' => date('Y-d-m h:s'),'ticket_id' =>$insert_id );
            return $this->db->insert('csp_audit',$audit);




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

      public function contactsingledetails($key)
      {
         $this->db->where('id',$key);
         return $this->db->get('csp_createcustomer')->row();
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

           //create new survey sangeeth 10/25/2018

           public function createsurvey($surveyname,$surveytype)
           {
              $survey_id = rand(99,999).time().rand(99,999);
              $data = array('survey_id' => $survey_id,'survey_name' => $surveyname,'survey_type' =>$surveytype,'dateofcreate' =>date('y-m-d h:i:s'),'survey_key' => '');
              $this->db->insert('csp_newsurvey',$data);
              $insert_id = $this->db->insert_id();
              return  $insert_id;
           }

           function insertquestion($question,$id,$surveytype)
           {
             $data = array('survey_id' =>$id,'question' =>$question,'type'=> $surveytype);
             $this->db->insert('csp_survey_questions',$data);
             $insert_id = $this->db->insert_id();
             return  $insert_id;

           }

           function insertanswer($rowa,$qustionid,$id)
           {
             $data = array('survey_id' =>$id,'question_id'=>$qustionid,'answers' =>$rowa);
             return $this->db->insert('csp_survey_answers',$data);
           }

           function officelocation()
           {
              $this->db->order_by('id','desc');
              return $this->db->get('csp_office_location')->result();
           }

           function office_department()
           {
              $this->db->order_by('id','desc');
              return $this->db->get('csp_office_department')->result();
           }

           function office_department_user($ky)
           {
              $this->db->where('dep_id',$ky);
              return $this->db->get('csp_department_user')->result();
           }

           function officebranches($ky)
           {
              $this->db->order_by('id','desc');
              $this->db->where('location_id',$ky);
              return $this->db->get('csp_braches')->result();
           }
           
           function officebranchaddress($ky)
           {
              $this->db->order_by('id','desc');
              $this->db->where('branch_id',$ky);
              return $this->db->get('csp_branch_address')->result();
           }


           function allinbound()
           {
              $this->db->order_by('id','desc');
              //$this->db->where('	insurance_type',$ky);
              return $this->db->get('csp_inbound_phase1')->result();
           }

           function cspinboundphase2($ky)
           {
            $this->db->where('inbo_id',$ky);
            return $this->db->get('csp_inbound_phase2')->result();
           }

           function cspinboundphase3($ky)
           {
              $this->db->where('id',$ky);
              $pahse = $this->db->get('csp_inbound_phase2')->row();
             
            //  $this->db->order_by('id','desc');
              $this->db->where('inbo_id',$pahse->inbo_id);
              return $this->db->get('csp_inbound_phase3')->result();
           }

           function cspinboundphase4($ky)
           {
              $this->db->where('id',$ky);
              $pahse = $this->db->get('csp_inbound_phase3')->row();
             
            //  $this->db->order_by('id','desc');
              $this->db->where('inbo_id',$pahse->inbo_id);
              return $this->db->get('csp_inbound_phase4')->result();
           }


           function onChangeCopType()
           {
              $this->db->order_by('id','desc');
              //$this->db->where('	insurance_type',$ky);
              return $this->db->get('csp_corporate_type')->result();
           }

           function cop_phase2($ky)
           {
            //  $this->db->order_by('id','desc');
              $this->db->where('cop_id',$ky);
              return $this->db->get('csp_corporate_phase1')->result();
           }

           function cop_phase3($ky)
           {
            $this->db->where('id',$ky);
            $pahse = $this->db->get('csp_corporate_phase1')->row();
             
            //  $this->db->order_by('id','desc');
              $this->db->where('cop_id',$pahse->cop_id);
              return $this->db->get('csp_corporate_phase2')->result();
           }

           function cop_phase4($ky)
           {
            $this->db->where('id',$ky);
            $pahse = $this->db->get('csp_corporate_phase2')->row();
             
            //  $this->db->order_by('id','desc');
              $this->db->where('cop_id',$pahse->cop_id);
              return $this->db->get('csp_corporate_phase3')->result();
           }

           function cop_phase5($ky)
           {
            $this->db->where('id',$ky);
            $pahse = $this->db->get('csp_corporate_phase3')->row();
             
            //  $this->db->order_by('id','desc');
              $this->db->where('cop_id',$pahse->cop_id);
              return $this->db->get('csp_corporate_phase4')->result();
           }

           function insuranctype()
           {
              $this->db->order_by('id','desc');
              //$this->db->where('	insurance_type',$ky);
              return $this->db->get('csp_insurance_type')->result();
           }

           function insurance_phase2($ky)
           {
            //  $this->db->order_by('id','desc');
              $this->db->where('type_id',$ky);
              return $this->db->get('csp_insurance_phase2')->result();
           }

           function insurance_phase3($ky)
           {
              //$this->db->order_by('id','desc');
              $this->db->where('phase2_id',$ky);
              return $this->db->get('csp_insurance_phase3')->result();
           }

           function insurance_phase4($ky)
           {
            $this->db->where('id',$ky);
            $pahse = $this->db->get('csp_insurance_phase3')->row();

            //$this->db->order_by('id','desc');
            $this->db->where('phase_id',$pahse->phase2_id);
            return $this->db->get('phase_category1')->result();
           }

           function insurance_phase5($ky)
           {

            $this->db->where('id',$ky);
            $pahse = $this->db->get('phase_category1')->row();

            //  $this->db->order_by('id','desc');
              $this->db->where('phase_id',$pahse->phase_id);
              return $this->db->get('phase_category2')->result();
           }

           function insurance_phase6($ky)
           {

            $this->db->where('id',$ky);
            $pahse = $this->db->get('phase_category2')->row();

            //  $this->db->order_by('id','desc');
              $this->db->where('phase_id',$pahse->phase_id);
              return $this->db->get('phase_category3')->result();
           }

           function insurance_phase7($ky)
           {
               $this->db->where('id',$ky);
               $pahse = $this->db->get('phase_category3')->row();

            //  $this->db->order_by('id','desc');
              $this->db->where('phase_id',$pahse->phase_id);
              return $this->db->get('phase_category4')->result();
           }

           function insurance_phase8($ky)
           {
               $this->db->where('id',$ky);
               $pahse = $this->db->get('phase_category4')->row();

            //  $this->db->order_by('id','desc');
              $this->db->where('phase_id',$pahse->phase_id);
              return $this->db->get('phase_category5')->result();
           }

           function insurance_phase9($ky)
           {
               $this->db->where('id',$ky);
               $pahse = $this->db->get('phase_category5')->row();

            //  $this->db->order_by('id','desc');
              $this->db->where('phase_id',$pahse->phase_id);
              return $this->db->get('phase_category6')->result();
           }

           function createservice_ind($Insurancetype,$Individual_two,$Individual_three,$Individual_four,
           $Individual_five,$Individual_six,$Individual_sevan,$Individual_eight,$Individual_nine,$ser_assign,$ser_department,$Remarks)
           {
              $data = array('csp_insurance_type' => $Insurancetype ,'csp_insurance_phase2' => $Individual_two,'csp_insurance_phase3' => $Individual_three,'phase_category1' =>$Individual_four,
            'phase_category2' => $Individual_five,'phase_category3' =>$Individual_six,'phase_category4' =>$Individual_sevan,'phase_category5' => $Individual_eight,
         'phase_category6' =>$Individual_nine,'remarks' => $Remarks,'csp_office_department' =>$ser_department,'csp_department_user' =>$ser_department);

             $this->db->insert('csp_af_services_ind',$data);
             $insert_id = $this->db->insert_id();
             return $insert_id;

           }

           function createservice_cop($Corporatetype,$Corporate_two,$Corporate_three,$Corporate_four,
           $Corporate_five,$Corporate_assign,$Corporate_department,$CorporateRemarks,$Corporatecomment)
           {
              $data = array('csp_corporate_type' => $Corporatetype ,'csp_corporate_phase1' => $Corporate_two,'csp_corporate_phase2' => $Corporate_three,'csp_corporate_phase3' =>$Corporate_four,
            'csp_corporate_phase4' => $Corporate_five,'remarks' =>$CorporateRemarks,'comment' =>$Corporatecomment,'csp_office_department' => $Corporate_department,
         '	csp_department_user' =>$Corporate_assign);

               $this->db->insert('csp_af_services_cop',$data);
               $insert_id = $this->db->insert_id();
               return $insert_id;

           }

           function createservice_inbound($inboundtype,$inboundtype_two,$inboundtype_three,$inboundtype_four,
           $inboundtype_assign,$inboundtype_department,$inboundtypeRemarks,$inboundtypecomment)
           {
              $data = array('csp_inbound_phase1' => $inboundtype ,'csp_inbound_phase2' => $inboundtype_two,'csp_inbound_phase3' => $inboundtype_three,
              'csp_inbound_phase4' =>$inboundtype_four,'remarks' =>$inboundtypeRemarks,'comment' =>$inboundtypecomment,'csp_office_department' => $inboundtype_department,
         '	csp_department_user' =>$inboundtype_assign);

               $this->db->insert('csp_af_services_inbo',$data);
               $insert_id = $this->db->insert_id();
               return $insert_id;

           }


           function create_services_new($Corporate_department,$Corporate_assign,$type,$insert_su,$Corporatecomment)
           {
              $ticket_id = time(); 

             $data = array('department' => $Corporate_department ,'assign' => $Corporate_assign,'ticket_sub_type' => $type,'ticket_sub_id' =>$insert_su,
            'user_id' => 1,'ticket_id' => $ticket_id,'ticketstatus' => 'Open','createtime' => date('Y-m-d h:i:s'),'phonenumber' =>'9838833');

             $this->db->insert('csp_services',$data);

             if(trim($Corporatecomment) !='')
             {
               $comment = array('user_id' => 1,'ticket_id' => $ticket_id,'message' =>$Corporatecomment,'comment_time' =>date('Y-m-d h:i:s')   );
               return $this->db->insert('csp_task_comment',$comment);

             }else{
               
               return;
             }

             
           }

           

    


}