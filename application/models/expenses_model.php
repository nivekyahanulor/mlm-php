<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class Expenses_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_expenses_data() {
		$this->db->select('*');
		$this->db->from('biowash_expenses_records');
		$query = $this->db->get();
		return $query->result();
	}
   public function deleteexpenses($data) {
        $this->db->where('expensesID', $data['expensesID']);
		$this->db->delete('biowash_expenses_records');
		redirect('administrator/expenses?=deleted');
    }
    public function updateproduct($data) {
        $datas = array(
            'product_name'         => $data['productname'],
            'product_price'        => $data['productprice'],
            'product_description'  => $data['productdescription'],
            'product_qty'          => $data['productqty'],
            'earning_lvl_one'      => $data['earn_lvl_1'],
            'earning_lvl_two'      => $data['earn_lvl_2'],
            'earning_lvl_three'    => $data['earn_lvl_3'],
            'earning_lvl_four'     => $data['earn_lvl_4'],
            'earning_lvl_five'     => $data['earn_lvl_5'],
            'earning_lvl_six'      => $data['earn_lvl_6'],
            'earning_lvl_seven'    => $data['earn_lvl_7'],
            'earning_lvl_eight'    => $data['earn_lvl_8'],
            'earning_lvl_nine'     => $data['earn_lvl_9'],
            'earning_lvl_ten'      => $data['earn_lvl_10'],
            'isActive'             => 1,
            );
        $this->db->where('productID', $data['productID']);
        $this->db->update('biowash_products', $datas);
        redirect('administrator/productdetails?product='.$data['productID']);
    }
	
	 public function updateexpenses($data) {
        $datas = array(
            'expenses_amount'      => $data['expensesamount'],
            'expenses_details'     => $data['expensesdetails'],
            'expenses_date' 	   => $data['expensesdate'],
            'expenses_by'          => $data['expensesdateby'],
            'quantity'        	   => $data['quantity'],
            );
        $this->db->where('expensesID', $data['expensesID']);
        $this->db->update('biowash_expenses_records', $datas);
		redirect('administrator/expenses?=updated');
    }
  
  
	public function saveexpenses($data) {
		
		$date = date('Y-m-d h:i:s');
		
		$datas = array(
            'expenses_amount'      => $data['expensesamount'],
            'expenses_details'     => $data['expensesdetails'],
            'expenses_date' 	   => $data['expensesdate'],
            'expenses_by'          => $data['expensesdateby'],
            'quantity'        	   => $data['quantity'],
			'date_added'           => $date
			);
	    $this->db->insert('biowash_expenses_records',$datas);
		redirect('administrator/expenses?=added');
	}

}
	
?>