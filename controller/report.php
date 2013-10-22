


<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Report extends CI_Controller{

    function  show()
    {
       
       $this->load->view('report_view');
   }
    /*Get all Workspace of a particular user on the bases of u_id
     * @access public
     * 
     */
 
    function show_more_wp()
    {
        $this->load->model('report_model');
        $data['more_wp'] = $this->report_model->get_workspace();
        echo json_encode($data);
      
} 
        
}
?>
