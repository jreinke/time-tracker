<?php

/**
 * Assignment filter form.
 *
 * @package    TimeTracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AssignmentFormFilter extends BaseAssignmentFormFilter
{

  public function configure()
  {
    unset(
      $this->widgetSchema['time_estimated'],
      $this->widgetSchema['time_allocated']
    );

    $this->setWidget('project_id', new sfWidgetFormDoctrineChoice(array('model' => 'Project', 'add_empty' => true)));
    $this->setValidator('project_id', new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Project', 'column' => 'id')));

    $this->setWidget('milestone_id', new sfWidgetFormDoctrineChoice(array('model' => 'Milestone', 'add_empty' => true)));
    $this->setValidator('milestone_id', new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Milestone', 'column' => 'id')));

    $this->setWidget('module_id', new sfWidgetFormDoctrineChoice(array('model' => 'Module', 'add_empty' => true)));
    $this->setValidator('module_id', new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Module', 'column' => 'id')));
  }

  public function addProjectIdColumnQuery(Doctrine_Query $query, $field, $value)
  {
    $query->andWhere('m.project_id = ?', $value);
  }

  public function addMilestoneIdColumnQuery(Doctrine_Query $query, $field, $value)
  {

    $query->andWhere('t.milestone_id = ?', $value);
  }

  public function addModuleIdColumnQuery(Doctrine_Query $query, $field, $value)
  {
    $query->andWhere('t.module_id = ?', $value);
  }
}
