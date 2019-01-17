<?php
/**
 * Created by PhpStorm.
 * Date: 1/3/2019
 * Time: 00:08
 */
class model_tbl_orders extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	protected $_tblOrder = 'tbl_orders';
	protected $_tblOrderDetail = 'tbl_order_details';
	
    public function insertOrder($dataIns)
    {
        $date = date('Y-m-d H:i:s', time());
        $data = array(
            'order_name'              => $dataIns['ordername'],
            //'order_total_amount'      => $dataIns['order_total_amount'],
            //'order_total_quantity'    => $dataIns['order_total_quantity'],
            'order_created_date'      => $dataIns['order_created_date'],
            'order_created_by'        => $dataIns['order_created_by'],
            'order_remark'            => $dataIns['order_remark'],
            'order_by_sale'           => $dataIns['order_by_sale'],
            'admin_review_status'     => $dataIns['admin_review_status'],
            'admin_review_date'       => $dataIns['admin_reivew_date'],
            'order_status'            => $dataIns['order_status'],
            'order_expire_date'       => $dataIns['order_expire_date'],
            'partner_id'              => $dataIns['partner_id'],
            'partner_username'        => $dataIns['partner_username'],
            'latest_update_date'      => $date,
            'provider_code'           => $dataIns['provider_code']
        );
        $this->db->insert('tbl_orders', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function insertOrderDetail($dataInsDetail)
    {
            $dataDetail = array(
            'order_id'              => $dataInsDetail['order_id'],
            'expect_amount'         => $dataInsDetail['amount'],
            'provider_code'         => $dataInsDetail['tecol'],
            'phone_number'          => $dataInsDetail['phoneNumber'],
            'created_date'          => $dataInsDetail['created_date'],
            'charge_type'           => $dataInsDetail['type'],
            'order_status'          => $dataInsDetail['order_status']
        );
        $insert2 = $this->db->insert('tbl_order_details', $dataDetail);
    }
	
	public function updateOrder($dataUpdate){
		$this->db->update('tbl_orders', $dataUpdate);
	}
	
	public function get_total_pending($charge_type){
		$now = date('Y-m-d h:i:s', time());
		
		$this->db->select("SUM(D.pending_amount) as total_pendingamount, D.charge_type, D.provider_code, O.order_name");
		$this->db->from("$this->_tblOrderDetail D");
		$this->db->join("$this->_tblOrder O", 'D.order_id = O.order_id');
		
		$this->db->where("D.payment_status", '99');
		$this->db->where("O.order_expire_date >", $now);
		$this->db->where("D.order_status", 'W');
		$this->db->where("D.charge_type", $charge_type);
		$this->db->group_by("D.charge_type, D.order_id, D.provider_code");
		
		$query =  $this->db->get();
		if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
	}
}