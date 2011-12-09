<?php

/*
=====================================================
 .htaccess maker
-----------------------------------------------------
 http://www.intoeetive.com/
-----------------------------------------------------
 Copyright (c) 2011 Yuri Salimovskiy
 Lecensed under MIT License
 http://www.opensource.org/licenses/mit-license.php
=====================================================
 This software is based upon and derived from
 ExpressionEngine software protected under
 copyright dated 2004 - 2011. Please see
 http://expressionengine.com/docs/license.html
=====================================================
 File: mod.htaccess_maker.php
-----------------------------------------------------
 Purpose: Create .htaccess file from EE template
=====================================================
*/


if ( ! defined('EXT'))
{
    exit('Invalid file request');
}


class Htaccess_maker {

    var $return_data	= ''; 						// Bah!

    /** ----------------------------------------
    /**  Constructor
    /** ----------------------------------------*/

    function __construct()
    {        
    	$this->EE =& get_instance(); 
    }
    /* END */


}
/* END */
?>