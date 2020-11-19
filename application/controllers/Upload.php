<?php

class Upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->load->view('admin/upload_form/', array('error' => ' '));
    }

    public function uploadFotoProduk($id_produk)
    {
        $config['upload_path']          = './assets/images/fotoProduk/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 1024;
        $config['max_width']            = 1500;
        $config['max_height']           = 1500;

        $this->load->library('upload', $config);
        $data['produk'] = $this->db->get_where('produk', ['id_produk' => $id_produk])->row_array();
        $data['user'] = $this->db->get_where('admin', ['username' => $this->session->userdata('username')])->row_array();

        if (!$this->upload->do_upload('foto_produk')) {
            $data['error'] = $this->upload->display_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert"><a>', '</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            $this->load->view('templates/headerAdmin', $data);
            $this->load->view('admin/upload_form', $data);
            $this->load->view('templates/footerAdmin');
        } else {
            $image = $this->upload->data('file_name');
            $editor = htmlspecialchars($this->input->post('editor', true));
            $this->db->set('foto_produk', $image);
            $this->db->set('editor', $editor);
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Foto Berhasil Di Upload<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> </div>');
            redirect('admin');
        }
    }
}
