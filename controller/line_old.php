<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Line_old extends CI_Controller {

    public function index() {
        $this->load->view('line_view');
    }

    public function line_plot() {
        $this->load->model('line_model_old');
        $data = $this->line_model_old->line_data();
        $data['line_graph'] = $data['plot'];
        $data['plotting_data'] = $data['plotting_line'];
        $arr = array();
        $result = array();
        foreach ($data['plotting_data'] as $row) {
            $arr = explode(':', $row->difftime);
            $arr[2] = null;
            $arr[0] = ltrim($arr[0], '0');
            $arr[1] = ltrim($arr[1], '0');
            if ($arr[0] == 0)
                $row->tooltip_time = '0h ' . $arr[1] . 'm';
            else
                $row->tooltip_time = $arr[0] . 'h ' . $arr[1] . 'm';
            //echo ' befre Multiply results'.$arr[1];
            $arr[1] = $arr[1] * 1.67;
            //echo 'Multiply results'.$arr[1];
            $arr2 = explode('.', $arr[1]);
            //var_dump($arr2);
            $arr[1] = $arr2[0];
            $output = array_slice($arr, 0, 2);
            $row->difftime = implode('.', $output);
            //var_dump($row);
        }
        //var_dump($data);
        $this->load->view('report_view', $data);
    }

}

?>
