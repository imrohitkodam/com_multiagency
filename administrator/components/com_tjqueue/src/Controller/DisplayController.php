<?php
/**
 * @package     Tjqueue
 * @subpackage  com_tjqueue
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (c) 2009-2024 TechJoomla. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

namespace Tjqueue\Component\Tjqueue\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

/**
 * Default Controller of TJQueue component
 *
 * @package     TJQueue
 * @subpackage  com_tjqueue
 * @since       2.0.0
 */
class DisplayController extends BaseController
{
	/**
	 * The default view for the display method.
	 *
	 * @var string
	 * @since 2.0.0
	 */
	protected $default_view = 'entries';
}
