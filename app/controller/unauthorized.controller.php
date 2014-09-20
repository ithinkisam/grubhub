<?php

/**
 *  Main controller to manage index page.
 *
 *  @since 1.0.0
 */
class UnauthorizedController extends BaseController {
    
    /**
     *  See BaseController.index()
     */
    public function index() {
        // set up template variables
        $this->registry->template->bodyClass = 'landing-page';
        
        // show views
        $this->registry->template->show('_header');
        $this->registry->template->show('unauthorized');
        $this->registry->template->show('_footer.guest');
    }

}

?>
