<?php

/**
 *  This controller serves the signup page seen by guests.
 *
 *  @since 1.0.0
 */
class SignUpController extends BaseController {

    /**
     *
     */
    public function index() {
        
        // set up template variables
        $this->registry->template->bodyClass = '';
        
        // show views
        $this->registry->template->show('_header');
        $this->registry->template->show('_nav.guest');
        $this->registry->template->show('signup');
        $this->registry->template->show('_footer.guest');
    }

}

?>