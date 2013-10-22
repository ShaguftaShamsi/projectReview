<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class  Start extends  CI_Controller{
   
       
    
    function __construct() {
        parent::__construct();
    }

    
    public function start_up()
    {
        $this->load->view('start_view.html');      
    }
    
    
    }

?>
