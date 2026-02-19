<?php
/**
 * @package    Subusers
 *
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (C) 2009 - 2018 Techjoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

// Access check.
if (!Factory::getApplication()->getIdentity()->authorise('core.manage', 'com_subusers'))
{
	throw new \Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

require_once JPATH_ADMINISTRATOR . '/components/com_subusers/includes/rbacl.php';

$app = Factory::getApplication();
$mvcFactory = $app->bootComponent('com_subusers')->getMVCFactory();
$controller = $mvcFactory->createController('Display', 'Administrator', [], $app, $app->getInput());
$controller->execute($app->getInput()->get('task'));
$controller->redirect();
