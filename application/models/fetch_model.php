<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fetch_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function transactionCode() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); 
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		static $result;
		if ( $result !== null ) 
			return $result;
		$result = implode($pass);
		return $result;
	}
	public function login_user($data) {
		 $data = array(
					'username' => $data['u'],
					'password' => $data['p'],
				);

		$this->db->select('*');
		$this->db->from('del2home_admin');
		$this->db->where($data);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
						$datas 			= $query->result();
						$session_data   = array(
							'userid'     => $datas[0]->adminID,
							'username'   => $datas[0]->username,
							);
						$this->session->set_userdata('logged_in', $session_data);
				echo 'success';   
			} else {
				echo 'fail';   
		}
	}
	
	public function login_account($data){
		$customer     = $this->login_customer($data);
		if($customer === 'success') { 
			echo 'customer'; 
		} else {
			$retailer = $this->login_retailer($data);
			if($retailer === 'success') { echo 'retailer'; } 
			else{
				$distributor = $this->login_distributor($data);
				if($distributor === 'success') { echo 'distributor'; } 
				else {
				echo 'error';
				}
			}
		}
	}
	
	public function login_customer($data) {
		$this->db->select('*');
		$this->db->from('del2home_customers');
		$this->db->where($data);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
						$datas 			 = $query->result();
						$cid             = $datas[0]->customerID;
						$checkorders     = $this->db->query("select transactionCode from del2home_orders where customerID='$cid' and checkoutStatus=0");
						$cnt             = $checkorders->num_rows();
						if($cnt == 0){
							$transcode   = $this->transactionCode();
						} else {
							$cores       = $checkorders->result();
							$transcode   = $cores[0]->transactionCode;
						}
						$session_data    = array(
							'userid'          => $datas[0]->customerID,
							'username'        => $datas[0]->username,
							'transcode'       => $transcode,
							'name'            => $datas[0]->firtsname .' '. $datas[0]->lastname,
							'contactnumber'   => $datas[0]->contactnumber,
							'emailaddress'    => $datas[0]->emailaddress,
							);
						$this->session->set_userdata('logged_in', $session_data);
				return 'success';   
		} else {
				return 'fail';   
		}
	}
	public function login_retailer($data) {
		$this->db->select('*');
		$this->db->from('del2home_retailers');
		$this->db->where($data);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
						$datas 			 = $query->result();
						$session_data    = array(
							'userid'     => $datas[0]->retailerID,
							'username'   => $datas[0]->username,
							'transcode'  => $this->transactionCode(),
							'name'       => $datas[0]->firtsname .' '. $datas[0]->lastname,
							);
						$this->session->set_userdata('logged_in', $session_data);
				return 'success';   
			} else {
				return 'fail';   
		}
	}
	public function login_distributor($data) {
		$this->db->select('*');
		$this->db->from('del2home_distributor');
		$this->db->where($data);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
						$datas 			 = $query->result();
						$session_data    = array(
							'userid'     => $datas[0]->distributorID,
							'username'   => $datas[0]->username,
							'transcode'  => $this->transactionCode(),
							'name'       => $datas[0]->firtsname .' '. $datas[0]->lastname,
							);
						$this->session->set_userdata('logged_in', $session_data);
				return 'success';   
			} else {
				return 'fail';   
		}
	}
	public function getviewproduct($data) {
		$data = array( 'productID' => $data);
		$this->db->select('*');
		$this->db->from('del2home_products');
		$this->db->where($data);
		$query = $this->db->get();
		return $query->result();
	}	
	public function getsubcategoryjson($data) {
		$data = array( 'catID' => $data);
		$this->db->select('*');
		$this->db->from('del2home_sub_category');
		$this->db->where($data);
		$query = $this->db->get();
		return $query->result();
	}
	public function getcategory() {
		$this->db->select('*');
		$this->db->from('del2home_category');
		$query = $this->db->get();
		return $query->result();
	}
	public function fetch_distributor() {
		$this->db->select('*');
		$this->db->from('del2home_distributor');
		$query = $this->db->get();
		return $query->result();
	}
	public function fetch_customers() {
		$this->db->select('*');
		$this->db->from('del2home_customers');
		$query = $this->db->get();
		return $query->result();
	}	
	public function fetch_products($data) {
		$this->db->select('*');
		$this->db->from('del2home_products');
		if($data['display']=='limit'){
			$this->db->order_by('productID', 'RANDOM');
			$this->db->limit(12);  
		} else if($data['display']=='promo'){
			$promo = array( 'product_sub_category' => 'Promo Bundles');
			$this->db->where($promo);
			$this->db->order_by('productID', 'RANDOM');
			$this->db->limit(12);  
		} else if($data['display']=='products'){
			$subcategory = $data['subcategory'];
			$category    = $data['category'];
			$promo = array( 'product_sub_category' => $subcategory);
			$this->db->where($promo);
		}
		$query = $this->db->get();
		return $query->result();
	}
	public function fetch_admin_products() {
		$this->db->select('*');
		$this->db->from('del2home_products');
		$query = $this->db->get();
		return $query->result();
	}
	public function getsubcategory($data) {
		$this->db->select('*');
		$this->db->from('del2home_sub_category');
		$this->db->where($data);
		$query = $this->db->get();
		return $query->result();
	}
	public function getbrandsubcategory($data) {
		$this->db->select('product_sub_category');
		$this->db->from('del2home_products');
		$this->db->where($data);
		$this->db->group_by('product_sub_category'); 
		$query = $this->db->get();
		return $query->result();
	}
	public function countproductretailer($data) {
		$query = $this->db->query("select count(*) as countproducts from del2home_retailer_inventory where  retailerID='$data'");
		return $query->result();
	}
	
}