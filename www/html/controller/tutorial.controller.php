<?php

/**
 *  This controller serves the tutorials page seen by guests.
 *
 *  @since 1.0.0
 */
class TutorialController extends BaseController {

    /**
     *
     */
    public function index() {
        
        // TODO
    
        $this->registry->template->show('_header.guest');
        $this->registry->template->show('tutorial');
        $this->registry->template->show('_footer.guest');
    }

}

?>