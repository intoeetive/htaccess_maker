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
 File: mcp.htaccess_maker.php
-----------------------------------------------------
 Purpose: Create .htaccess file from EE template
=====================================================
*/

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}



class Htaccess_maker_mcp {

    var $version = '1.1.0';
    
    function __construct() { 
        // Make a local reference to the ExpressionEngine super object 
        $this->EE =& get_instance(); 
        $this->EE->db->select('settings');
        $this->EE->db->where('class', 'Htaccess_maker_ext');
        $this->EE->db->limit(1);
        $query = $this->EE->db->get('extensions');
        $this->settings = unserialize($query->row('settings')); 
    } 
    
    function index()
    {
        $vars = array();
        if (empty($this->settings['htaccess_path']) || empty($this->settings['htaccess_template']))
        {
            $vars['need_settings'] = $this->EE->lang->line('need_settings');
        }
        else
        {
            $vars['need_settings'] = false;
            $vars['link'] = "<a href=\"".BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=htaccess_maker'.AMP.'method=make'."\">".$this->EE->lang->line('generate')."</a>";
        }
        return $this->EE->load->view('index', $vars, TRUE);
    }
    
    function make($ext_call=false)
    {
        if (empty($this->settings['htaccess_path']) || empty($this->settings['htaccess_template']))
        {
            return;
        }
        
        // we want to parse the template and take its output
        // http://expressionengine.com/forums/viewthread/170249/
        
        $this->EE->db->select('group_name, template_name');
        $this->EE->db->from('templates');
        $this->EE->db->join('template_groups', 'templates.group_id=template_groups.group_id');
        $this->EE->db->where('template_id', $this->settings['htaccess_template']);
        $tmpl_q = $this->EE->db->get();
        
        $this->EE->load->library('template');
        $this->EE->TMPL = $this->EE->template;

        $this->EE->TMPL->fetch_and_parse($tmpl_q->row('group_name'), $tmpl_q->row('template_name'));
        $output = $this->EE->TMPL->parse_globals($this->EE->TMPL->final_template); 
        
        $this->EE->db->select('site_pages, site_id');
		$this->EE->db->where('site_id', $this->EE->config->item('site_id'));
		$query = $this->EE->db->get('sites');

		$pages = '';
        $site_pages = $this->EE->config->item('site_pages');
        $i = $this->EE->config->item('site_id');
        foreach ($site_pages[$i]['uris'] as $page)
        {
            $pages .= trim($page, '/')."|";
        }
        $pages .= 'htaccess_maker_fake_page';
        
        $output = $this->EE->TMPL->swap_var_single('site_pages', $pages, $output);

        if ( ! $fp = @fopen($this->settings['htaccess_path'], FOPEN_WRITE_CREATE_DESTRUCTIVE))
		{
			$this->EE->session->set_flashdata('message_failure', $this->EE->lang->line('htaccess_fail'));
		}
		else
		{
			flock($fp, LOCK_EX);
			fwrite($fp, $output);
			flock($fp, LOCK_UN);
			fclose($fp);
			
			@chmod($this->settings['htaccess_path'], FILE_WRITE_MODE); 
            
            $this->EE->session->set_flashdata('message_success', $this->EE->lang->line('htaccess_success'));
		} 
        
        if ($ext_call == false)
        {
            $this->EE->functions->redirect(BASE.AMP.'C=addons_modules');
        }
        else
        {
            return true;    
        }     
	
    }    
    


    
   
    

}
/* END */
?>