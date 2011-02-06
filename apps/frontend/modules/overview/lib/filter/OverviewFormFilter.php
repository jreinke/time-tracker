<?php

class OverviewFormFilter extends sfFormFilter
{

  public function setup()
  {
    $this->setWidgets(array(
      'milestone_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Milestone', 'add_empty' => true)),
      'module_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'Module', 'add_empty' => true)),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $projectId = sfContext::getInstance()->getUser()->getCurrentProjectId();

    if ($projectId)
    {
      // Current project milestones
      $this->getWidget('milestone_id')->setOption('query', MilestoneTable::getInstance()->getProjectMilestonesQuery($projectId));

      // Current project modules
      $this->getWidget('module_id')->setOption('query', ModuleTable::getInstance()->getProjectModulesQuery($projectId));

      // Current project users
      $this->getWidget('user_id')->setOption('query', sfGuardUserTable::getInstance()->getProjectUsersQuery($projectId));
    }

    $this->setValidators(array(
      'milestone_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Milestone', 'column' => 'id')),
      'module_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Module', 'column' => 'id')),
      'user_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('overview_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}