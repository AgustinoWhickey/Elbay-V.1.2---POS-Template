<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
	}

    public function index()
	{
        $getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/sale?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['user'] 		= $user;
		$data['items'] 		= $getData->data->items;
		$data['invoice'] 	= $getData->data->invoice;
		$data['category'] 	= $getData->data->category;
		$data['title'] 		= 'Transaksi Penjualan';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("transaction/sales/index_",$data);
		$this->load->view("templates/footer");
	
	}

	public function updatecart(){
		$data = [
			'id' => $this->input->post('cartid'),
			'qty' => htmlspecialchars($this->input->post('qty',true)),
			'total' => htmlspecialchars($this->input->post('total',true)),
			'discount' => htmlspecialchars($this->input->post('discount',true)),
			'updated' => time()
		];

		$result = $this->sale_m->updatecart($data);
		return $result; 
	}

	public function addcart(){

        $data = [
			'item_id' => htmlspecialchars($this->input->post('item_id',true)),
			'price' => htmlspecialchars($this->input->post('price',true)),
			'qty' => htmlspecialchars($this->input->post('qty',true)),
            'user_id' => $this->session->userdata('user_id'),
			'X-API-KEY' => 'restapi123'
		];

        api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/cart', $data);
		
	}

	public function cart_data(){
		$data['cart'] 	= $this->sale_m->getCart();
		$this->load->view("transaction/sales/cart_data",$data);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$result = $this->sale_m->deleteCart($id);

		return $result;
	}

    public function add_sale(){
        $data = [
			'discount' => $this->input->post('discount'),
			'grandtotal' => $this->input->post('grandtotal'),
			'cash' => $this->input->post('cash'),
			'change' => $this->input->post('change'),
			'note' => $this->input->post('note'),
            'user_id' => $this->session->userdata('user_id'),
			'X-API-KEY' => 'restapi123'
		];

        api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/sale', $data);
		
	}

	public function process_payment(){
		$stockbahan = array();
        $row = [];

		$sale_id = $this->input->post('saleid');
        $getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/sale?email='.$this->session->userdata('email').'&id='.$this->session->userdata('user_id').'&X-API-KEY=restapi123'));
		$carts = $getData->data->cart;

		foreach($carts as $value){
			$cartDetail = [
				'sale_id' => $sale_id,
				'item_id' => $value->item_id,
				'price' => $value->price,
				'qty' => $value->qty,
				'discount_item' => $value->discount_item,
				'total' => $value->total,
				'user_id' => $this->session->userdata('user_id'),
				'X-API-KEY' => 'restapi123'
            ];

            api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/saledetail', $cartDetail);

            $getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/item?email='.$this->session->userdata('email').'&id='.$value->item_id.'&X-API-KEY=restapi123'));
            $stocks = (array) $getData->data;

			foreach($stocks['onemenuitem'] as $stock){
				$stockout = [
					'item_id' => (int)$stock->item_id,
					'qty' => $stock->qty,
                    'X-API-KEY' => 'restapi123'
				];

                api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/unititem', $stockout);
			} 

			$stockout = [
				'item_id' => $value->item_id,
				'qty' => $value->qty,
                'X-API-KEY' => 'restapi123'
			];
			api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/item', $stockout);
		}

        $data = [
			'X-API-KEY' => 'restapi123',
			'id' => $this->session->userdata('user_id'),
		];

        api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/cart/'.$this->session->userdata('user_id'), $data);
		
	}

	public function cetak($id)
	{
        $getSaleData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/sale?email='.$this->session->userdata('email').'&id='.$id.'&X-API-KEY=restapi123'));
		$saleData = $getSaleData->data->sale;

        $getSaleDetailData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/saledetail?email='.$this->session->userdata('email').'&id='.$id.'&X-API-KEY=restapi123'));
		$saleDetailData = $getSaleDetailData->data->saledetail;
        
		$data = array(
			'sale' => $saleData,
			'sale_detail' => $saleDetailData
		);

		$this->load->view('transaction/sales/receipt_print', $data);
	}
}