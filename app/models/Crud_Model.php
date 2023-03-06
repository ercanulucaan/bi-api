<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_Model extends CI_Model
{

    protected $services_table = 'services';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_services($limit, $start, $query)
    {
        $this->db->limit($limit, $start);
        $this->db->like('name', $query);
        $query = $this->db->get($this->services_table);
        return $query->result();
    }

}
