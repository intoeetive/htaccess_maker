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
 This software is intended for usage with
 ExpressionEngine CMS, version 2.0 or higher
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