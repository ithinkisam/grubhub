<?php

/**
 *  Initializes the application context.
 *
 *  @since 1.0.0
 */

// include the controller class
include __SITE_PATH . '/application/' . 'controller_base.class.php';

// include the registry class
include __SITE_PATH . '/application/' . 'registry.class.php';

// include the router class
include __SITE_PATH . '/application/' . 'router.class.php';

// include the template class
include __SITE_PATH . '/application/' . 'template.class.php';

// include the filter class
include __SITE_PATH . '/application/' . 'filter.class.php';

// auto load model classes
function __autoload($class_name) {
    $filename = strtolower($class_name) . '.class.php';
    
    $objPaths = array("/com/grubhub/",
                      "/com/grubhub/config/",
                      "/com/grubhub/dao/",
                      "/com/grubhub/domain/",
                      "/com/grubhub/exception/",
                      "/com/grubhub/filter/",
                      "/com/grubhub/importer/",
                      "/com/grubhub/interface/",
                      "/com/grubhub/mapper/",
                      "/com/grubhub/security/",
                      "/com/grubhub/utils/"
                    );
                    
    foreach ($objPaths as $path) {
        $file = __SITE_PATH . '/model' . $path . $filename;
        if (file_exists($file) !== false) {
            include ($file);
            return true;
        }
    }
    return false;
}

?>