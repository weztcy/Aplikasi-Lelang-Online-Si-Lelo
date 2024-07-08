<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produk extends CI_Model {

    var $foto_produk = 'abe_foto_produk';
    var $produk = 'abe_produk';

    public function detail_produk($id)
    {
        $param = array('id_produk' => $id);
        return $this->db->get_where('abe_produk',$param);
    }

    function add_penawaran($data)
    {
        $this->db->insert('abe_lelang_bidder',$data);
        return $this->db->insert_id();
    }

    function add_klik($data)
    {
        $this->db->insert('abe_kategori_klik',$data);
        return $this->db->insert_id();
    }

    function update_klik($where, $data)
    {
        $this->db->update('abe_kategori_klik', $data, $where);
        return $this->db->affected_rows();
    }
}