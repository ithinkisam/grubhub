<?php

/**
 *  This configuration class defines message codes.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class MessageConfig extends ObjectBase {

    /** 100s **/
    
    /** 200s **/
    
    /** 300s **/
    
    /** 400s **/
    const USER_ERROR_ADD = 400;
    const USER_INVALID_USERNAME = 401;
    const USER_INVALID_PASSWORD = 402;
    const USER_PASSWORD_NOT_FOUND = 404;
    const USER_NOT_FOUND = 405;
    const USER_INVALID_SHARE_KEY = 406;
    
    const USER_ERROR_DELETE = 420;
    
    const HUB_ERROR_ADD = 430;
    const HUB_ERROR_EDIT = 431;
    const HUB_ERROR_DELETE = 432;
    
    const RECIPE_ERROR_ADD = 440;
    const RECIPE_ERROR_EDIT = 441;
    const RECIPE_ERROR_DELETE = 442;
    
    const HUB_ERROR_ADD_RECIPE = 443;
    const HUB_ERROR_REMOVE_RECIPE = 444;
    
    const RECIPE_NOT_FOUND = 445;
    
    const RECIPE_ERROR_ADD_INGREDIENT = 450;
    const RECIPE_ERROR_ADD_DIRECTION = 452;
    const RECIPE_ERROR_ADD_COMMENT = 453;
    const RECIPE_ERROR_ADD_KEYWORD = 454;
    const RECIPE_ERROR_ADD_NOTE = 455;
    const RECIPE_ERROR_ADD_NUTRITION_FACT = 456;
    
    const RECIPES_NOT_FOUND = 461;
    
    const HUB_ERROR_RETRIEVING = 463;
    const HUB_ERROR_RETRIEVING_UNCAT_RECIPES = 464;
    const HUB_ERROR_RETRIEVING_RECIPE_HUBS = 470;
    
    /** 500s **/
    const USER_NOT_AUTHENTICATED = 500;
    const USER_NOT_AUTHENTICATED_MISSING_USER = 501;
    const USER_NOT_AUTHENTICATED_MISSING_USERNAME = 502;
    const USER_NOT_AUTHENTICATED_MISSING_PASSWORD = 503;
    const USER_NOT_AUTHORIZED = 510;
    const USER_INSUFFICIENT_PRIVILEDGES = 520;

}
