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
 File: ext.htaccess_maker.php
-----------------------------------------------------
 Purpose: Create .htaccess file from EE template
=====================================================
*/

if ( ! defined('EXT'))
{
	exit('Invalid file request');
}

class Htaccess_maker_ext {

	var $name	     	= '.htaccess maker';
	var $version 		= '1.1.0';
	var $description	= 'Create .htaccess file from EE template';
	var $settings_exist	= 'y';
	var $docs_url		= 'http://www.intoeetive.com/docs/htaccess_maker.html';
    
    var $settings 		= array();

    
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	function __construct($settings = '')
	{
		$this->EE =& get_instance();
        $this->settings = $settings;
        $this->EE->lang->loadfile('htaccess_maker');
	}
    
    /**
     * Activate Extension
     */
    function activate_extension()
    {
        
        $hooks = array(
    		array(
    			'hook'		=> 'update_template_end',
    			'method'	=> 'make',
    			'priority'	=> 10
    		)
    	);
    	
        foreach ($hooks AS $hook)
    	{
    		$data = array(
        		'class'		=> __CLASS__,
        		'method'	=> $hook['method'],
        		'hook'		=> $hook['hook'],
        		'settings'	=> '',
        		'priority'	=> $hook['priority'],
        		'version'	=> $this->version,
        		'enabled'	=> 'y'
        	);
            $this->EE->db->insert('extensions', $data);
    	}	
        

    }
    
    /**
     * Update Extension
     */
    function update_extension($current = '')
    {
    	if ($current == '' OR $current == $this->version)
    	{
    		return FALSE;
    	}
    	
    	if ($current < '2.0')
    	{
    		// Update to version 1.0
    	}
    	
    	$this->EE->db->where('class', __CLASS__);
    	$this->EE->db->update(
    				'extensions', 
    				array('version' => $this->version)
    	);
    }
    
    
    /**
     * Disable Extension
     */
    function disable_extension()
    {
    	$this->EE->db->where('class', __CLASS__);
    	$this->EE->db->delete('extensions');        
                    
    }
    
    
    function settings()
    {
        $settings = array();
        
        $templates = array();
        $templates[''] = '-';
        $this->EE->db->select('group_id, group_name');
        $this->EE->db->where('site_id', $this->EE->config->item('site_id'));
        $this->EE->db->order_by('group_order', 'asc');
        $groups_q = $this->EE->db->get('template_groups');
        foreach($groups_q->result_array() as $group)
        {
            //$templates[$group['group_name']] = array();
            $this->EE->db->select('template_id, template_name');
            $this->EE->db->where('group_id', $group['group_id']);
            $this->EE->db->where('site_id', $this->EE->config->item('site_id'));
            $this->EE->db->order_by('template_name', 'asc');
            $tmpl_q = $this->EE->db->get('templates');
            foreach($tmpl_q->result_array() as $tmpl)
            {
                //$templates[$group['group_name']][$tmpl['template_id']] = $tmpl['template_name'];
                $templates[$tmpl['template_id']] = $group['group_name'].'/'.$tmpl['template_name'];
            }
        }
    
        $settings['htaccess_path']    = "";
        $settings['htaccess_template']    = array('s', $templates, '');
        
        return $settings;
    }
        
    
    function make()
    {
    	if ( ! class_exists('Htaccess_maker_mcp'))
    	{
    		require_once PATH_THIRD.'htaccess_maker/mcp.htaccess_maker.php';
    	}
    	
    	$HM = new Htaccess_maker_mcp();
        
        return $HM->make(true);
    }


  

}
// END CLASS
