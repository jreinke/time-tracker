<?php

class ReportFormFilter extends sfFormFilter
{

  public function setup()
  {
    $culture = sfContext::getInstance()->getUser()->getCulture();
    $dateWidget = new sfWidgetFormI18nDate(array('culture' => $culture));

    $this->setWidgets(array(
      'milestone_id' => new sfWidgetFormDoctrineChoice(array('model' => 'Milestone', 'add_empty' => true)),
      'module_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'Module', 'add_empty' => true)),
      'profile_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'Profile', 'add_empty' => true)),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'input_date'   => new sfWidgetFormFilterDate(array(
        'with_empty' => false,
        'from_date'  => new sfWidgetFormJQueryDate(array('date_widget' => $dateWidget, 'culture' => $culture)),
        'to_date'    => new sfWidgetFormJQueryDate(array('date_widget' => $dateWidget, 'culture' => $culture)),
      )),
    ));

    if (sfContext::getInstance()->getUser()->hasCurrentProject())
    {
      $project = sfContext::getInstance()->getUser()->getCurrentProject();

      // Current project milestones
      $this->getWidget('milestone_id')->setOption('query', MilestoneTable::getInstance()->getProjectMilestonesQuery($project->getId()));

      // Current project modules
      $this->getWidget('module_id')->setOption('query', ModuleTable::getInstance()->getProjectModulesQuery($project->getId()));

      // Current project users
      $this->getWidget('user_id')->setOption('query', sfGuardUserTable::getInstance()->getProjectUsersQuery($project->getId()));
    }

    $this->setValidators(array(
      'milestone_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Milestone', 'column' => 'id')),
      'module_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Module', 'column' => 'id')),
      'profile_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Profile', 'column' => 'id')),
      'input_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'user_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('report_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}