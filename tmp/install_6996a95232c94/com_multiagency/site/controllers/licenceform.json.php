<?php
/**
 * @package     Multiagency
 * @subpackage  Com_Multiagency
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2021 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Layout\FileLayout;

/**
 * Licence controller class
 *
 * @since  __DEPLOY_VERSION__
 */
class MultiagencyControllerLicenceForm extends FormController
{
	protected $comMultiAgency = 'com_multiagency';

	/**
	 * Function to save licence
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * 
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 * 
	 * @return  void
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function save($key = null, $urlVar = null)
	{
		$app = Factory::getApplication();

		if (!Session::checkToken())
		{
			$app->enqueueMessage(Text::_('JINVALID_TOKEN'), 'error');
			echo new JsonResponse(null, null, true);
			$app->close();
		}

		$data  = $app->getInput()->post->get('jform', array(), 'array');

		if(empty($data)){
		
			$data  = $app->getInput()->post->get('formdata', array(), 'array');
		}

		$activityData  = $data['activity'];
		$tools         = $data['tools'];
		$showInSlaList = $data['show_in_sla_list'];
		$newSla        = $data['new_sla'];
		$model         = $this->getModel();
		$form          = $model->getForm();

		if (!$form)
		{
			throw new Exception('An error occurred', 500);
		}

		if ($data['licence_type'] === 'all')
		{
			$data['course_id'] = 0;
		}

		if ($data['id'] || !$data['multiyearlicence'])
		{
			$form->setFieldAttribute('multiple_count', 'required', 'false');
			$form->setFieldAttribute('duration', 'required', 'false');
		}

		// Validate the posted data.
		$data       = $model->validate($form, $data);
		$returnData = array();

		if ($data == false)
		{
			$errors = $model->getErrors();

			if (!empty($errors))
			{
				$msg  = array();

				// Push up to three validation messages out to the user.
				for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
				{
					if ($errors[$i] instanceof Exception)
					{
						$msg[] = $errors[$i]->getMessage();
					}
					else
					{
						$msg[] = $errors[$i];
					}
				}

				$errormsg = implode("<br>", $msg);
				echo new JsonResponse(0, $errormsg, true);
			}
		}
		else
		{ 
			$data['activity']         = $activityData;
			$data['tools']            = $tools;
			$data['show_in_sla_list'] = $showInSlaList;
			$data['new_sla']          = $newSla;

			// Need to check start date with current date if date is future then state is 3 for licnece and activities.

			$tz                 = Factory::getUser()->getTimezone();
			$date               = Factory::getDate('now');
			$currentDate        = $date->setTimezone($tz)->format('Y-m-d 00:00:00');

			// Convert date format for validation
			$startDate = Factory::getDate($data['start_date'])->toSql();

			// If start date set to future date then licence is set to upcoming state
			if ($startDate > $currentDate)
			{
				$data['state'] = 3;
			}
			else
			{
				$data['state'] = 1;
			}

			// Check multiyear checkbox checked and count added

			$return = true;

			if ($data['multiyearlicence'] && $data['multiple_count'])
			{
				// Server side validation for limit

				if ($data['time_measure'] === "week")
				{
					// Convert week into 7 days
					$duration = 'now +' . ($data['duration'] * 7) . ' day';
				}
				elseif($data['time_measure'] === "month")
				{
					// Convert into 30 days
					$duration = 'now +' . ($data['duration'] * 30) . ' day';
				}
				else
				{
					$duration = 'now +' . $data['duration'] . ' ' . $data['time_measure'];
				}

				$date = new DateTime($data['start_date']);

				// Subtract 1 day from the DateTime object
				$date->modify('-1 day');

				// Format the date to match the format of the datetimeoffset field
				$endDate = $date->format('d-m-Y');



				$licenceLimit            = ComponentHelper::getParams('com_multiagency')->get('multliyear_licence_limit');
				$data['end_date']        = HTMLHelper::date($endDate . $duration, 'd-m-Y');
				$data['multiple_count'] = ($data['multiple_count'] > $licenceLimit) ? $licenceLimit : $data['multiple_count'];
				$licenceIds              = array();

				for ($i = 1; $i <= $data['multiple_count']; $i++)
				{
					/** @scrutinizer ignore-call */
					$licenceId    = $model->save($data);
					$licenceIds[] = $licenceId;

					if ($licenceId)
					{
						$licenceTable = $model->getTable();
						$licenceTable->load(array('id' => $licenceId));

						if (property_exists($licenceTable, 'end_date'))
						{
							 $data['start_date'] = HTMLHelper::date($licenceTable->end_date . '+1 day', 'd-m-Y');
							 $data['end_date']   = HTMLHelper::date($licenceTable->end_date . $duration . '+0 day', 'd-m-Y');
						}

						// State 3 is used for upcoming licence
						$data['state'] = 3;

						// First licence is active licence then set first licence id as a parent id of upcoming licences
						$data['parent_id'] = $licenceIds[0];
					}
					else
					{
						$return = false;
					}
				}
			}
			else
			{  
				// On edit if multi licence available then update the endate as per already saved duration
				if ($data['id'])
				{
					// Check licence is active before save else return false
					$licenceTable = $model->getTable();
					$licenceTable->load(array('id' => $data['id'], 'state' => '1'));

					if (!$licenceTable->id)
					{
						echo new JsonResponse(1, Text::_('JERROR_AN_ERROR_HAS_OCCURRED'), true);
						$app->close();
					}

					JLoader::import("/components/com_sla/includes/sla", JPATH_SITE);
					$clusterxrefs = SlaFactory::table("slaclusterxrefs");
					$clusterxrefs->load(array('license_id' => $data['id']));

					// Get multilicence data which stored in licence xref
					$registry         = new Registry($clusterxrefs->params);
					$multiLicenceData = $registry->toArray();
					$duration         = null;

					if (! empty($multiLicenceData))
					{
						if ($multiLicenceData['time_measure'] === "week")
						{
							// Convert week into 7 days
							$duration = 'now +' . ($multiLicenceData['duration'] * 7) . ' day';
						}
						elseif($multiLicenceData['time_measure'] === "month")
						{
							$duration = 'now +' . ($multiLicenceData['duration'] * 30) . ' day';
						}
						else
						{
							$duration = 'now +' . $multiLicenceData['duration'] . ' ' . $multiLicenceData['time_measure'];
						}
					}

					// If duration available then only update end date and this code will not execute for single licence
					if ($duration)
					{
						$tz                 = Factory::getUser()->getTimezone();
						$date               = Factory::getDate('now');
						$currentDate        = $date->setTimezone($tz)->format('Y-m-d 00:00:00');

						$date = new DateTime($data['start_date']);

						// Subtract 1 day from the DateTime object
						$date->modify('-1 day');

						// Format the date to match the format of the datetimeoffset field
						$endDate = $date->format('d-m-Y');

						// Calculate end date as per duration saved while creating licence
						$data['end_date'] = HTMLHelper::date($endDate . $duration, Text::_('DATE_FORMAT_LC6'));

						// If end date is calculated as past date then archive this licence
						if ($data['end_date'] < $currentDate)
						{
							$data['state'] = 2;
						}
					}
				}

				/** @scrutinizer ignore-call */
				$return = $model->save($data);
			}

			// Check for errors.
			if ($return === false)
			{
				$errormsg = Text::_('An error occurred');
				echo new JsonResponse(0, $errormsg, true);
				$app->close();
			}
			else
			{
				$redirectUrl               = $app->getInput()->post->getString('redirectUrl', '');

				if(empty($redirectUrl)){

				// Set Joomla enqueueMessage
				$app->enqueueMessage(Text::_('COM_LICENCE_ITEM_SAVED_SUCCESSFULLY'), 'message');

				// Return JSON with redirect
				echo new JsonResponse([
					'success'     => true,
					'redirectUrl' => 'index.php?option=com_dpe&view=schools'
				]);
				$app->close();

				}else{
					$returnData['msg']         = Text::_('COM_LICENCE_ITEM_SAVED_SUCCESSFULLY');
					$returnData['redirectUrl'] = $redirectUrl;

				}
				
			}
			echo new JsonResponse($returnData);
			$app->close();
		}
	}

	/**
	 * Function to check active licence
	 *
	 * @return  void
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function checkExistingLicence()
	{
		$app = Factory::getApplication();

		if (!Session::checkToken())
		{
			$app->enqueueMessage(Text::_('JINVALID_TOKEN'), 'error');
			echo new JsonResponse(null, null, true);
			$app->close();
		}

		$agencyId = $app->getInput()->post->get('agencyId', 0, 'INT');

		$licenceTable = Multiagency::table('licence');

		// Get active licence of agency
		$licenceTable->load(array('multiagency_id' => $agencyId, 'state' => 1));

		if (property_exists($licenceTable, 'id'))
		{
			if ($licenceTable->id)
			{
				BaseDatabaseModel::addIncludePath(JPATH_SITE . '/components/com_multiagency/models');
				$licencesModel = BaseDatabaseModel::getInstance('Licences', 'MultiagencyModel', array('ignore_request' => true));
				$licencesModel->setState('filter.state', array(3,1));
				$licencesModel->setState('list.ordering', 'a.end_date');
				$licencesModel->setState('filter.multiagency_id', $licenceTable->multiagency_id);
				$licences    = $licencesModel->getItems();
				$lastLicence = $licences[array_key_last($licences)];

				$basePath        = JPATH_ROOT . '/components/com_dpe/layouts/';
				$licenceInfo     = new FileLayout('licenceinfo', $basePath);
				$licenceInfoHtml = $licenceInfo->render(array('licences' => $licences));

				$licenceInfoObj = new StdClass;
				$licenceInfoObj->licenceInfoHtml = $licenceInfoHtml;
				$licenceInfoObj->startDate       = Factory::getDate($licenceTable->start_date)->format(Text::_('COM_DPE_DATE_D_M_Y'));
				$licenceInfoObj->endDate         = Factory::getDate($licenceTable->end_date)->format(Text::_('COM_DPE_DATE_D_M_Y'));
				$date =& Factory::getDate($lastLicence->end_date);
				$date->modify("+1 day");
				$licenceInfoObj->nextDate = $date->format(Text::_('COM_DPE_DATE_D_M_Y'));

				echo new JsonResponse($licenceInfoObj, $msg);
				$app->close();
			}
		}
	}
}
