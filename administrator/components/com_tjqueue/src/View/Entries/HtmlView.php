<?php
/**
 * @package     Tjqueue
 * @subpackage  com_tjqueue
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (c) 2009-2024 TechJoomla. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

namespace Tjqueue\Component\Tjqueue\Administrator\View\Entries;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * TJQueue Entries View
 *
 * @package     TJQueue
 * @subpackage  com_tjqueue
 * @since       2.0.0
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * Display the Queues view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		$this->addToolbar();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Function to set tool bar.
	 *
	 * @return void
	 *
	 * @since	2.0.0
	 */
	protected function addToolbar()
	{
		ToolbarHelper::title('TJ Queue');
		ToolbarHelper::preferences('com_tjqueue');
	}
}
