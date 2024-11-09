<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
	}

	function get_product_by_category() {
		if(isset($_POST['idcat'])){
			$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/product?email='.$this->session->userdata('email').'&id='.$_POST['idcat'].'&X-API-KEY=restapi123'));
		} else {
			$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/product?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		}
		$items = $getData->data->items;
		$html = '';

		foreach($items as $item){
			$html .= '<div class="col mb-5">
						<a href="#" id="item" iditem="'.$item->id.'" stock="'.$item->stock.'" product="'.$item->name.'" price="'.$item->price.'">
						<div class="card h-100">
							<img class="card-img-top" src="'.base_url('assets/img/upload/products/'.$item->image).'" alt="..." style"height:50%;" />
							<div class="card-body p-4">
								<div class="text-center h6">
									<h5 class="fw-bolder">'.$item->name.'</h5>
									'.indo_currency($item->price).'
								</div>
							</div>
						</div>
						</a>
					</div>';
		}

		echo $html;
	}

	function get_ajax() {
		
        $getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/datatables/item?X-API-KEY=restapi123'));

		if($getData) {
		$list = $getData->data->data;
		$data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no.".";
			$row[] = $item->name.' <a href="'.site_url('item/print_barcode/'.$item->id).'" class="btn btn-default btn-xs">
									<i class="fa fa-barcode"></i>
								</a>';
            $row[] = $item->barcode;
            $row[] = $item->category_name;
            $row[] = $item->price;
            $row[] = $item->stock;
            $row[] = $item->image != null ? '<img src="'.base_url('assets/img/upload/products/'.$item->image).'" class="img" style="width:100px">' : null;
			$row[] = '<button type="button" class="btn btn-xs btn-info edit-item" data-id="'.$item->id.'">Edit</button>
					 <button type="button" class="btn btn-xs btn-danger delete-item" data-id="'.$item->id.'">Delete</button>';
           $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $getData->data->count,
                    "recordsFiltered" => $getData->data->count_filtered,
                    "data" => $data,
                );
		
        echo json_encode($output);
			}
    }
	
	public function index() {
		
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/item?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['title'] 		= 'Product Item Manajemen';
		$data['user'] 		= $user;
		$data['items'] 		= $getData->data->items;
		$data['unititems'] 	= $getData->data->unititems;
		$data['category'] 	= $getData->data->category;

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("product/item/index",$data);
		$this->load->view("templates/footer");
	
	}

	public function input()
	{
		$image = '';
		if(isset($_FILES['image'])) {
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/img/upload/products';
			$config['file_name'] = 'img-'.$this->input->post('barcode');

			$this->load->library('upload',$config);
			if($this->upload->do_upload('image')){
				$image = $this->upload->data('file_name');
			} 
		}

		$items = (array) json_decode($this->input->post('items'));
		$stockbahan = array();
		foreach($items as $key => $val){
			$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/itemmenu?email='.$this->session->userdata('email').'&id='.$key.'&X-API-KEY=restapi123'));
			$data = (array) $getData->data->items;

			array_push($stockbahan, intval($data['stock']/(int)$val));
		}

		$data = [
			'barcode' => htmlspecialchars($this->input->post('barcode',true)),
			'nama' => htmlspecialchars($this->input->post('nama',true)),
			'kategori' => htmlspecialchars($this->input->post('kategori',true)),
			'harga' => htmlspecialchars($this->input->post('harga',true)),
			'stock' => min($stockbahan),
			'image' => $image,
			'created' => time(),
			'X-API-KEY' => 'restapi123'
		];

		api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/item', $data);

	}

	public function input_menu_item() 
	{
		$items = (array) json_decode($this->input->post('items'));
		foreach($items as $key => $val){
			$data = [
				'product_id' => (int)$this->input->post('product'),
				'item_id' => (int)$key,
				'qty' => (int)$val,
				'created' => time(),
				'X-API-KEY' => 'restapi123'
			];
			api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/menuitem', $data);
		}
	}

	public function edit($id_item) 
	{
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/item?email='.$this->session->userdata('email').'&id='.$id_item.'&X-API-KEY=restapi123'));
		$data = (array) $getData->data;

		echo json_encode($data);
	}

	public function update()
	{
		$image = $this->input->post('gambar');
		if(isset($_FILES['image'])) {
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/img/upload/products';
			$config['file_name'] = 'img-'.$this->input->post('barcode');

			$this->load->library('upload',$config);
			$fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			if($image != ''){
				unlink('./assets/img/upload/products/img-'.$this->input->post('barcode').'.'.$fileExt);
			}
			if($this->upload->do_upload('image')){
				$image = $this->upload->data('file_name');
			} 
		}

		$items = (array) json_decode($this->input->post('items'));
		$stockbahan = array();
		foreach($items as $key => $val){
			$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/itemmenu?email='.$this->session->userdata('email').'&id='.$key.'&X-API-KEY=restapi123'));
			$data = (array) $getData->data->items;

			array_push($stockbahan, intval($data['stock']/(int)$val));
		}

		$data = [
			'id' => $this->input->post('id'),
			'barcode' => htmlspecialchars($this->input->post('barcode',true)),
			'nama' => htmlspecialchars($this->input->post('nama',true)),
			'kategori' => htmlspecialchars($this->input->post('kategori',true)),
			'harga' => htmlspecialchars($this->input->post('harga',true)),
			'stock' => min($stockbahan),
			'image' => $image,
			'X-API-KEY' => 'restapi123'
		];

		api_data_put('http://localhost/Elbay/Elbay-V.1.2/api/item', $data);

	}

	public function update_menu_item() 
	{
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => $this->input->post('product'),
		];

		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/menuitem/'.$this->input->post('product'), $data);

		$items = (array) json_decode($this->input->post('items'));

		foreach($items as $key => $val){
			$data = [
				'product_id' => (int)$this->input->post('product'),
				'item_id' => (int)$key,
				'qty' => (int)$val,
				'created' => time(),
				'X-API-KEY' => 'restapi123'
			];
			api_data_post('http://localhost/Elbay/Elbay-V.1.2/api/menuitem', $data);
		}
		
	}

	public function delete()
	{
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/item/'.$this->input->post('id'), $data);

		if($this->input->post('gambar') != '') {
			unlink('./assets/img/upload/products/'.$this->input->post('gambar'));
		}

	}

	public function delete_menu_item()
	{
		$data = [
			'X-API-KEY' => 'restapi123',
			'id' => (int)$this->input->post('id'),
		];
	
		api_data_delete('http://localhost/Elbay/Elbay-V.1.2/api/menuitem/'.$this->input->post('id'), $data);

	}

	public function print_barcode($id_item)
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['oneitem'] 	= $this->item_m->getItem($id_item);
		$data['category'] 	= $this->category_m->getCategories();
		$data['title'] 		= 'Barcode Item';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("product/item/barcode",$data);
		$this->load->view("templates/footer");
	} 

	public function printpdf_barcode($id_item)
	{
		$data['oneitem'] 	= $this->item_m->getItem($id_item);
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    
		pdf_generator('<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data['oneitem']->barcode, $generator::TYPE_CODE_128)) . '"><br>'.$data['oneitem']->barcode,'coba');
	}

}
