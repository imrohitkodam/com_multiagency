<?php
/**
 * @package     MailAlerts
 * @subpackage  com_jmailalerts
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2022 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;


HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('formbehavior.chosen', 'select');
define('JMAILALERTS_WRAPPER_CLASS', "jmailalerts-wrapper");

HTMLHelper::stylesheet('modules/mod_jmailalertguestsubscription/assets/css/style.css');

$doc = Factory::getDocument();
$useModal = (int) $params->get('useModal', 0);
$js = '
function divhide(thischk) {
    var checkboxId = thischk.id; // dynamically get the id
    var checkbox = document.getElementById(checkboxId);

    var relatedName = "ch" + thischk.value + "[]";
    var relatedCheckboxes = document.querySelectorAll("input[name=\\"" + relatedName + "\\"]");

    if (checkbox.checked) {
        document.getElementById(thischk.value).style.display = "block";

        relatedCheckboxes.forEach(function(cb) {
            cb.checked = true;
        });
    } else {
        document.getElementById(thischk.value).style.display = "none";

        relatedCheckboxes.forEach(function(cb) {
            cb.checked = false;
        });
    }
}
';


$doc->addScriptDeclaration($js);

$jmailAlertParam   = ComponentHelper::getParams('com_jmailalerts');
$guestSubscription  = $jmailAlertParam->get('guest_subcription', 'INT');

?>

<?php
$currentUrl = Uri::getInstance()->toString(array('scheme', 'host', 'path', 'query'));

$class = "jmail-form col-xs-12 col-sm-12 col-md-12 col-lg-12";
?>
<style>
.form-control-feedback{color:red;}
.card{position:relative;display:flex;flex-direction:column;min-width:0;word-wrap:break-word;background:#fff;background-clip:border-box;border:0;border-radius:.25rem;margin-left:-58px;}
.text-width{width:70%;height:fit-content;}
label{font-size:large;font-weight:600;}

.card-body {
    flex: 1 1 auto;
    padding: <?php echo ($user->id == 0) ? '1rem 1rem' : '1rem 2rem'; ?>;
}
.subbutton{background:#ff9200;box-shadow:0 4px 8px rgba(0,0,0,0.57);font-size:24px;color:white;font-weight:600;padding: 7px 16px 7px 13px; border-radius: 5px;cursor:pointer;line-height:1.42857143;transition:color .4s,background-color .4s,border-color .4s;display:inline-block;text-align:center;text-decoration:none;vertical-align:middle;border:1px solid transparent;margin-top:-13px;}
.card,.card-body,fieldset,legend{border:none!important;outline:none!important;}
.row{margin-left:0;}
input[type="text"],input[type="email"]{display:block;height:34px;padding:6px 12px;font-size:14px;line-height:1.428571429;color:#555;background:#fff;border:1px solid #ccc;border-radius:4px;box-shadow:inset 0 1px 1px rgba(0,0,0,.075);transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;width:84%;margin-left: -45px;}
.btn-close.white-close{filter:brightness(0) invert(1)}.privacymargin{margin-top:13px;color:#000;margin-bottom:-13px;margin-left:193px}.cancelclass,.unsubclass{margin-top:0;width:fit-content;padding:5px 22px;font-size:17px}.modal-backdrop.show{opacity:.3}.unsubclass{margin-left:122px}.cancelclass{color:#fff;margin-left:11px}@media only screen and (max-width:768px){.cancelclass,.card,.card-body,.divposition,.privacymargin,.unsubclass{margin-left:0!important}.card,.card-body{width:100%!important}.text-width,input[type=email],input[type=text]{width:100%!important;margin-left:0!important}.privacymargin{text-align:center}.cancelclass,.unsubclass{margin-top:10px;display:inline-block}.modal.fade .modal-dialog{margin:1rem auto;width:95%!important}.modal-content{width:100%!important;padding:15px}.emailbox{flex-direction:column;align-items:flex-start!important}.emailbox input[type=email]{margin-left:-16px!important;width:100%!important}.col-sm-4,.col-sm-8{width:100%!important;flex:0 0 100%;max-width:100%}.form-actions.text-center{text-align:center!important}h2.mb-4{font-size:1.5rem}}@media all and (device-width:768px) and (device-height:1024px){.modal-content{width:100%!important;padding:10px;box-sizing:border-box;background-color:#28282800}#unsubscribeModal{width:62%!important;margin-left:-29%!important;margin-top:19%!important;float:none!important}}@media only screen and (min-width:1024px) and (max-height:1366px) and (-webkit-min-device-pixel-ratio:1.5){.modal-content{width:100%!important;padding:10px;box-sizing:border-box;background-color:#28282800}.unsubclass{margin-top:0;width:fit-content;padding:5px 22px;font-size:17px;margin-left:16px!important}.emailbox input[type=email]{margin-left:0!important;width:100%!important;margin-top:10px}}@media only screen and (max-width:760px){.modal-content{width:100%!important;padding:15px;box-sizing:border-box}.emailbox{flex-direction:column;align-items:flex-start!important}.emailbox input[type=email]{margin-left:-16px!important;width:100%!important;margin-top:10px}.cancelclass,.unsubclass{margin-left:0!important;margin-top:5%!important;display:block;width:100%;text-align:center}.modal-header h5{font-size:1.2rem;text-align:center;width:100%}.unsubscribejmail .col-sm-4,.unsubscribejmail .col-sm-8{width:100%!important;display:block}.modal-dialog{width:90%!important;margin:auto!important}.card-body.backcolor,.divposition{margin-left:0!important}.card-body.backcolor{width:100%!important}input[type=email],input[type=text]{width:100%!important;margin-left:-16px!important}}
.modal-backdrop {z-index: 1040 !important;}.modal { z-index: 1050 !important;}

</style>
<div class="<?php echo JMAILALERTS_WRAPPER_CLASS; ?>" id="jma-emails">
    <?php if ($jmailAlertParam->get('show_page_heading')): ?>
        <div class="page-header">
            <h1>
                <?php echo $jmailAlertParam->get('page_heading'); ?>
            </h1>
        </div>
    <?php endif; ?>

    <?php
    // Added in 2.4.3
    // Newly added for JS toolbar inclusion
    if (Folder::exists(JPATH_SITE . '/components/com_community') && $jmailAlertParam->get('jstoolbar') == '1')
    {
        $jsFile = JPATH_ROOT . '/components/com_community/libraries/toolbar.php';

        if (File::exists($jsFile))
        {
            require_once $jsFile;
            $toolbar = CFactory::getToolbar();
            $tool    = CToolbarLibrary::getInstance(); ?>
            <div id="community-wrap">
                <?php
                echo $tool->getHTML(); ?>
            </div>
            <?php
        }
    }
    $user = Factory::getUser();
    ?>
    <form action="" class="form-validate form-horizontal" method="POST" id="adminform" name="adminform" ENCTYPE="multipart/form-data">
        <div class="<?php
    if ($user->id != 0) {
        echo 'card';
    } else {
        echo ($useModal == 1) ? 'subscription-box' : 'guestsubscribe subscription-box';
    }
?>" style="<?php echo ($user->id != 0)?'margin-left: 0px;border: 1px solid rgba(0, 0, 0, .125) !important;border-radius: .25rem;    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: .25rem;':'';?>" >
            <div class="card-body <?php echo ($user->id == 0)?'backcolor':'';?>" style="<?php echo ($user->id == 0)?'width: 94%;margin-left: 3px;':'';?>">
                <?php // If guest user registration enabled, then show name and email field ?>
                <?php if (($guestSubscription == 1 ) && ($user->id == 0)): ?>
                    <div class="mb-3 row">
                        <div class="<?php echo $class; ?>">
                            <div class="card">
                                <div class="card-header" style="<?php echo ($user->id == 0)?'background-color: #0096c7; font-family: Arial, sans-serif;':''?>">
                                    <h2 class="mb-4"><?php echo Text::_('COM_JMAILALERT_USER_REG'); ?> </h2>
                                   <p> <?php echo Text::_('COM_JMAILALERT_UN_REGISTER'); ?></p>
                                </div>

                                <div class="card-body <?php echo ($user->id == 0)?'backcolor':'';?>">
                                    

                                    <div class="mb-3 row <?php echo ($user->id == 0)?'divposition':'';?>" style="<?php echo ($user->id == 0)?'margin-left: -10px;':'';?>">
                                        <div class="col-sm-4 labels-jmail">
                                            <label class=""  for="user_email">
                                                <?php echo Text::_('COM_JMAILALERT_USER_EMAIL'); ?> <span style="color: red;"></span>
                                            </label>
                                        </div>
                                        <div class="col-sm-8 inputs-jmail">
                                            <input class="<?php echo ($user->id == 0)?'text-width':'';?>required validate-email form-control"
                                            type="text" name="user_email" id="user_email"
                                            size="30" maxlength="100" value="" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row <?php echo ($user->id == 0)?'divposition':'';?>" style="<?php echo ($user->id == 0)?'margin-left: -10px;':'';?>">
                                        <div class="col-sm-4 labels-jmail">
                                            <label class="" for="user_name">
                                                <?php echo Text::_('COM_JMAILALERT_USER_NAME'); ?><span style="color: red;"></span>
                                            </label>
                                        </div>
                                        <div class="col-sm-8 inputs-jmail">
                                           <input class="<?php echo ($user->id == 0)?'text-width':'';?> required validate-name form-control"
                                            type="text" name="user_name" id="user_name"
                                            size="30" maxlength="50" value="" />
                                        </div>
                                    </div>
                                     <div class="mb-3 row <?php echo ($user->id == 0)?'divposition':'';?>" style="<?php echo ($user->id == 0)?'margin-left: -10px;':'';?>">
                                        <div class="col-sm-4 labels-jmail">
                                            <label class=""  for="user_org">
                                                <?php echo Text::_('COM_JMAILALERT_USER_ORGANISATION'); ?>
                                            </label>
                                        </div>
                                        <div class="col-sm-8 inputs-jmail">
                                            <input class="<?php echo ($user->id == 0)?'text-width':'';?> form-control"
                                            type="text" name="user_org" id="user_org"
                                            size="30" maxlength="100" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (($jmailAlertParam->get('intro_msg') != '') && ($user->id != 0)): ?>
                    <div class="mb-3 row">
                        <div class="m-1">
                            <h4><?php  echo Text::_($jmailAlertParam->get('intro_msg')); ?></h4>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                $displayNone = "";

                if (trim($cntalert) == 0)
                {
                    $displayNone = "display:none";
                }

                $maplist[] = HTMLHelper::_('select.option', '0', Text::_('N0_FREQUENCY'), 'value', 'text');
                ?>

                <div class="mb-3 row" id="ac" style="<?php echo $displayNone; echo($user->id == 0)?'visibility: hidden; height: 0; overflow: hidden;':''; ?>">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin-left: 40px; width: -webkit-fill-available;">
                        <?php
                        if (trim($cntalert) != 0):
                            require ModuleHelper::getLayoutPath('mod_jmailalertguestsubscription', $params->get('layout', 'default_alerts_bs5'));
                        endif;
                        ?>
                    </div>
                </div>
               
                <div class="mb-3 row" id="manual_div">
                    <?php if ((trim($cntalert) != 0) && ($user->id == 0)): ?>
                        <div class="form-actions text-center">
                            <button class="subbutton validate" type="submit">
                                <?php echo Text::_('BUTTON_SAVE_GUEST_USER'); ?>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3 row" id="manual_div">
                    <?php if ((trim($cntalert) != 0) && ($user->id != 0)): ?>
                        <div class="form-actions text-center">
                            <button class="btn btn-primary validate" type="submit">
                                <?php echo Text::_('BUTTON_SAVE_REGISTERED_USER'); ?>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if($user->id == 0){ ?>
                 <div class="privacymargin" style="">
                    <a href="<?php echo Route::_('index.php?option=com_content&view=article&id=86', false);?>" style="color: #02080b;font-weight: 600;font-size: 17px;"><?php echo Text::_("COM_DPE_JMAILALERT_PRIVACY_NOTICE");?></a>
                    <button type="button" class="" style="color: #02080b;font-weight: 600;font-size: 17px;background:none;border:none;"data-bs-toggle="modal" data-bs-target="#unsubscribeModal"> Unsubscribe </button>
                </div>
            <?php } ?>
                <?php if (!$user->id):?>
               <!-- Trigger Button -->


<!-- Modal Structure -->
<div class="modal fade" id="unsubscribeModal" tabindex="-1" aria-labelledby="unsubscribeModalLabel" aria-hidden="true" style="">
  <div class="modal-dialog" >
    <div class="modal-content"style="width: 133%;">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="unsubscribeModalLabel"style="color:#0096c7;">Unsubscribe from Alerts</h5>
      <!--  <button type="button" class="btn" id="modalCloseBtn" aria-label="Close" style="
    color: white;font-size: 1.5rem;background: transparent;border: none;position: absolute;
    top: 10px;right: 15px;z-index: 9999;">×</button> -->
      </div>
      <!-- Modal Body with Your Form -->
      <div class="modal-body"style="background-color: #0096c7;">
        <div class="mb-3 unsubscribejmail">
          <div class="col-sm-12 d-flex align-items-center card-header mb-3 unsubhead">
            <label class="form-label invalid modallabel" for="unsubemail">
              <?php echo Text::_('COM_JMAILALERT_USER_UNSUBSCRIBES_LABEL');?>
            </label>
          </div>

          <div class="col-sm-12 d-flex align-items-center">
            <div class="col-sm-4 d-flex align-items-center has-danger">
              <label for="user_email" class='modallabel' style="margin-left: 13px;"><?php echo Text::_('COM_JMAILALERT_USER_EMAIL_UNSUB'); ?></label>
            </div>
            <div class="col-sm-8 d-flex align-items-center emailbox">
              <input class="form-control invalid unsubemail" type="email" name="unsubemail" id="unsubemail" maxlength="100" aria-invalid="true">
            </div>
          </div>

          <div class="mt-3 btnalign" >
            <a href="#" class="subbutton validate userunsub unsubclass" id="userunsubscribe"style="">
              <?php echo Text::_('COM_JMA_UNSUBSRIBE_BUTTON');?>
            </a>
            <a href="#" class="subbutton validate userunsub cancelclass" id="modalCloseBtn"style="">
              <?php echo Text::_('COM_JMA_UNSUB_CANCEL');?>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


<?php endif; ?>
            </div>
        </div>
        <input type="hidden" name="option" value="com_jmailalerts">
        <input type="hidden" id="task" name="task" value="savePref">
        <input type="hidden" id="fromModule" name="fromModule" value="1">
        <input type="hidden" name="currentUrl" id="currentUrl" value=" <?php echo $currentUrl; ?> ">
    </form>
</div>
<script type="text/javascript">
    jQuery('.alertname').click(function(event) {

       // event.preventDefault(); // Prevents checkbox state from changing

    });

    jQuery('#userunsubscribe').click(function(){

        var unsubemail = jQuery('#unsubemail').val();

        if(!unsubemail)
        {
            alert("<?php echo Text::_('COM_JMAILALERTS_EMAIL_NOT_FOUND_UNSUBSCRIBE_USER'); ?>");
            return false;
        }

        jQuery.ajax({
            url: Joomla.getOptions("system.paths").root + "/index.php?option=com_dpe&task=users.unsubJmailAlert&format=json",
            type: "POST",
            data: {'emailid':unsubemail},
            dataType: 'json',
            success:function(response)
            {   
                if(response.data == true)
                {   
                    alert(response.message);
                    location.reload();
                }
                
            }
        })
    })
jQuery(function () {
    const closeBtn = document.getElementById('modalCloseBtn');
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            const modalElement = document.getElementById('unsubscribeModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modalInstance.hide();
            jQuery('.modal-backdrop').remove();
        });
    }
});

const unsubscribeModal = document.getElementById('unsubscribeModal');

unsubscribeModal.addEventListener('shown.bs.modal', function () {
  setTimeout(() => {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
});
});

</script>