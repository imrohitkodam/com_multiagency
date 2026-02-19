<?php
/**
 * @version    CVS: 1.0.0
	* @package    Com_Multiagency
 * @author     Techjoomla <contact@techjoomla.com>
 * @copyright  2017 Techjoomla
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;


\Joomla\CMS\HTML\HTMLHelper::_('behavior.keepalive');
\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip');
\Joomla\CMS\HTML\HTMLHelper::_('behavior.formvalidator');

// \Joomla\CMS\HTML\HTMLHelper::_('behavior.modal');

// Load admin language file
$lang = \Joomla\CMS\Factory::getLanguage();
$lang->load('com_multiagency', JPATH_SITE);
$user    = \Joomla\CMS\Factory::getUser();
$JUriRoot = \Joomla\CMS\Uri\Uri::root();

$canEdit    = $user->authorise('core.edit', 'com_multiagency');
\Joomla\CMS\Language\Text::script('COM_MULTIAGENCY_DUPLICATE_MANAGER');
\Joomla\CMS\HTML\HTMLHelper::script( \Joomla\CMS\Uri\Uri::root().'media/com_multiagency/js/multiagency.js' );

?>
<div class="multiagency-edit front-end-edit">
	<div class="page-header">
	<?php if (!$canEdit) : ?>
		<h2>
			<?php throw new Exception(\Joomla\CMS\Language\Text::_('COM_MULTIAGENCY_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h2>
	<?php else : ?>
	<?php if (!empty($this->item->id)): ?>
	<h2><?php echo \Joomla\CMS\Language\Text::sprintf('COM_MULTIAGENCY_EDIT_ITEM_TITLE', \Joomla\CMS\Language\Text::_('COM_MULTIAGENCY_ORGANISATION')); ?></h2>
	<?php else: ?>
	<h2><?php echo \Joomla\CMS\Language\Text::sprintf('COM_MULTIAGENCY_ADD_ITEM', \Joomla\CMS\Language\Text::_('COM_MULTIAGENCY_ORGANISATION')); ?></h2>
	<?php endif; ?>
	</div>
	<div class="col-xs-12 col-sm-7 col-md-7">
		<div class="clearfix">&nbsp;</div>
		<form id="form-multiagency" action="<?php echo \Joomla\CMS\Router\Route::_('index.php?option=com_multiagency&task=multiagency.save'); ?>" method="post" class="form-validate form-horizontal dp-form-styling" enctype="multipart/form-data">
			<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
			<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
			<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
			<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
			<?php echo $this->form->getInput('created_by'); ?>
			<?php echo $this->form->getInput('modified_by'); ?>
			<div class="control-group">
				<div class="control-label">
					<?php echo $this->form->getLabel('title'); ?>
				</div>
				<div class="controls">
					<?php echo $this->form->getInput('title'); ?>
				</div>
			</div>
			<?php echo \Joomla\CMS\Layout\LayoutHelper::render('joomla.edit.params', $this); ?>
			<?php echo $this->form->renderField('manager'); ?>
			<?php echo $this->form->renderField('id'); ?>

			<?php echo $this->form->renderField('category_id'); ?>
			<div class="control-group">
				<div class="controls text-right">
					<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary" onclick="return checkDuplicates();">
						<?php echo \Joomla\CMS\Language\Text::_( 'JSUBMIT'); ?>
					</button>
					<?php endif; ?>
					<a class="btn btn-default" href="<?php echo \Joomla\CMS\Router\Route::_('index.php?option=com_multiagency&task=multiagences'); ?>" title="<?php echo \Joomla\CMS\Language\Text::_('JCANCEL'); ?>">
						<?php echo \Joomla\CMS\Language\Text::_( 'JCANCEL'); ?>
					</a>
				</div>
			</div>
			<input type="hidden" name="option" value="com_multiagency" />
			<input type="hidden" name="task" value="multiagencyform.save" />
			<?php echo \Joomla\CMS\HTML\HTMLHelper::_( 'form.token'); ?>
			<?php echo \Joomla\CMS\HTML\HTMLHelper::_( 'jquery.token'); ?>
		</form>
	</div>
	<?php endif; ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	var id = parseInt(<?php echo $this->item->id;?>);

	if (id)
	{
		jQuery('.extravalue').attr('readonly', true);
	}

	var UriRoot = "<?php echo $UriRoot; ?>";

	});
	var UriRoot = "<?php echo $UriRoot; ?>";
</script>

