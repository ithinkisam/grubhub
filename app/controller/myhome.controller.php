<?php

/**
 *  Main controller to manage index page.
 *
 *  @since 1.0.0
 */
class MyHomeController extends BaseController {
    
    /**
     *  See BaseController.index()
     */
    public function index() {
        // set up template variables
        $this->registry->template->bodyClass = '';
        
        // show views
        $this->registry->template->show('_header');
        $this->registry->template->show('_nav.user');
        $this->registry->template->show('search');
        $this->registry->template->show('home');
        $this->registry->template->show('_footer.user');
    }

}

?>
