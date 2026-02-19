<?php
/**
 * @package     Tjqueue
 * @subpackage  com_tjqueue
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (c) 2009-2024 TechJoomla. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

namespace Tjqueue\Component\Tjqueue\Administrator\Extension;

defined('_JEXEC') or die;

use Joomla\CMS\Extension\BootableExtensionInterface;
use Joomla\CMS\Extension\MVCComponent;
use Psr\Container\ContainerInterface;

/**
 * Component class for com_tjqueue
 *
 * @since  2.0.0
 */
class TjqueueComponent extends MVCComponent implements BootableExtensionInterface
{
	/**
	 * Booting the extension. This is the function to set up the environment of the extension like
	 * registering new class loaders, etc.
	 *
	 * If required, some initial set up can be done from services of the container, eg.
	 * registering HTML services.
	 *
	 * @param   ContainerInterface  $container  The container
	 *
	 * @return  void
	 *
	 * @since   2.0.0
	 */
	public function boot(ContainerInterface $container): void
	{
		// Perform any necessary boot operations
	}
}
