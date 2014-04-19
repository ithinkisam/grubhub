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
        
        // TODO
        
        $this->registry->template->show('_header.guest');
        $this->registry->template->show('signup');
        $this->registry->template->show('_footer.guest');
    }

}

?>