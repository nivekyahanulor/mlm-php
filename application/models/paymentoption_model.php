<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paymentoption_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_paymentmethod_data() {
		$this->db->select('*');
		$this->db->from('biowash_payment_options');
		$query = $this->db->get();
		return $query->result();
	}
   
    public function updatepaymentoption($data) {
        $datas = array(
            'payment_procedure'  => $data['paymentprocedures'],
            'payment_type'    	 => $data['paymentmethod'],
			);
        $this->db->where('payID', $data['payid']);
        $this->db->update('biowash_payment_options', $datas);
		redirect('administrator/settings/payment_options?=updated');
    }
    public function deletepaymentoption($data) {
        $this->db->where('payID', $data['payid']);
		$this->db->delete('biowash_payment_options');
		redirect('administrator/settings/payment_options?=deleted');
    }
  
	public function savepaymentoption($data) {
		$datas = array(
            'payment_procedure'  => $data['paymentprocedures'],
            'payment_type'    	 => $data['paymentmethod'],
			);
	    $this->db->insert('biowash_payment_options',$datas);
		redirect('administrator/settings/payment_options?=added');
	}

}
	
?>