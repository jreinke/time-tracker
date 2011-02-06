<?php

/**
 * milestone module configuration.
 *
 * @package    TimeTracker
 * @subpackage milestone
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class milestoneGeneratorConfiguration extends BaseMilestoneGeneratorConfiguration
{
  public function getForm($object = null, $options = array())
  {
    $form = parent::getForm($object, $options);
    unset($form['project_id'], $form['position']);

    $form->setWidget('project_id', new sfWidgetFormInputHidden());
    $form->setValidator('project_id', new sfValidatorChoice(array(
      'choices' => array(sfContext::getInstance()->getUser()->getCurrentProject()->getId()),
      'empty_value' => sfContext::getInstance()->getUser()->getCurrentProject()->getId(),
      'required' => false
    )));

    return $form;
  }
}
