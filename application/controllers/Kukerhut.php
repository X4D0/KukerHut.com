<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kukerhut extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('Products_model');
    }
    public function index()
    {
        $data['iklan'] = $this->Products_model->getIklan();
        $data['produk'] = $this->Products_model->getProductHome();
        $this->load->view('templates/header');
        $this->load->view('contents/home', $data);
        $this->load->view('templates/footer');

    }
    public function products()
    {
        //konfigurasi pagination
        $config['base_url'] = site_url('Kukerhut/products'); //site url
        $config['total_rows'] = $this->db->count_all('produk'); //total row
        $config['per_page'] = 8;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        // Membuat Style pagination
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        //panggil function getAllProducts yang ada pada model Products_model.
        $data['data'] = $this->Products_model->getAllProducts($config["per_page"], $data['page']);
        $data['category'] = $this->Products_model->getCategory();
        $data['pagination'] = $this->pagination->create_links();

        //load view
        $this->load->view('templates/header');
        $this->load->view('contents/products', $data);
        $this->load->view('templates/footer', $data);
    }

    public function contact()
    {
        $this->load->view('templates/header');
        $this->load->view('contents/contact');
        $this->load->view('templates/footer');
    }

    public function aboutUs()
    {
        $this->load->view('templates/header');
        $this->load->view('contents/aboutUs');
        $this->load->view('templates/footer');
    }
    public function category()
    {
        $id = $this->uri->segment('3');
        // //konfigurasi pagination
        // $config['base_url'] = site_url('Kukerhut/products/'.$id); //site url
        // $config['total_rows'] = $this->db->count_all('produk'); //total row
        // $config['per_page'] = 8;  //show record per halaman
        // $config["uri_segment"] = 3;  // uri parameter
        // $choice = $config["total_rows"] / $config["per_page"];
        // $config["num_links"] = floor($choice);

        // // Membuat Style pagination
        // $config['first_link']       = 'First';
        // $config['last_link']        = 'Last';
        // $config['next_link']        = 'Next';
        // $config['prev_link']        = 'Prev';
        // $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        // $config['full_tag_close']   = '</ul></nav></div>';
        // $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        // $config['num_tag_close']    = '</span></li>';
        // $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        // $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        // $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        // $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['prev_tagl_close']  = '</span>Next</li>';
        // $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        // $config['first_tagl_close'] = '</span></li>';
        // $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['last_tagl_close']  = '</span></li>';

        // $this->pagination->initialize($config);
        // $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;


        //panggil function getAllProducts yang ada pada model Products_model.
        $data['data'] = $this->Products_model->getProductsByCat($id);
        //$data['data'] = $this->Products_model->getProductsByCategory('produk', $id, $config["per_page"], $data['page']);
        $data['category'] = $this->Products_model->getCategory();
        $data['pagination_c'] = $this->pagination->create_links();

        //load view
        $this->load->view('templates/header');
        $this->load->view('contents/products', $data);
        $this->load->view('templates/footer', $data);
    }
}
