<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings_Model extends CI_Model {

    public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->database();
		$this->load->library('session');
    }
	
	public function get_settings_data() {
		$this->db->select('*');
		$this->db->from('biowash_system_settings');
		$query = $this->db->get();
		return $query->result();
	}
   
	public function updatesettings($data) {
        $datas = array(
            'tax_deduction'       => $data['textdeduction'],
            'processing_fee'      => $data['processingfee'],
            'withdrawal_amount'   => $data['withamount'],
            'earn_limit'          => $data['earn_limit'],
            'starter_pairing_earning'    => $data['starter_pairing_earning'],
            'silver_pairing_bunos'       => $data['silver_pairing_bunos'],
            'gold_pairing_bunos'         => $data['gold_pairing_bunos'],
            'premuim_pairing_bunos'      => $data['premuim_pairing_bunos'],
            'starter_flushout'           => $data['starter_flushout'],
            'silver_flushout'            => $data['silver_flushout'],
            'premuim_flushout'           => $data['premuim_flushout'],
            'gold_flushout'              => $data['gold_flushout'],
            'binary_direct_earn'         => $data['binary_direct_earn'],
            'binary_product_earn'        => $data['binary_product_earn'],
            'product_discount'           => $data['product_discount'],
            );
        $this->db->update('biowash_system_settings', $datas);
        redirect('administrator/settings/system_settings?updated');
    }
   
 

}
	
?>