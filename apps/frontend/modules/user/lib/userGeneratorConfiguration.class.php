<?php

/**
 * user module configuration.
 *
 * @package    TimeTracker
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userGeneratorConfiguration extends BaseUserGeneratorConfiguration
{
  public function getForm($object = null, $options = array())
  {
    $form = parent::getForm($object, $options);

    $projectId = sfContext::getInstance()->getUser()->getCurrentProject()->getId();
    $form->setWidget('project_id', new sfWidgetFormInputHidden());
    $form->setValidator('project_id', new sfValidatorChoice(array(
      'choices' => array($projectId),
      'empty_value' => $projectId,
      'required' => false
    )));

    return $form;
  }
}
