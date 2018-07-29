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

       public function createcustomer($name,$lastName,$DOB,$nationality,$emiratesid,$email,$insurance,$insurancecompany,$homeaddress,$companyaddress,$mobilenumber,$gender)
        {
           $data = array('firstname' => $name,'lastname' => $lastName,'DOB' => $DOB,'email' => $email,'mobile_number' => $mobilenumber,'gender' =>$gender,'nationality' =>$nationality,'emirates_id' => $emiratesid,'insurance_card_no' =>$insurance,'insurance_company' => $insurancecompany,'home_address' => $homeaddress,'company_address' => $companyaddress  );
           return $this->db->insert('csp_createcustomer',$data);
        }






}