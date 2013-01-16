<?php
/**
 The EckoTools Session Library

 @package The EckoTools Session Library
 @category Libraries
 @author Hartmut K?nig (h.koenig@eckotools.com)
 @link http://www.okidoe.de
 @version 1.0.2
 @copyright Hartmut K?nig 2009

 A class to handle sessions by using a mySQL database for session related
 data storage providing better security then the default session handler 
 used by PHP with added protection against Session Hijacking & Fixation 
 including the flashdata-Feature of CI. It don't use Browser or IP to identify 
 the user. Instead I generate a fingerprint of different seldom changing data 
 (@link _generate_fingerprint) 

 To prevent session hijacking, don't forget to use the {@link regenerate_id} 
 method whenever you do a privilege change in your application

  -- 
  -- MYSQL: Table structure for table `ci_sessions`
  -- 
  
CREATE TABLE `ci_sessions` (
  `session_id` varchar(32) NOT NULL default '',
  `fingerprint` varchar(32) NOT NULL default '',
  `session_data` blob NOT NULL,
  `session_expire` int(11) NOT NULL default '0',
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1; 


  This class is an adaptation between the original CI Sessions, Native Sessions 
  and my own coding

*/

class CI_Session
{
	
  /**
   *  Constructor of class
   *
   *  Initializes the class and starts a new session
   *
   *  There is no need to call start_session() after instantiating this class
   *
   *  $gc_maxlifetime	(optional) the number of seconds after which data will be seen as 'garbage' and
   *                 	cleaned up on the next run of the gc (garbage collection) routine
   *                 	
   *                 	Default is specified in php.ini file
   *                 	
   *  $gc_probability	(optional) used in conjunction with gc_divisor, is used to manage probability that
   *                 	the gc routine is started. the probability is expressed by the formula
   *                 	
   *                 	probability = $gc_probability / $gc_divisor
   *                 	
   *                 	So if $gc_probability is 1 and $gc_divisor is 100 means that there is
   *                 	a 1% chance the the gc routine will be called on each request
   *                 	
   *                 	Default is specified in php.ini file
   *                 	
   *  $gc_divisor    	(optional) used in conjunction with gc_probability, is used to manage probability
   *                 	that the gc routine is started. the probability is expressed by the formula
   *                 	
   *                 	probability = $gc_probability / $gc_divisor
   *                 	
   *                 	So if $gc_probability is 1 and $gc_divisor is 100 means that there is
   *                 	a 1% chance the the gc routine will be called on each request
   *                 	
   *                 	Default is specified in php.ini file
   *                 	
   *  $security_code 	(optional) the value of this argument is appended to the fingerprint before
   *                 	creating the md5 hash out of it. this way we'll try to prevent fingerprint
   *                 	spoofing
   *                 	
   *                 	Default is 'LeouOeEkKpvSnD-YCHd5ogt3y'
   *                 	
   *  $table_name    	(optional) You can change the name of that table by setting this property
   *
   *                  Default is 'ci_sessions'
   *
   *  @return void
   */
  function CI_Session(	$security_code="La4bERkxMEkKpvSnD-YCHd5ogt3y",$table_name="ci_sessions" )
  {
   		//-- CI Config
   		$this->CI 						= & get_instance();
    	$this->flashdata_key 			= 'flash'; // prefix for "flash" variables (eg. flash:new:message)   		
   		$table_name 					= $this->CI->config->item('sess_table_name');
		$gc_maxlifetime					= $this->CI->config->item('sess_expiration');
		$gc_probability 				= $this->CI->config->item('sess_gc_probability');
		$gc_divisor						= $this->CI->config->item('sess_gc_divisor');
		$sess_name						= $this->CI->config->item('sess_cookie_name');
			
      // if $gc_maxlifetime is specified and is an integer number
      (!empty($gc_maxlifetime) && is_integer($gc_maxlifetime))
				? @ini_set('session.gc_maxlifetime', $gc_maxlifetime)
				: false;

      // if $gc_probability is specified and is an integer number
      (!empty($gc_probability) && is_integer($gc_probability))      
				? @ini_set('session.gc_probability', $gc_probability)
				: false;

      // if $gc_divisor is specified and is an integer number
      (!empty($gc_divisor) && is_integer($gc_divisor))            
				? @ini_set('session.gc_divisor', $gc_divisor)
				: false;

      (!empty($sess_name))            
				? @ini_set('session.name', $sess_name)
				: false;
		
      // get session lifetime
      $this->sessionLifetime = ini_get("session.gc_maxlifetime");
      
      // we'll use this later in order to prevent fingerprint spoofing
      $this->securityCode = $security_code;
      $this->tableName 		= $table_name;

      // register the new handler
      session_set_save_handler(
          array(&$this, '_open'),
          array(&$this, '_close'),
          array(&$this, '_read'),
          array(&$this, '_write'),
          array(&$this, '_destroy'),
          array(&$this, '_gc')
	        );
      register_shutdown_function('session_write_close');

      // start the session
      session_start();
      
			// Delete 'old' flashdata (from last request)
	   	$this->_flashdata_sweep();

			// Mark all new flashdata as old (data will be deleted before next request)
	   	$this->_flashdata_mark();
  }
	/**
	* Reads given session attribute value
	* 
	* @return integer sessionvalue
	*/    
	function userdata($item)
	{
			//added for backward-compatibility
	    if($item == 'session_id')
	    	{ 
	      return session_id();
	    	}

			if(isset($_SESSION[$item]))
				{
				return($_SESSION[$item]);
	    	}

			return(false);
	}  
	/**
	 * Fetch all session data
	 *
	 * @access	public
	 * @return	mixed
	 */
	function all_userdata()
	{
		return ( ! isset($_SESSION)) ? FALSE : $_SESSION;
	}

	/**
	* Sets session attributes to the given values
	* 
	* @return void
	*/
	function set_userdata($newdata = array(), $newval = '')
	{
	    (is_string($newdata))
	    	? $newdata = array($newdata => $newval)
	    	: false;
	
	    if(count($newdata) > 0)
	    	{
	      foreach($newdata as $key => $val)
	        {
	        $_SESSION[$key] = $val;
	        }
	    	}
	}
	/**
	* Erases given session attributes
	*
	* @return void	
	*/
	function unset_userdata($newdata = array())
	{
	    (is_string($newdata))
	    	? $newdata = array($newdata => '')
	    	: false;
	
	    if(count($newdata) > 0)
	    	{
	      foreach ($newdata as $key => $val)
	        {
	        unset($_SESSION[$key]);
	        }
	    	}        
	}	
  /**
   *  Deletes all data related to the session
   *  @return void
   */
  function sess_destroy()
  {
      $this->regenerate_id();
      session_unset();
      session_destroy();
  }
    
  /**
   *  Regenerates the session id.
   *
   *  <b>Call this method whenever you do a privilege change!</b>
   *
   *  @return void
   */
  function regenerate_id()
  {
      // saves the old session's id
      $oldSessionID = session_id();

      // regenerates the id
      // this function will create a new session, with a new id and containing the data from the old session
      // but will not delete the old session
      session_regenerate_id();

      // because the session_regenerate_id() function does not delete the old session,
      // we have to delete it manually
      $this->_destroy($oldSessionID);
  }
	/**
	 * Add or change flashdata, only available
	 * until the next request
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_flashdata($newdata = array(), $newval = '')
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => $newval);
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$flashdata_key = $this->flashdata_key.':new:'.$key;
				$this->set_userdata($flashdata_key, $val);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Keeps existing flashdata available to next request.
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function keep_flashdata($key)
	{
		// 'old' flashdata gets removed.  Here we mark all
		// flashdata as 'new' to preserve it from _flashdata_sweep()
		// Note the function will return FALSE if the $key
		// provided cannot be found
		$old_flashdata_key = $this->flashdata_key.':old:'.$key;
		$value = $this->userdata($old_flashdata_key);

		$new_flashdata_key = $this->flashdata_key.':new:'.$key;
		$this->set_userdata($new_flashdata_key, $value);
	}

	// ------------------------------------------------------------------------

	/**
	 * Fetch a specific flashdata item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function flashdata($key)
	{
		$flashdata_key = $this->flashdata_key.':old:'.$key;
		return $this->userdata($flashdata_key);
	}

	// ------------------------------------------------------------------------

	/**
	 * Identifies flashdata as 'old' for removal
	 * when _flashdata_sweep() runs.
	 *
	 * @access	private
	 * @return	void
	 */
	function _flashdata_mark()
	{
		$userdata = $this->all_userdata();
		foreach ($userdata as $name => $value)
		{
			$parts = explode(':new:', $name);
			if (is_array($parts) && count($parts) === 2)
			{
				$new_name = $this->flashdata_key.':old:'.$parts[1];
				$this->set_userdata($new_name, $value);
				$this->unset_userdata($name);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Removes all flashdata marked as 'old'
	 *
	 * @access	private
	 * @return	void
	 */

	function _flashdata_sweep()
	{
		$userdata = $this->all_userdata();
		foreach($userdata as $key => $value)
			{
			if (strpos($key, ':old:'))
				{
				$this->unset_userdata($key);
				}
			}
	}
  /**
   *  Get the number of online users
   *
   *  @return integer     number of users currently online
   */
  function get_users_online()
  {
      // counts the rows from the database
      $query 	= $this->CI->db->query("SELECT COUNT(session_id) as count FROM {$this->tableName}");
      $result = $query->row(); 
      
      // return the number of found rows
      return $result->count;
  }

	/**
	 * Generates key as protection against Session Hijacking & Fixation.
	 * @access private
	 * @return string
	 */
	function _generate_fingerprint()
	{
		//-- We don't use the ip-adress, because this is a subject to change in most cases (proxies etc.)
		$list = array('HTTP_ACCEPT_CHARSET',
									'HTTP_ACCEPT_ENCODING',
									'HTTP_ACCEPT_LANGUAGE', 
									'HTTP_USER_AGENT');
		$key = array($this->securityCode);
		foreach($list as $item) 
			{
			$key[] = $this->CI->input->server($item);
			}
		return md5(implode("\0", $key));
	}
  /**
   *  Custom open() function
   *
   *  @access private
   */
  function _open($save_path, $session_name)
  {
      return(true);
  }

  /**
   *  Custom close() function
   *
   *  @access private
   */
  function _close()
  {
      return(true);
  }

  /**
   *  Custom read() function
   *
   *  @access private
   */
  function _read($session_id)
  {
      // reads session data associated with the session id
      // but only
      // - if the fingerprint is the same as the one who had previously written to this session AND
      // - if session has not expired
      $result = $this->CI->db->query("SELECT session_data ".
      																"FROM ".$this->tableName." ".
      																"WHERE session_id = ".$this->CI->db->escape($session_id)." ".
      																"AND fingerprint = ".$this->CI->db->escape($this->_generate_fingerprint())." ".
      																"AND session_expire > '".time()."' LIMIT 1");

      // if anything was found
      if($result->num_rows() > 0) 
      	{
        // return found data
        $fields = $result->row();

        // Unserialization - PHP handles this automatically
        return $fields->session_data;
      	}

      // if there was an error return an empty string - this HAS to be an empty string
      return("");

  }

  /**
   *  Custom write() function
   *
   *  @access private
   */
  function _write($session_id, $session_data)
  {
      // insert OR update session's data - this is how it works:
      // first it tries to insert a new row in the database BUT if session_id is already in the database then just
      // update session_data and session_expire for that specific session_id
      // read more here http://dev.mysql.com/doc/refman/4.1/en/insert-on-duplicate.html
      $result = $this->CI->db->query(
      														"INSERT INTO ".$this->tableName." (".
									                    "session_id,".
									                    "fingerprint,".
									                    "session_data,".
									                    "session_expire".
									                ") VALUES (".
              												$this->CI->db->escape($session_id).",".
              												$this->CI->db->escape($this->_generate_fingerprint()).",".
              												$this->CI->db->escape($session_data).",".
              												$this->CI->db->escape(time() + $this->sessionLifetime).
          														")".
          												"ON DUPLICATE KEY UPDATE ".
          														"session_data = ".$this->CI->db->escape($session_data).",".
              												"session_expire = ".$this->CI->db->escape(time() + $this->sessionLifetime));
        												
			// note that after this type of queries, mysql_affected_rows() returns
			// - 1 if the row was inserted
			// - 2 if the row was updated
			switch($this->CI->db->affected_rows())
				{
      	// if the row was inserted
      	case 1:
					return("");
        break;
				// if the row was updated
				case 2:
      		return(true);
				break;
				// if something went wrong, return false
				default:
      		return(false);
      	break;
      	}
  }

  /**
   *  Custom destroy() function
   *
   *  @access private
   */
  function _destroy($session_id)
  {
      // deletes the current session id from the database
      $result = $this->CI->db->query("DELETE FROM ".$this->tableName." ".
          														"WHERE session_id = ".$this->CI->db->escape($session_id));

      // if anything happened
      if($this->CI->db->affected_rows())
      	{
        return(true);
				}
			
      // if something went wrong, return false
      return(false);
  }

  /**
   *  Custom gc() function (garbage collector)
   *
   *  @access private
   */
function _gc($maxlifetime)
  {
		// it deletes expired sessions from database
    $result = $this->CI->db->query("DELETE FROM ".$this->tableName." ".
    																"WHERE session_expire < ".$this->CI->db->escape(time() - $maxlifetime));
	}

}
?>
