<?php

/**
 *  This class serves as a template for creating recipe cards
 *  for display on a webpage.
 *
 *  Change History:
 *      02/02/2014 (SDB) - Initial creation
 *      03/08/2014 (SDB) - Main implementation
 */
class RecipeCardTemplate extends ObjectBase implements I_Template {

    private $_name_STR;
    private $_description_STR;
    private $_imageUrl_STR;
    private $_keywordList_STR;
    private $_servingSize_RNG;
    private $_prepTime_TIM;
    private $_cookTime_TIM;
    private $_totalTime_TIM;
    private $_rating_INT;
    private $_externalUrl_STR;
    private $_viewUrl_STR;
    private $_editUrl_STR;
    private $_shareUrl_STR;
    private $_printUrl_STR;
    
    function __construct() {
        
    }
    
    public function compile() {
        $name = $this->getName();
        $description = $this->getDescription();
        $imageUrl = $this->getImageUrl();
        $keywords = $this->getKeywordList();
        $servingSize = $this->getServingSize()->getIntegral();
        $prepTime = $this->getPrepTime()->getRange()->getIntegral() . " " . $this->getPrepTime()->getUnitString();
        $cookTime = $this->getCookTime()->getRange()->getIntegral() . " " .  $this->getCookTime()->getUnitString();;
        $totalTime = $this->getTotalTime()->getRange()->getIntegral() . " " . $this->getTotalTime()->getUnitString();;
        $rating = $this->getRating();
        $externalUrl = $this->getExternalUrl();
        $viewUrl = $this->getViewUrl();
        $editUrl = $this->getEditUrl();
        $shareUrl = $this->getShareUrl();
        $printUrl = $this->getPrintUrl();
        
        $ratingString = "";
        for ($i = 5; $i > 0; $i--) {
            if ($i < $rating) {
                $ratingString .= '<i class="fa fa-star"></i>';
            } else {
                $ratingString .= '<i class="fa fa-star-o"></i>';
            }
        }
    
        $r = <<<EOF
        <div class='row recipe-card'>
            <div class="col-md-8 pull-right details">
                <h1>$name</h1>
                <div class="rating">
                    $ratingString
                </div>
                <p class="description">$description</p>
                <p class="time">
                    <span class="prep">Prep: $prepTime</span>
                    |
                    <span class="total">Total: $totalTime</span>
                    <br>
                    <span class="yield">Yield: Feeds $servingSize</span>
                </p>
                <p class="social">
                    <a href="http://www.pinterest.com/pin/create/button/?url=$shareUrl"
                            target="_blank" title="Pinterest Share">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-pinterest fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=$shareUrl"
                            target="_blank" title="Facebook Share">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="https://twitter.com/share?text=$nameEncoded&url=$shareUrl"
                            target="_blank" title="Twitter Share">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="https://plus.google.com/share?url=$shareUrl"
                            target="_blank" title="Google Plus Share">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="mailto:" target="_blank" title="Email Share">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="$printUrl" target="_blank" title="Print">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-print fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </p>
                <p>
                    <a href="$viewUrl" class="btn btn-info"><i class="fa fa-cutlery fa-fw"></i> View</a>
                    <a href="$editUrl" class="btn btn-success"><i class="fa fa-edit fa-fw"></i> Edit</a>
                </p>
            </div>
            <div class="col-md-4 pull-left image">
                <img class="img-responsive" src="$imageUrl" alt="$name" />
            </div>
        </div>
EOF;
        return $r;
    }
    
    public function getName() {
        return $this->_name_STR;
    }
    
    public function setName($name) {
        parent::verifyType($name, "string");
        $this->_name_STR = $name;
    }
    
    public function getDescription() {
        return $this->_description_STR;
    }
    
    public function setDescription($description) {
        parent::verifyType($description, "string");
        $this->_description_STR = $name;
    }
    
    public function getImageUrl() {
        return $this->_imageUrl_STR;
    }
    
    public function setImageUrl($imageUrl) {
        parent::verifyType($imageUrl, "string");
        $this->_imageUrl_STR = $imageUrl;
    }
    
    public function getKeywordList() {
        return $this->_keywordList_STR;
    }
    
    public function setKeywordList($keywordList) {
        parent::verifyType($keywordList, "array", "string");
        $this->_keywordList_STR = $keywordList;
    }
    
    public function getServingSize() {
        return $this->_servingSize_RNG;
    }
    
    public function setServingSize($servingSize) {
        parent::verifyType($servingSize, "Range");
        $this->_servingSize_RNG = $servingSize;
    }
    
    public function getPrepTime() {
        return $this->_prepTime_TIM;
    }
    
    public function setPrepTime($prepTime) {
        parent::verifyType($prepTime, "Time");
        $this->_prepTime_TIM = $prepTime;
    }
    
    public function getCookTime() {
        return $this->_cookTime_TIM;
    }
    
    public function setCookTime($cookTime) {
        parent::verifyType($cookTime, "Time");
        $this->_cookTime_TIM = $cookTime;
    }
    
    public function getTotalTime() {
        return $this->_totalTime_TIM;
    }
    
    public function setTotalTime($totalTime) {
        parent::verifyType($totalTime, "Time");
        $this->_totalTime_TIM = $totalTime;
    }
    
    public function getRating() {
        return $this->_rating_INT;
    }
    
    public function setRating($rating) {
        parent::verifyType($rating, "integer");
        $this->_rating_INT = $rating;
    }
    
    public function getExternalUrl() {
        return $this->_externalUrl_STR;
    }
    
    public function setExternalUrl($externalUrl) {
        parent::verifyType($externalUrl, "string");
        $this->_externalUrl_STR = $externalUrl;
    }
    
    public function getViewUrl() {
        return $this->_viewUrl_STR;
    }
    
    public function setViewUrl($viewUrl) {
        parent::verifyType($viewUrl, "string");
        $this->_viewUrl_STR = $viewUrl;
    }
    
    public function getEditUrl() {
        return $this->_editUrl_STR;
    }
    
    public function setEditUrl($editUrl) {
        parent::verifyType($editUrl, "string");
        $this->_editUrl_STR = $editUrl;
    }
    
    public function getShareUrl() {
        return $this->_shareUrl_STR;
    }
    
    public function setShareUrl($shareUrl) {
        parent::verifyType($shareUrl, "string");
        $this->_shareUrl_STR = $shareUrl;
    }
    
    public function getPrintUrl() {
        return $this->_printUrl_STR;
    }
    
    public function setPrintUrl($printUrl) {
        parent::verifyType($printUrl, "string");
        $this->_printUrl_STR = $printUrl;
    }
    
    public function __toString() {
        $fields = array();
        $fields["name"] = $this->getName();
        $fields["description"] = $this->getDescription();
        $fields["imageUrl"] = $this->getImageUrl();
        $fields["keywordList"] = $this->getKeywordList();
        $fields["servingSize"] = $this->getServingSize();
        $fields["prepTime"] = $this->prepTime();
        $fields["cookTime"] = $this->cookTime();
        $fields["totalTime"] = $this->totalTime();
        $fields["rating"] = $this->getRating();
        $fields["externalUrl"] = $this->getExternalUrl();
        $fields["viewUrl"] = $this->getViewUrl();
        $fields["editUrl"] = $this->getEditUrl();
        $fields["shareUrl"] = $this->getShareUrl();
        $fields["printUrl"] = $this->getPrintUrl();
        return $fields;
    }
    
}
