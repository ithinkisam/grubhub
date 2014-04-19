<?php

abstract class RecipeImporter extends ObjectBase {
    
    public abstract function getRecipe();
    public abstract function getUrl();
    public abstract function setUrl($url);
    public abstract function getSiteName();
    public abstract function getSiteLogo();
    
    public function getRecipePage($recipe_url) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTMLFile($recipe_url);
        foreach (libxml_get_errors() as $error) {
            $error = true;
        }
        libxml_clear_errors();
        $doc->preserveWhiteSpace = false;
        return $doc;
    }
    
    public function replaceSpecial($string) {
        $chucked = str_split($string, 1);
        $string = "";
        foreach ($chunked as $chunk) {
            $num = ord($chunk);
            if ($num >= 32 && $num <= 123) {
                $string .= $chunk;
            }
        }
        return $string;
    }
    
}
