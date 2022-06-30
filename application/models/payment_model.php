<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');


class Payment_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_payment_data() {
		$this->db->select('*');
		$this->db->from('biowash_orders_checkout');
		$this->db->join('biowash_members', 'biowash_members.memberID = biowash_orders_checkout.memberID');
		$this->db->join('biowash_product_orders', 'biowash_product_orders.transcode = biowash_orders_checkout.transcode');
		$this->db->join('biowash_products', 'biowash_products.productID = biowash_product_orders.productID');
		$this->db->where('biowash_orders_checkout.order_status', 0);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_payment_counts() {
		$this->db->select('*');
		$this->db->from('biowash_orders_checkout');
		$this->db->where('order_status', 0);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_payment_data_info($data) {
		$this->db->select('*');
		$this->db->from('biowash_orders_checkout');
		$this->db->where('transcode', $data);
		$query = $this->db->get();
		return $query->result();
	}
    public function get_purchased_data_info($data) {
		$this->db->select('*');
		$this->db->from('biowash_product_orders');
		$this->db->join('biowash_products', 'biowash_products.productID = biowash_product_orders.productID');
		$this->db->where('transcode', $data);
		$query = $this->db->get();
		return $query->result();
	} 
	public function declinepurchase($data) {
		$transcode = $data['code'];
		$this->db->query("update biowash_product_orders set approval_status =2 where transcode='$transcode'");
		$this->db->query("update biowash_orders_checkout set order_status =2 where transcode='$transcode'");
        redirect('administrator/payments/paymentdetails/'. $transcode.'/declined');
	}
    public function confirmpurchase($data) {
		$code        = $data['code'];
		$getpurchase = $this->db->query("select * from biowash_product_orders where transcode='$code'");
		foreach($getpurchase->result() as $a => $b){
			$prodid = $b->productID;
			$pqty   = $b->purchasedQty;
			$getproduct = $this->db->query("select * from biowash_products where productID='$prodid'");
			foreach($getproduct->result() as $c => $d){
				return $d->productID;
			}
		}
	}
   
    
}
	
?>