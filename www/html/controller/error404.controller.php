<?php

/**
 *  Error handling controller.
 *
 *  @since 1.0.0
 */
class Error404Controller extends BaseController {

    /**
     *  See BaseController.index()
     */
    public function index() {
        $this->registry->template->heading = 'This is the 404';
        $this->registry->template->show('error404');
    }

}

?>