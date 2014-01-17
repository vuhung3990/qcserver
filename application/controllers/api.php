<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    public function catalog() {
        $query = $this->db->query("SELECT * FROM `catalog`");
        $json = array();
        foreach ($query->result() as $row) {
            $temp = array(
                'id' => $row->id,
                'name' => $row->name,
                'icon' => $row->icon,
                'contain' => $this->db->where('catalog_id', $row->id)->count_all_results('distributor') . ""
            );
            array_push($json, $temp);
        }
        echo json_encode($json);
    }

    public function distributor($catalog_id = NULL) {
        if (isset($catalog_id)) {
            $query = $this->db->query('SELECT * FROM distributor WHERE catalog_id=' . $catalog_id);
            $json = array();
            foreach ($query->result() as $row) {
                $temp = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'icon' => $row->icon,
                    'contain' => $this->db->where('distributor_id', $row->id)->count_all_results('detail') . ""
                );
                array_push($json, $temp);
            }
            echo json_encode($json);
        } else {
            echo 'Param not set.';
        }
    }

    public function detail($distributor_id = NULL) {
        if (isset($distributor_id)) {
            $query = $this->db->query('SELECT * FROM detail WHERE distributor_id=' . $distributor_id);
            $json = array();
            foreach ($query->result() as $row) {
                $temp = array(
                    'title' => $row->title,
                    'link' => $row->link,
                    'expire' => $row->expiretime
                );
                array_push($json, $temp);
            }
            echo json_encode($json);
        }  else {
            echo 'Param not set.';
        }
    }

}
