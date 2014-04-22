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
        // Determine whether the the user is logged in and direct
        // them accordingly
        $sec = new SecurityManager();
        if ($sec->checkAdmin($_SESSION)) {
            $this->handleUser();
        } else if ($sec->checkUserA($_SESSION)) {
            $this->handleUser();
        } else {
            $this->handleGuest();
        }
    }
    
    private function handleGuest() {
        // set up template variables
        $this->registry->template->bodyClass = 'landing-page';
        
        // show views
        $this->registry->template->show('_header');
        $this->registry->template->show('_nav.guest');
        $this->registry->template->show('index');
        $this->registry->template->show('_footer.guest');
    }
    
    private function handleUser() {
        // set up template variables
        $this->registry->template->bodyClass = '';
        
        // show views
        $this->registry->template->show('_header');
        $this->registry->template->show('_nav.user');
        $this->registry->template->show('home');
        $this->registry->template->show('_footer.user');
    }
    
    // TODO
    private function handleAdmin() {
        // set up template variables
        $this->registry->template->bodyClass = '';
        
        // show views
        $this->registry->template->show('_header');
        $this->registry->template->show('_nav.user');
        $this->registry->template->show('home');
        $this->registry->template->show('_footer.user');
    }
    
}

?>
