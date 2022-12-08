<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');

        $this->load->model(array(
            'product_model' => 'product',
            'customer_model' => 'customer',
            'order_model' => 'order',
            'payment_model' => 'payment'
        ));
    }

    public function index()
    {
        $params['title'] = 'Admin '. get_store_name();

        $overview['total_products'] = $this->product->count_all_products();
        $overview['total_customers'] = $this->customer->count_all_customers();
        $overview['total_order'] = $this->order->count_all_orders();
        $overview['total_income'] = $this->payment->sum_success_payment();

        $overview['products'] = $this->product->latest();
        $overview['categories'] = $this->product->latest_categories();
        $overview['payments'] = $this->payment->payment_overview();
        $overview['orders'] = $this->order->latest_orders();
        $overview['customers'] = $this->customer->latest_customers();

        $overview['order_overviews'] = $this->order->order_overview();
        $overview['income_overviews'] = $this->order->income_overview();

        $this->load->view('header', $params);
        $this->load->view('overview', $overview);
        $this->load->view('footer');
    }

    
    public function pendapatan_pdf($id)
    {
            $this->load->library('pdf');
            $data = $this->order->order_data($id);

            $items = $this->order->order_items($id);
            $banks = json_decode(get_settings('payment_banks'));
            $banks = (array) $banks;

            $params['data'] = $data;
            $params['items'] = $items;
            $params['delivery_data'] = json_decode($data->delivery_data);
            $params['banks'] = $banks;

            $html = $this->load->view('orders/pdf', $params, true);
            $this->pdf->createPDF($html, 'order_' . $data->order_number, false, 'A3');
        
    }
}
