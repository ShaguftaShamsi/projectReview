<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class  Workspace extends CI_Controller{
    
       function __construct()
    {
        parent::__construct();
        $this->load->model("workspace_model");
       
    }

    function index()
    {
        if (isset($_POST['create_wp']))
         {
           $data['worksp_name']=$this->input->post('add_wp');
           $this->load->view('workspace_view_edit.html',$data);
         }
        else
        $this->load->view('workspace_view.html'); 
    }
    
    function save()
    {
          
          if( $value == 'Invite new member')
          {
            redirect('invite');   
          }
          else
          {
             $data['add_new_wp']=$this->input->post('add_new_wp');
             $this->workspace_model->save_workspace($data);
             $this->load->view('workspace_view_edit.html',$data);
          }
        
    }
}  
?>