<?php
/**
 * @package     Subusers
 * @subpackage  com_subusers
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\Schema\ChangeSet;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

/**
 * Jlike Manage Model
 *
 * @since  1.6
 */
class SubusersModelDatabase extends BaseDatabaseModel
{
	/**
	 * Gets the changeset object.
	 *
	 * @return  ChangeSet
	 */
	public function getItems()
	{
		$folder = JPATH_ADMINISTRATOR . '/components/com_subusers/sql/updates/';

		try
		{
			$changeSet = new ChangeSet($this->getDbo(), $folder);
		}
		catch (RuntimeException $e)
		{
			Factory::getApplication()->enqueueMessage($e->getMessage(), 'warning');

			return false;
		}
		return $changeSet;
	}

	/**
	 * Method to fix database issues
	 *
	 * @return  void
	 */
	public function fix()
	{
		$changeSet = $this->getItems();

		if ($changeSet)
		{
			$changeSet->fix();
		}
	}
}
