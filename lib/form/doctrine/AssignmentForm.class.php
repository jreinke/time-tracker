<?php

/**
 * Assignment form.
 *
 * @package    TimeTracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AssignmentForm extends BaseAssignmentForm
{
  public function configure()
  {
    $this->setWidget('task_id', new sfWidgetFormDoctrineChoiceGrouped(array(
      'group_by' => 'module',
      'model' => 'Task',
      'method' => 'getName',
      'table_method' => 'getQueryForSelect',
      'key_method' => 'getId',
      'add_empty' => true
    )));
    $this->getWidget('profile_id')->setOption('add_empty', true);

    if (sfContext::getInstance()->getUser()->hasCurrentProject())
    {
      // Current project users
      $this->getWidget('user_id')->setOption('query', sfGuardUserTable::getInstance()->getProjectUsersQuery(sfContext::getInstance()->getUser()->getCurrentProjectId()));
    }

    $this->validatorSchema->setPreValidator(new AssignmentValidator());
  }

  public function configureForTask(Task $task)
  {
    unset($this['is_completed']);

    $this->setWidget('force_task_id', new sfWidgetFormInputHidden());
    $this->setWidget('task_id', clone $this->getWidget('force_task_id'));

    $this->setValidator('force_task_id', new sfValidatorChoice(array('choices' => array($task->getId()), 'empty_value' => $task->getId())));
    $this->setValidator('task_id', clone $this->getValidator('force_task_id'));

    $this->setDefault('force_task_id', $task->getId());
    $this->setDefault('task_id', $task->getId());
  }
}
