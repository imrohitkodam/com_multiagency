<?php
/**
 * @version    SVN: <svn_id>
 * @package    TJQueue
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2019 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

$app = Factory::getApplication();

// Get the controller using MVCFactory
$controller = $app->bootComponent('com_tjqueue')
	->getMVCFactory()
	->createController(
		'',
		'Administrator',
		[],
		$app,
		$app->getInput()
	);

// Perform the Request task
$controller->execute($app->getInput()->get('task'));

// Redirect if set by the controller
$controller->redirect();
