<?php
/**
 * @package     Subusers
 * @subpackage  com_subusers
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

/**
 * Installer Database Controller
 *
 * @since  2.5
 */
class SubusersControllerDatabase extends BaseController
{
	/**
	 * Tries to fix missing database updates
	 *
	 * @return  void
	 *
	 * @since   2.5
	 * @todo    Purge updates has to be replaced with an events system
	 */
	public function fix()
	{
		// Get a handle to the Joomla! application object
		$application = Factory::getApplication();

		$model = $this->getModel('database');
		$model->fix();

		// Purge updates - try to get the joomlaupdate model if available
		try
		{
			$updateModel = $application->bootComponent('com_joomlaupdate')
				->getMVCFactory()
				->createModel('Update', 'Administrator');

			if ($updateModel)
			{
				$updateModel->purge();
			}
		}
		catch (\Exception $e)
		{
			// com_joomlaupdate model not available, skip purge
		}

		// Refresh versionable assets cache
		Factory::getApplication()->flushAssets();

		$this->setRedirect(Route::_('index.php?option=com_subusers&view=organizations', false));
	}
}
