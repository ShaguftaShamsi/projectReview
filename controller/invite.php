<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Invite extends CI_Controller{
   
    
     function __construct() {
        parent::__construct();
        $this->load->model('invite_model');
    }

    public function index( )
    { 
        $this->load->view('invite_view.html');
    }
    
    function invite_members()
    {
        $config=array(
      'protocol'=>'smtp',
      'smtp_host'=>'mail.finaltier.com',
     //'smtp_host'=>'mail.gmail.com',
     'smtp_port'=>25,
      'smtp_user'=>'shagufta.shamsi@finaltier.com',
     'smtp_pass'=>"WorkLoad100",
   //   'smtp_user'=>'shagufta_shamsi@yahoo.com',
     // 'smtp_pass'=>"asdfghjkl;'",
      'mailtype' => 'html',
    );
       
         $data=$this->invite_model->get_token();
         $data=array('invitee'=> $this->input->post('email'),'token'=>$data['token']);
         $this->session->set_userdata($data);
         if( $this->invite_model->check_status($this->session->userdata('invitee')))
             $data['url']='http://localhost/ci/index.php/tracking/index/login/token=$data["token"]';
         else 
             $data['url']='http://localhost/ci/index.php/tracking/index/signup/token=$data["token"]'; 
         $this->load->library('email',$config);
         $this->email->from($this->session->userdata('email'),$this->session->userdata('name'));
         $this->email->to ($this->input->post('email'));
         print_r($this->session->all_userdata());
         $msg =  $this->load->view('mail_content.html',$data,true);
         $this->email->message($msg);
         $this->email->set_newline("\r\n");
      //  $this->email->attach('D:\Software\wamp\www\ci\application\Jellyfish.jpg');
            if( !$this->email->send()){
                show_error($this->email->print_debugger()); 
            }
            else {
                echo " A test Email is sent to ur id";
            }
    }
   
 }
?>
