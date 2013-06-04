<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Halogy
 *
 * A user friendly, modular content management system for PHP 5.0
 * Built on CodeIgniter - http://codeigniter.com
 *
 * @package		Halogy
 * @author		Haloweb Ltd
 * @copyright	Copyright (c) 2012, Haloweb Ltd
 * @license		http://halogy.com/license
 * @link		http://halogy.com/
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

class Sites_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		
		// get siteID, if available
		if (defined('SITEID'))
		{
			$this->siteID = SITEID;
		}
	}

	function get_sites($search = '')
	{			
		if ($search)
		{
			$search = $this->db->escape_like_str($search);
			
			$this->db->where('(siteDomain LIKE "%'.$search.'%" OR siteName LIKE "%'.$search.'%")');
		}
			
		$query = $this->db->get('sites');

		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	function get_quota($siteID)
	{
		// get image quota
		$this->CI->db->where('siteID', $this->config['siteID']);
		$this->CI->db->select('SUM(filesize) as quota');
		$query = $this->CI->db->get('images');
		$row = $query->row_array();
		
		$quota = $row['quota'];

		// get file quota
		$this->CI->db->where('siteID', $this->config['siteID']);
		$this->CI->db->select('SUM(filesize) as quota');
		$query = $this->CI->db->get('files');
		$row = $query->row_array();

		$quota += $row['quota'];

		return $quota;
	}

	function add_templates($siteID, $theme = TRUE)
	{
		// get lib
		$this->load->model('pages/pages_model', 'pages');

		// get default theme and import it
		$this->pages->siteID = $siteID;	

		// set up default theme
		if ($theme)
		{
			// NOTE: Both page:title and page:description are included in the title tag for SEO purposes
			$body = '<!DOCTYPE html>
					<html xml:lang="en">
					<head>
					<meta http-equiv="content-type" content="text/html; charset=utf-8" />
					<title>{page:title} | {page:description}</title>
					<meta name="keywords" content="{page:keywords}" />
					<meta name="description" content="{page:description}" />';

			if ($this->config->item('bootstrap'))
			{
				$body .= '
				<!-- your bootstrap or boottheme-generated css file goes here -->
				<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
				<link href="/static/css/bootstrap-image-gallery.min.css" rel="stylesheet" type="text/css">
				<link href="/static/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

				<link rel="stylesheet" href="/static/css/font-awesome.min.css">';
			}
			else
			{
				$body .= '<link rel="stylesheet" href="/static/css/default.css" type="text/css" />';
			}

			$body .= '
				<link rel="shortcut icon" href="/static/images/favicon.ico" />
				<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
				<!--[if lt IE 9]>
					<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
				<![endif]-->';

			if ($this->config->item('csrf_protection'))
			{
				$body .= '<!-- Vizlogix code to enable AJAX form submission with CSRF protection - DO NOT REMOVE -->
				<script language="javascript" type="text/javascript" src="{site:url}/static/js/jquery.cookie.js"></script>
				<script language="javascript" type="text/javascript">
				$(function($) {
					$.ajaxSetup({
						data: {
							csrf_test_name: $.cookie(\'csrf_cookie_name\')
						}
						});
					});
				</script>
				<!-- END: Vizlogix code to enable AJAX form submission with CSRF protection -->';
			}

			// NOTE: Check this version of jQuery with regards to the needs of the site
			$body .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>';

			// optional Bootstrap jQuery inclusion
			if ($this->config->item('bootstrap'))
			{
				$body .= '<script src="/static/js/bootstrap.min.js"></script>';
			}

			// optional jQuery form validation
			// TBD: needs to be generalized for all types of forms, fields, etc.
			if ($this->config->item('formvalid'))
			{
				$body .= '<script type="text/javascript" src="/static/js/jquery.validate.js"></script>
					<style type="text/css">
						label { font-size: 100%; width: 14em; float: left; }
						label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
						.submit { margin-left: 12em; }
						em { font-weight: bold; padding-right: 1em; vertical-align: top; }
						.help-inline {
							display: inline-block;
							vertical-align: top;
							padding-left: 10px;
						}
					</style>
					<script>
					$(document).ready(function(){
						$("#contactForm").validate({
						errorElement: \'span\',
						errorClass: \'help-inline\',
						highlight: function (element, errorClass) {
							$(element).parent().parent().addClass(\'error\');
						},
						unhighlight: function (element, errorClass) {
							$(element).parent().parent().removeClass(\'error\');
						}
						});
					});
					</script>';
			}

			$body .= '</head>
					<body>';

			// navigation
			// optional Bootstrap navigation styling
			if ($this->config->item('bootstrap'))
			{
				$body .= '
				<div class="container">
				<div class="navbar navbar-inverse navbar-static-top">
				<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<i class="icon-reorder"></i> MENU
					</a>
					<div class="nav-collapse collapse">
					<ul class="nav">
					{navigation}
					</ul>
					</div><!--/.nav-collapse -->
				</div>
				</div>
				</div>
				</div>
				';
			}
			else
			{
				$body .= '<div class="menu">
					<ul>
					{navigation}
					</ul>
				</div>';
			}

			$body .= '
				<div class="container">
				<!--CONTENT-->';

			if ($this->config->item('bootstrap'))
			{
				$body .= '<div class="row-fluid"><div class="span12">';
			}
			$body .= '
				{block1}';
			if ($this->config->item('bootstrap'))
			{
				$body .= '</div></div>';
			}

			$body .= '
				<!--ENDCONTENT-->
				</div>';

			// footer
			$body .= '
				<footer class="container">
				<p>&copy;2013 &ndash; {date:year} {site:name} |
				<a href="{site:url}/admin">CMS Admin</a></p>
				<p>Site powered by <a href="http://www.halogy.com/" target="_blank">Halogy</a></p>
				</footer>
				</body>
				</html>';
			$templateID = $this->pages->import_template('default.html', $body);
		}
		else
		{
			$content = "<html>\n<head><title>{page:title}</title>\n<body>\n\n<br><br><center>\n\n{block1}\n\n</center></body>\n</html>";
			$templateID = $this->pages->add_template('Default', $content);
		}	

		// add home page
		$this->db->set('siteID', $siteID);
		$this->db->set('dateCreated', date("Y-m-d H:i:s"));
		$this->db->set('pageName', 'Home');
		$this->db->set('title', 'Home');
		$this->db->set('uri', 'home');
		$this->db->set('templateID', $templateID);
		$this->db->set('active', 1);		
		$this->db->insert('pages');
		$pageID = $this->db->insert_id();
		
		// add version
		$this->db->set('siteID', $siteID);
		$this->db->set('dateCreated', date("Y-m-d H:i:s"));
		$this->db->set('pageID', $pageID);
		$this->db->set('published', 1);
		$this->db->insert('page_versions');
		$versionID = $this->db->insert_id();
		
		// update page
		$this->db->set('draftID', $versionID);
		$this->db->set('versionID', $versionID);
		$this->db->where('pageID', $pageID);
		$this->db->where('siteID', $siteID);
		$this->db->update('pages');

		// add first block
		$this->db->set('siteID', $siteID);
		$this->db->set('dateCreated', date("Y-m-d H:i:s"));
		$this->db->set('blockRef', 'block1');
		$this->db->set('body', "# Welcome.\n\nYour site is set up and ready to go!");
		$this->db->set('versionID', $versionID);
		$this->db->insert('page_blocks');

		return TRUE;		
	}
	
	function delete_site($siteID)
	{	
		// delete site
		$this->db->where('siteID', $siteID);
		$this->db->delete('sites');
		
		return TRUE;
	}	

}