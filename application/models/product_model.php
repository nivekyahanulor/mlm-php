<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_product_data() {
		$this->db->select('*');
		$this->db->from('biowash_products');
		$query = $this->db->get();
		return $query->result();
	}
    public function get_product_data_info($data) {
        $this->db->select('*');
        $this->db->from('biowash_products');
        $this->db->where($data);
        $query = $this->db->get();
        return $query->result();
    } 
	public function deleteproduct($data) {
        $this->db->where('productID', $data['productID']);
		$this->db->delete('biowash_products');
        redirect('administrator/products?deleted');
    }
    public function updateproduct($data) {
        $datas = array(
            'product_name'         => $data['productname'],
            'product_price'        => $data['productprice'],
            'product_description'  => $data['productdescription'],
            'product_qty'          => $data['product_qty'],
            'points'               => $data['points'],
            'isActive'             => 1,
            );
        $this->db->where('productID', $data['productID']);
        $this->db->update('biowash_products', $datas);
        redirect('administrator/productdetails?product='.$data['productID']);
    }
    public function updateproductimage($data) {
        unlink(FCPATH."assets\products". "\\". $data['productimage']);
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);
        move_uploaded_file($_FILES["image"]["tmp_name"], "assets/products/" . $_FILES["image"]["name"]);
        $location   =  $_FILES["image"]["name"];
        $id         =  $data['productID'];
       
        $this->db->query("update biowash_products set product_image='$location' where productID='$id'");
        redirect('administrator/productdetails?product='.$data['productID']);
    }
	public function saveproduct($data) {
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);
		move_uploaded_file($_FILES["image"]["tmp_name"], "assets/products/" . $_FILES["image"]["name"]);
        $location 	=  $_FILES["image"]["name"];
		$datas = array(
            'product_name'         => $data['productname'],
            'product_price'        => $data['productprice'],
            'product_description'  => $data['productdescription'],
            'mega'                 => $data['mega'],
            'stockist'             => $data['stockist'],
            'member'               => $data['member'],
            'product_qty'          => $data['product_qty'],
            'points'               => $data['points'],
            'product_image'   	   => $location,
            'isActive'  		   => 1,
			);
	    $this->db->insert('biowash_products',$datas);
		redirect('administrator/products?=added');
	}

}
	
?>