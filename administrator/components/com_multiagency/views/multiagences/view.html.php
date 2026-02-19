<?php
/**
 * @package     Multiagency
 * @subpackage  com_multiagency
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2020 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\HTML\Helpers\Sidebar;

/**
 * View class for a list of multiagences.
 *
 * @since  1.6
 */
class MultiagencyViewMultiagences extends HtmlView
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$path = JPATH_SITE . '/components/com_tjfields/helpers/geo.php';

		if (file_exists($path))
		{
			if (!class_exists('TjGeoHelper'))
			{
				JLoader::register('TjGeoHelper', $path);
				JLoader::load('TjGeoHelper');
			}

			if (class_exists('TjGeoHelper'))
			{
				$this->tjGeoHelper = TjGeoHelper::getInstance('TjGeoHelper');
			}
		}

		MultiagencyHelpersMultiagency::addSubmenu('multiagences');

		$this->addToolbar();

		$this->sidebar = Sidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = MultiagencyHelpersMultiagency::getActions();

		ToolbarHelper::title(Text::_('COM_MULTIAGENCY_TITLE_MULTIAGENCES'), 'enterprises.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_ADMINISTRATOR . '/components/com_multiagency/views/multiagency';

		/*
		 * DPE - Hack -- Start to Hide Actions
		 *
		if (file_exists($formPath))
		{
			if ($canDo->{'core.create'})
			{
				ToolbarHelper::addNew('multiagency.add', 'JTOOLBAR_NEW');
			}

			if ($canDo->{'core.edit'} && isset($this->items[0]))
			{
				ToolbarHelper::editList('multiagency.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->{'core.edit.state'})
		{
			if (isset($this->items[0]->state))
			{
				ToolbarHelper::divider();
				ToolbarHelper::custom('multiagences.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				ToolbarHelper::custom('multiagences.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				* // If this component does not use state then show a direct delete button as we can not trash
				ToolbarHelper::deleteList('', 'multiagences.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				ToolbarHelper::divider();
				ToolbarHelper::archiveList('multiagences.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				ToolbarHelper::custom('multiagences.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		* // Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->{'filter.state'} == -2 && $canDo->{'core.delete'})
			{
				ToolbarHelper::deleteList('', 'multiagences.delete', 'JTOOLBAR_EMPTY_TRASH');
				ToolbarHelper::divider();
			}
			elseif ($canDo->{'core.edit.state'})
			{
				ToolbarHelper::trash('multiagences.trash', 'JTOOLBAR_TRASH');
				ToolbarHelper::divider();
			}
		}
		*
		*/

		if ($canDo->{'core.admin'})
		{
			ToolbarHelper::preferences('com_multiagency');
		}

		// Set sidebar action - New in 3.0
		Sidebar::setAction('index.php?option=com_multiagency&view=multiagences');

		$this->extra_sidebar = '';
		Sidebar::addFilter(

			Text::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			HTMLHelper::_('select.options', HTMLHelper::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);
	}

	/**
	 * Method to order fields
	 *
	 * @return void
	 */
	protected function getSortFields()
	{
		return array(
			'a.`id`' => Text::_('JGRID_HEADING_ID'),
			'a.`ordering`' => Text::_('JGRID_HEADING_ORDERING'),
			'a.`state`' => Text::_('JSTATUS'),
			'a.`title`' => Text::_('COM_MULTIAGENCY_MULTIAGENCES_TITLE'),
			'a.`country_id`' => Text::_('COM_MULTIAGENCY_MULTIAGENCES_COUNTRY_ID'),
			'a.`state_id`' => Text::_('COM_MULTIAGENCY_MULTIAGENCES_STATE_ID'),
		);
	}
}
