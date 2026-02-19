<?php
/**
 * RBACL Stub Class
 *
 * This is a fallback stub for the RBACL class from com_subusers.
 * When com_subusers is not installed, this stub provides safe default
 * return values to prevent fatal errors.
 *
 * @package    Com_Multiagency
 * @since      1.0.0
 */

defined('_JEXEC') or die;

/**
 * Stub class for RBACL when com_subusers is not available
 *
 * @since  1.0.0
 */
class RBACL
{
	/**
	 * Get role by user - returns empty array as fallback
	 *
	 * @return  array
	 */
	public static function getRoleByUser()
	{
		return array();
	}

	/**
	 * Get core role by user - returns empty array as fallback
	 *
	 * @return  array
	 */
	public static function getCoreRoleByUser()
	{
		return array();
	}

	/**
	 * Authorise - returns false as fallback (no permission)
	 *
	 * @return  boolean
	 */
	public static function authorise()
	{
		return false;
	}

	/**
	 * Check - returns false as fallback
	 *
	 * @return  boolean
	 */
	public static function check()
	{
		return false;
	}

	/**
	 * Get model - returns null as fallback
	 *
	 * @return  null
	 */
	public static function model()
	{
		return null;
	}

	/**
	 * Get table - returns null as fallback
	 *
	 * @return  null
	 */
	public static function table()
	{
		return null;
	}

	/**
	 * Get agency by user - returns empty array as fallback
	 *
	 * @return  array
	 */
	public static function getAgencyByUser()
	{
		return array();
	}
}
