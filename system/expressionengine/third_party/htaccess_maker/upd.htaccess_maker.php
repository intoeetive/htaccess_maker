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
 File: upd.htaccess_maker.php
-----------------------------------------------------
 Purpose: Create .htaccess file from EE template
=====================================================
*/

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

require_once PATH_THIRD.'htaccess_maker/config.php';

class Htaccess_maker_upd {

    var $version = HTACCESS_MAKER_ADDON_VERSION;
    
    function __construct() { 
        // Make a local reference to the ExpressionEngine super object 
        $this->EE =& get_instance(); 
    } 
    
    function install() { 
 
        $data = array( 'module_name' => 'Htaccess_maker' , 'module_version' => $this->version, 'has_cp_backend' => 'y' ); 
        $this->EE->db->insert('modules', $data); 
        
        return TRUE; 
        
    } 
    
    function uninstall() { 

        $this->EE->db->select('module_id'); 
        $query = $this->EE->db->get_where('modules', array('module_name' => 'Htaccess_maker')); 
        
        $this->EE->db->where('module_id', $query->row('module_id')); 
        $this->EE->db->delete('module_member_groups'); 
        
        $this->EE->db->where('module_name', 'Htaccess_maker'); 
        $this->EE->db->delete('modules'); 
        
        $this->EE->db->where('class', 'Htaccess_maker'); 
        $this->EE->db->delete('actions'); 
        
        return TRUE; 
    } 
    
    function update($current='') { 
        if ($current < 2.0) { 
            // Do your 2.0 version update queries 
        } if ($current < 3.0) { 
            // Do your 3.0 v. update queries 
        } 
        return TRUE; 
    } 
	

}
/* END */
?>