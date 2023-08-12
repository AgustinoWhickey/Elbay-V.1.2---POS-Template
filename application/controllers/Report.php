<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{
  public function __construct()
  {
		parent::__construct();
		is_logged_in();
	}

	public function sales()
	{
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/sale?email='.$this->session->userdata('email').'&X-API-KEY=restapi123'));
		$user = (array) $getData->data->user[0];

		$data['user'] 		= $user;
		$data['sales'] 		= $getData->data->sales;
		$data['title'] 		= 'Laporan Data Penjualan';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("report/sale_report",$data);
		$this->load->view("templates/footer");
	
	}

	function get_ajax_sale() {
		$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/datatables/sale?X-API-KEY=restapi123'));

		if($getData) {
			$list = $getData->data->data;
		}

        $data = array();
        $no = @$_POST['start'];
        
        if($_POST['searchByFromdate'] != '' && $_POST['searchByTodate'] != ''){
            $fromDate = strtotime($_POST['searchByFromdate']);
            $toDate = strtotime($_POST['searchByTodate']);

            if($fromDate != '' && $toDate != ''){
				$getData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/datatables/sale?fromdate='.$fromDate.'&todate='.$toDate.'&X-API-KEY=restapi123'));
		
                $list = $getData->data->data_range_date;
                $countAll = $getData->data->count_all_date;
                $countFiltered = $getData->data->count_filtered_date;
            }
        }

        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no.".";
            $row[] = $item->invoice;
            $row[] = Date("d-m-Y", $item->created);
            $row[] = $item->total_price;
            $row[] = $item->discount;
            $row[] = $item->cash;
			$row[] = '<a href="'.site_url('sale/cetak/'.$item->id).'" target="_blank" class="btn btn-xs btn-info" id="printreport">
                        <i class="fa fa-print"></i> Print
                    </a>
                    <button data-invoice="'.$item->invoice.'" data-date="'.$item->date.'" data-time="'.Date("d-m-Y", $item->created).'" data-total="'.indo_currency($item->total_price).'" data-diskon="'.indo_currency($item->discount).'" data-grandtotal="'.indo_currency($item->final_price).'" data-cash="'.indo_currency($item->cash).'" data-remaining="'.indo_currency($item->remaining).'" data-note="'.$item->note.'" data-kasir="'.$item->user_name.'" data-saleid="'.$item->id.'" id="detail" data-target="#modal-detail" data-toggle="modal" class="btn btn-xs btn-success" id="detailreport">
                        Detail
                    </button>';
           $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $getData->data->count,
                    "recordsFiltered" => $getData->data->count_filtered,
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }

	public function sale_product($id)
    {
		$getSaleDetailData = json_decode(api_data_get('http://localhost/Elbay/Elbay-V.1.2/api/saledetail?email='.$this->session->userdata('email').'&id='.$id.'&X-API-KEY=restapi123'));
		$saleDetailData = $getSaleDetailData->data->saledetail;

		echo json_encode($saleDetailData); 
	}

}
