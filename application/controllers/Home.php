<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('M_produk','User','M_dashboard')); 
    }

    public function index()
    {
        $data['loginURL'] = $this->google->loginURL();
        $this->template->load('template_front','home/home',$data);  
    }

    public function about()
    {
        $data['loginURL'] = $this->google->loginURL();
        $this->template->load('template_front','home/about',$data);  
    }

    public function kontak()
    {
        $data['loginURL'] = $this->google->loginURL();
        $this->template->load('template_front','home/kontak',$data);  
    }

    public function rekomendasi()
    {
        if($this->session->userdata('id') == ''){
            redirect('home/register');
        }else{
            $this->template->load('template_front','home/rekomendasi');
        }
    }

    public function kategori()
    {
        $data['loginURL'] = $this->google->loginURL();
        $this->template->load('template_front','produk/kategori',$data);  
    }

    public function produk()
    {
        $bidder = $this->session->userdata('id');
        $id             = $this->uri->segment(4);
        $url_kategori   = $this->uri->segment(3);
        $user           = $this->session->userdata('id');
        $data['loginURL'] = $this->google->loginURL();
        $data['record'] = $this->M_produk->detail_produk($id)->row_array();
        if($bidder != ''){
            //untuk menambahkan jumlah barang yang di klik
            $sql_kategori = $this->db->query("SELECT * FROM abe_kategori where url_kategori = '$url_kategori'")->row_array();
            $id_kategori = $sql_kategori['id_kategori'];
            //menambah klik
            $query = $this->db->query("SELECT MAX(jumlah_klik) as max_klik, id_kategori_klik FROM abe_kategori_klik WHERE id_bidder = '$user' AND id_kategori = '$id_kategori'")->row_array();
            $query2 =  $this->db->query("SELECT * FROM abe_kategori_klik WHERE id_bidder = '$user' AND id_kategori = '$id_kategori'")->num_rows();
            $max_id     = $query['max_klik'];
            $id_klik    = $query['id_kategori_klik'];
            //$max_id1 = substr($max_id,-4);
            $jumlah = $max_id + 1;

            $data2 = array(
                'id_bidder'     => $user,
                'id_kategori'   => $id_kategori,
                'jumlah_klik'   => $jumlah,
                'url_kategori'  => $url_kategori,
            );
            $data3 = array(
                'jumlah_klik'   => $jumlah
            );
            if($query2 == '1'){
                $this->M_produk->update_klik(array('id_kategori_klik' => $id_klik), $data3);
            }else{
                $this->M_produk->add_klik($data2);
            }
        }
        $this->template->load('template_front','produk/detail', $data); 
    }
    
    public function register(){
        //redirect to profile page if user already logged in
        if($this->session->userdata('loggedIn') == true){
            redirect('home');
        }
        
        if(isset($_GET['code'])){
            //authenticate user
            $this->google->getAuthenticate();
            
            //get user info from google
            $gpInfo = $this->google->getUserInfo();
            
            //preparing data for database insertion
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid']      = $gpInfo['id'];
            $userData['first_name']     = $gpInfo['given_name'];
            $userData['last_name']      = $gpInfo['family_name'];
            $userData['email']          = $gpInfo['email'];
            //$userData['gender']         = !empty($gpInfo['gender'])?$gpInfo['gender']:'';
            $userData['locale']         = !empty($gpInfo['locale'])?$gpInfo['locale']:'';
            $userData['profile_url']    = !empty($gpInfo['link'])?$gpInfo['link']:'';
            $userData['picture_url']    = !empty($gpInfo['picture'])?$gpInfo['picture']:'';
            
            //insert or update user data to the database
            $userID = $this->User->checkUser($userData);
            
            //store status & user info in session
            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata('userData', $userData);

            //membuat session di luar google
            $email = $userData['email'];
            $oauth_uid = $userData['oauth_uid'];
            $result = $this->User->cekLogin($email, $oauth_uid);
            $this->session->set_userdata($result);
            //redirect to profile page
            redirect('home');
        } 
        
        //google login url
        $data['loginURL'] = $this->google->loginURL();
        
        //load google login view
        $this->template->load('template_front','home/register',$data);
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = MD5($this->input->post('password'));
        
        $result = $this->User->cekLogin2($email, $password);
        if ($result == 0) {
            $this->session->set_flashdata('gagal','username / password anda salah');
            redirect('home/register');            
        }else{
            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata($result);
            //$this->session->set_flashdata('berhasil','Terimakasih');
            redirect('home');
        }
    }

    public function logout(){
        //delete login status & user info from session
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        
        //redirect to login page
        redirect('/home/'); 
    }

    public function bidder()
    {
        date_default_timezone_set('Asia/Jakarta');
        $harga      = $this->input->post('harga');
        $id_barang  = $this->input->post('barang');
        $kategori   = $this->input->post('kategori');
        $id_kategori= $this->input->post('id_kategori');
        $user       = $this->session->userdata('id');
        $status     = 'pending';
        $date       = date('Y-m-d H:i:s');

        $data = array(
            'id_barang' => $id_barang,
            'id_bidder' => $user,
            'id_kategori' => $id_kategori,
            'harga_lelang' => $harga,
            'status'    => $status,
            'tanggal'   => $date,
        );
        //tambahkan akun ke database
        $this->M_produk->add_penawaran($data);
        $this->session->set_flashdata('sukses','Penawaran Anda berhasil di tambahkan<br>Terimakasih');
        redirect('home/produk/'.$kategori.'/'.$id_barang);
    }









}
