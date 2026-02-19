<?php
/**
 * Stub classes for com_cluster dependency
 *
 * This file provides stub implementations of ClusterFactory, ClusterCluster,
 * and related classes when com_cluster is not installed.
 * All methods return safe fallback values to prevent fatal errors.
 *
 * @package    Com_Multiagency
 * @since      1.0.0
 */

defined('_JEXEC') or die;

/**
 * Stub for ClusterFactory class
 *
 * @since  1.0.0
 */
class ClusterFactory
{
	/**
	 * Get a model instance (returns a stub model)
	 *
	 * @param   string  $name    The model name
	 * @param   array   $config  Configuration array
	 *
	 * @return  ClusterStubModel
	 */
	public static function model($name = '', $config = array())
	{
		return new ClusterStubModel;
	}

	/**
	 * Get a table instance (returns a stub table)
	 *
	 * @param   string  $name    The table name
	 * @param   array   $config  Configuration array
	 *
	 * @return  ClusterStubTable
	 */
	public static function table($name = '', $config = array())
	{
		return new ClusterStubTable;
	}
}

/**
 * Stub for ClusterCluster class
 *
 * @since  1.0.0
 */
class ClusterCluster
{
	/**
	 * Get an instance
	 *
	 * @param   int  $id  Cluster ID
	 *
	 * @return  self
	 */
	public static function getInstance($id = 0)
	{
		return new self;
	}

	/**
	 * Check if user is a member
	 *
	 * @param   int  $userId  User ID
	 *
	 * @return  boolean
	 */
	public function isMember($userId = 0)
	{
		return false;
	}
}

/**
 * Stub model that returns empty results
 *
 * @since  1.0.0
 */
class ClusterStubModel
{
	/**
	 * Magic method to handle any method call
	 *
	 * @param   string  $name       Method name
	 * @param   array   $arguments  Method arguments
	 *
	 * @return  array
	 */
	public function __call($name, $arguments)
	{
		return array();
	}

	/**
	 * Get users clusters (returns empty array)
	 *
	 * @param   int  $userId  User ID
	 *
	 * @return  array
	 */
	public function getUsersClusters($userId = 0)
	{
		return array();
	}

	/**
	 * Get items (returns empty array)
	 *
	 * @return  array
	 */
	public function getItems()
	{
		return array();
	}
}

/**
 * Stub table that simulates an empty table record
 *
 * @since  1.0.0
 */
class ClusterStubTable
{
	/**
	 * Client ID property
	 *
	 * @var  int
	 */
	public $client_id = 0;

	/**
	 * ID property
	 *
	 * @var  int
	 */
	public $id = 0;

	/**
	 * Magic method to get any property
	 *
	 * @param   string  $name  Property name
	 *
	 * @return  null
	 */
	public function __get($name)
	{
		return null;
	}

	/**
	 * Magic method to handle any method call
	 *
	 * @param   string  $name       Method name
	 * @param   array   $arguments  Method arguments
	 *
	 * @return  boolean
	 */
	public function __call($name, $arguments)
	{
		return false;
	}

	/**
	 * Load a record
	 *
	 * @param   mixed  $keys  Record key(s)
	 *
	 * @return  boolean
	 */
	public function load($keys = null)
	{
		return false;
	}

	/**
	 * Store a record
	 *
	 * @return  boolean
	 */
	public function store()
	{
		return false;
	}

	/**
	 * Delete a record
	 *
	 * @param   mixed  $pk  Primary key
	 *
	 * @return  boolean
	 */
	public function delete($pk = null)
	{
		return false;
	}

	/**
	 * Bind data to the table
	 *
	 * @param   array  $src  Source data
	 *
	 * @return  boolean
	 */
	public function bind($src = array())
	{
		return false;
	}
}
