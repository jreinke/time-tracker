<?php

/**
 * task module configuration.
 *
 * @package    TimeTracker
 * @subpackage task
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class taskGeneratorConfiguration extends BaseTaskGeneratorConfiguration
{
  public function getFilterForm($filters)
  {
    $form = parent::getFilterForm($filters);

    $projectId = sfContext::getInstance()->getUser()->getCurrentProject()->getId();

    // Current project milestones
    $form->getWidget('milestone_id')->setOption('query', MilestoneTable::getInstance()->getProjectMilestonesQuery($projectId));

    // Current project modules
    $form->getWidget('module_id')->setOption('query', ModuleTable::getInstance()->getProjectModulesQuery($projectId));

    $form->setWidget('project_id', new sfWidgetFormInputHidden(array('default' => $projectId)));
    $form->setValidator('project_id', new sfValidatorChoice(array(
      'choices' => array($projectId),
      'empty_value' => $projectId,
      'required' => false
    )));

    return $form;
  }

  public function getForm($object = null, $options = array())
  {
    $form = parent::getForm($object, $options);

    $projectId = sfContext::getInstance()->getUser()->getCurrentProject()->getId();

    // Current project milestones
    $form->getWidget('milestone_id')->setOption('query', MilestoneTable::getInstance()->getProjectMilestonesQuery($projectId));

    // Current project modules
    $form->getWidget('module_id')->setOption('query', ModuleTable::getInstance()->getProjectModulesQuery($projectId));

    $form->setWidget('project_id', new sfWidgetFormInputHidden(array('default' => $projectId)));
    $form->setValidator('project_id', new sfValidatorChoice(array(
      'choices' => array($projectId),
      'empty_value' => $projectId,
      'required' => false
    )));

    return $form;
  }
}
