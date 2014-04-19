<?php

/**
 *  Main controller to manage index page.
 *
 *  @since 1.0.0
 */
class IndexController extends BaseController {
    
    /**
     *  See BaseController.index()
     */
    public function index() {
        // set a template variable
        $this->registry->template->welcome = 'Welcome to The Grub Hub!';
        
        // load the index template
        $this->registry->template->show('_header.guest');
        $this->registry->template->show('index');
        $this->registry->template->show('_footer.guest');
    }
    
}

?>