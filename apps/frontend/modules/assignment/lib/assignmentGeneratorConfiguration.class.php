<?php

/**
 * assignment module configuration.
 *
 * @package    TimeTracker
 * @subpackage assignment
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class assignmentGeneratorConfiguration extends BaseAssignmentGeneratorConfiguration
{

  public function getFilterForm($filters)
  {
    $form = parent::getFilterForm($filters);

    $projectId = sfContext::getInstance()->getUser()->getCurrentProject()->getId();

    // Current project milestones
    $form->getWidget('milestone_id')->setOption('query', MilestoneTable::getInstance()->getProjectMilestonesQuery($projectId));

    // Current project modules
    $form->getWidget('module_id')->setOption('query', ModuleTable::getInstance()->getProjectModulesQuery($projectId));

    // Current project users
    $form->getWidget('user_id')->setOption('query', sfGuardUserTable::getInstance()->getProjectUsersQuery($projectId));

    return $form;
  }
}
