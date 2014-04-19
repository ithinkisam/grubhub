<?php

/**
 *  This controller serves the "home" page seen by users immediately
 *  after login.
 *
 *  @since 1.0.0
 */
class MyHomeController extends BaseController {

    /**
     *
     */
    public function index() {
        
        // TODO
    
        $this->registry->template->show('_header.user');
        $this->registry->template->show('myhome');
        $this->registry->template->show('_footer.user');
    }

}

?>