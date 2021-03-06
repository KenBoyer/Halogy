<?php
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

class Tickets_model extends CI_Model {

	var $siteID;

	function __construct()
	{
		parent::__construct();

		// get siteID, if available
		if (defined('SITEID'))
		{
			$this->siteID = SITEID;
		}
	}

	function get_all_web_forms()
	{
		$this->db->where('siteID', $this->siteID);
		$this->db->where('deleted', 0);

		$this->db->order_by('formName');

		$query = $this->db->get('web_forms');

		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	function get_web_form($formID = '')
	{
		$this->db->where('siteID', $this->siteID);
		$this->db->where('deleted', 0);

		$this->db->where('formID', $formID);

		$query = $this->db->get('web_forms', 1);

		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}

	function view_ticket($ticketID)
	{
		$this->db->set('viewed', '1');
		$this->db->where('ticketID', $ticketID);
		$this->db->where('siteID', $this->siteID);
		$this->db->update('tickets');
	}

	function export_tickets($formName = '')
	{
		$this->db->where('siteID', $this->siteID);
		$this->db->where('deleted', 0);
		if (strlen($formName) > 0)
		{
			$this->db->where('formName', $formName);
		}

		$this->db->select('ticketID as ID, dateCreated as Date, subject as Subject, fullName as Name, email as Email, body as Interests, notes as Notes');

		// order
		$this->db->order_by('dateCreated', 'asc');

		$query = $this->db->get('tickets');

		if ($query->num_rows() > 0)
		{
			return $query;
		}
		else
		{
			return FALSE;
		}
	}

	function get_tickets_by_email($email, $limit)
	{
		$this->db->where('siteID', $this->siteID);
		$this->db->where('deleted', 0);
		$this->db->where('email', $email);

		// order by newest first
//		$this->db->order_by('dateCreated', 'desc');

		$query = $this->db->get('tickets');

		if ($query->num_rows() > 0)
		{
			return $query->result_array();
//			return $query;
		}
		else
		{
			return FALSE;
		}
	}
}
