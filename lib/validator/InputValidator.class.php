<?php
class InputValidator extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    $this->messages['max_one_day'] = 'You cannot input more than 1 day for a given date.';
    $this->messages['is_completed'] = 'Time left must be zero if task is completed.';
  }

  protected function doClean($values)
  {
    if (null !== $values['time_spent'] && null !== $values['time_left'] && $values['assignment_id'] && $values['date'])
    {
      $assignment = AssignmentTable::getInstance()->find($values['assignment_id']);

      if ($assignment && $user = $assignment->getUser())
      {
        $timeSpent = $user->getInputTimeSpentByDate($values['date'], $values['id']);
        if ($timeSpent + $values['time_spent'] > 1)
        {
          throw new sfValidatorError($this, 'max_one_day', array('value' => $values));
        }
      }

      if ($values['is_completed'] && $values['time_left'])
      {
        throw new sfValidatorError($this, 'is_completed', array('value' => $values));
      }
    }

    return $values;
  }
}