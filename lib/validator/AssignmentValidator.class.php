<?php
class AssignmentValidator extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'Task owner cannot be changed because %user% has already input on the task.');
  }

  protected function doClean($values)
  {
    if ($values['id'] && ($assignment = AssignmentTable::getInstance()->find($values['id'])))
    {
      if ($assignment->getUserId() != $values['user_id'] && $assignment->getInputs()->count())
      {
        throw new sfValidatorError($this, 'invalid', array('user' => $assignment->getUser()->getName()));
      }
    }

    return $values;
  }
}