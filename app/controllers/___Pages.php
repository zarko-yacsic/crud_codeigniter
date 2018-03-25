<?php
class Pages extends CI_Controller {

    public function view($page = 'home')
    {
    	if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
	    {
	    	show_404(); // Whoops, we don't have a page for that!
	    }
	    $this->load->view('templates/header');
		$this->load->view('pages/home');
		$this->load->view('templates/footer');
    }
}