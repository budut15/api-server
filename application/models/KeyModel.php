<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KeyModel extends CI_Model {

    //Mengecek Auth Client
    public function check_auth_client(){
        
        $data = "1508";// X-id
        $secretKey = "budiutomo";
        $maxExpiredReq = 24333333333330; //4 menit
        date_default_timezone_set('UTC');
        $tStampServer = strval(time()-strtotime('1970-01-01 00:00:00'));
     
      
        $data = $this->input->get_request_header('X-id', TRUE);
        $tStampReq  = $this->input->get_request_header('X-Timestamp', TRUE);

        $encodedSignatureReq  = $this->input->get_request_header('X-Signature', TRUE);

        $intervalRequest = $tStampServer-$tStampReq;
        if($data == "1508"){
          if($intervalRequest < $maxExpiredReq){
            $signature = hash_hmac('sha256', $data."&".$tStampReq, $secretKey, true);
             // base64 encode…
            $encodedSignature = base64_encode($signature);
            
            if($encodedSignature == $encodedSignatureReq){
              return array('status' => 200,'message' => 'Authorized.');
            }else{
              return array('status' => 401,'message' => 'Unauthorized.');
            }
            
          }else{
            $message=['status' => 402,'message' => 'Expired.'];
			return array('status' => 402,'message' => 'Expired.');
          }

        } else {
            $message=['status' => 403,'message' => 'Not Found.'];
			//echo json_encode($message);
			//return json_encode($message);
			return array('status' => 403,'message' => 'Not Found.');
        }
    }
	
		public function getcarabayar($id)
		{
			if($id){
			return $this->db->select(" KODE,NAMA,TGLINPUT from m_carabayar 
			where status='0' and kode='".$id."'")->get()->result_array();
			}else{
			return $this->db->select(" KODE,NAMA,TGLINPUT from m_carabayar 
			where status='0'")->get()->result_array();	
			}
		}
		
		public function getklinik($id)
		{
			if($id){
			return $this->db->select(" KODE,NAMA,TGLINPUT from m_poly 
			where status='0' and kode='".$id."'")->get()->result_array();
			}else{
			return $this->db->select(" KODE,NAMA,TGLINPUT from m_poly 
			where status='0'")->get()->result_array();	
			}
		}
		
		public function getruang($id)
		{
			if($id){
			return $this->db->select(" KDRUANG,NAMA,KELAS,FASILITAS from m_ruang 
			where status='0' and KDRUANG='".$id."'")->get()->result_array();
			}else{
			return $this->db->select(" KDRUANG,NAMA,KELAS,FASILITAS from m_ruang 
			where status='0'")->get()->result_array();	
			}
		}
	
}
