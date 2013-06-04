<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Config extends CI_Config {
	/**
	 * Site URL
	 * Returns base_url . index_page [. uri_string]
	 * NOTE: This overrides the default CI function to allow for suffixes like .html in a website, but to also allow
	 * for the default in the /admin section of the site, so .html, for example, is not added to URIs that invoke
	 * AJAX calls, pass parameters, etc.
	 * @access	public
	 * @param	string	the URI string
	 * @return	string
	 */
	function site_url($uri = '')
	{
		if ($uri == '')
		{
			return $this->slash_item('base_url').$this->item('index_page');
		}

		if ($this->item('enable_query_strings') == FALSE)
		{
			$suffix = ($this->item('url_suffix') == FALSE) ? '' : $this->item('url_suffix');
			// if the URI string begins with '/admin', do not add the suffix
			if (strpos($uri, 'admin') > 0 && strpos($uri, 'admin') < 2)
			{
				return $this->slash_item('base_url').$this->slash_item('index_page').$this->_uri_string($uri);
			}
			else
			{
				return $this->slash_item('base_url').$this->slash_item('index_page').$this->_uri_string($uri).$suffix;
			}
		}
		else
		{
			return $this->slash_item('base_url').$this->item('index_page').'?'.$this->_uri_string($uri);
		}
	}
}
