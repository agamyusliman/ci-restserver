<?php 

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Produk extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model', 'produk');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if($id == null){
            $produk = $this->produk->getProduk();
        }else{
            $produk = $this->produk->getProduk($id);
        }
        if ($produk) {
            $this->response([
                'status' => true,
                'message' => $produk
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'id produk tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if($id == null){ 
            $this->response([
                'status' => false,
                'message' => 'harap masukkan id produk !'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            if($this->produk->deleteProduk($id) > 0){
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'produk berhasil dihapus'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'id produk tidak ditemukan'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nama_produk'   => $this->post('nama_produk'),
            'tipe_produk'   => $this->post('tipe_produk'),
            'harga'         => $this->post('harga'),
            'stok'          => $this->post('stok')
        ];

        if($this->produk->createProduk($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'produk baru berhasil dibuat'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => 'gagal membuat produk baru'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id =  $this->put('id');
        $data = [
            'nama_produk'   => $this->put('nama_produk'),
            'tipe_produk'   => $this->put('tipe_produk'),
            'harga'         => $this->put('harga'),
            'stok'          => $this->put('stok')
        ];

        if($this->produk->updateProduk($data, $id) > 0){
            $this->response([
                'status' => true,
                'message' => 'data produk berhasil diperbarui'
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'data produk gagal diperbarui'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}