<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports_model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_sales_reports_approved() {
		$this->db->select('*');
		$this->db->from('biowash_product_orders');
		$this->db->join('biowash_members', 'biowash_product_orders.memberID = biowash_members.memberID');
		$this->db->join('biowash_products', 'biowash_products.productID = biowash_product_orders.productID');
		$this->db->where('biowash_product_orders.approval_status', '1');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_package_sales_reports_approved() {
		$this->db->select('*');
		$this->db->from('biowash_member_package');
		$this->db->join('biowash_members', 'biowash_member_package.member_id = biowash_members.memberID');
		$this->db->join('biowash_packages', 'biowash_packages.packageID = biowash_member_package.package_id');
		$this->db->where('biowash_member_package.is_approved', '1');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_sales_reports_declined() {
		$this->db->select('*');
		$this->db->from('biowash_product_orders');
		$this->db->join('biowash_members', 'biowash_product_orders.memberID = biowash_members.memberID');
		$this->db->join('biowash_products', 'biowash_products.productID = biowash_product_orders.productID');
		$this->db->where('biowash_product_orders.approval_status', '2');
		$query = $this->db->get();
		return $query->result();
	}
	
	
 

}
	
?>