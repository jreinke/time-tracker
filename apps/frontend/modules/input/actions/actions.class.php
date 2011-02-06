<?php

/**
 * input actions.
 *
 * @package    TimeTracker
 * @subpackage input
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inputActions extends sfActions
{
  public function preExecute()
  {
    if (! $this->getUser()->hasCurrentProject())
    {
      $this->redirect('@homepage');
    }
    if ($this->getRequest()->isMethod('post') && $this->getRequest()->hasParameter('cancel'))
    {
      $this->redirect(sprintf('@input_date?date=%s', $this->getRequest()->getParameter('date')));
    }
  }

  public function executeIndex(sfWebRequest $request)
  {
    $date = $this->getDate();

    if ($request->hasAttribute('new_input'))
    {
      // new input request
      $assignment = $request->getParameter('assignment_object');
      $this->input_form = new InputForm();
      $this->assignment = $assignment;
    }
    else if ($request->hasAttribute('edit_input'))
    {
      // edit input request
      $input = $request->getParameter('input_object');
      $this->input_form = new InputForm($input);
      $this->input_form->setDefault('is_completed', $input->getAssignment()->getIsCompleted());
      $this->input = $input;
      $this->assignment = $input->getAssignment();
    }

    if ($request->isMethod('post') && isset($this->input_form))
    {
      $params = $request->getParameter($this->input_form->getName());
      $params['assignment_id'] = $this->assignment->getId();
      $params['date'] = $date;
      $this->saveInput($params, $this->input_form);
    }

    $sfGuardUser = $this->getUser()->hasCurrentInputsUser() ? $this->getUser()->getCurrentInputsUser() : $this->getUser()->getGuardUser();
    $project = $this->getUser()->getCurrentProject();
    $this->date = $date;
    $this->milestones = $project->getMilestones();
    $this->current_assignments = $project->getUserAssignments($sfGuardUser);
    $this->waiting_assignments = $project->getUserAssignments($sfGuardUser, false);
    $this->completed_assignments = $project->getUserAssignments($sfGuardUser, true, true);
    $this->inputs = $sfGuardUser->getInputsByDate($date);
    $this->all_inputs = $sfGuardUser->getInputs();
    $this->users = $project->getUsers();
    $this->sf_guard_user = $sfGuardUser;
  }

  protected function saveInput(array $params, sfForm $form)
  {
    $form->bind($params);

    if ($form->isValid())
    {
      try
      {
        $input = $form->save();
        $input->getAssignment()->setIsCompleted($form->getValue('is_completed'))->save();
      }
      catch (Exception $e)
      {
        $this->getUser()->setFlash('error', 'An error occured while saving input');
        return sfView::SUCCESS;
      }

      $this->getUser()->setFlash('notice', 'Input was saved successfully');
      $this->redirect(sprintf('@input_date?date=%s', $input->getDate()));
    }
  }

  public function executeNew(sfWebRequest $request)
  {
    $assignment = AssignmentTable::getInstance()->find($request->getParameter('assignment_id'));

    if (! $assignment || ! $this->getUser()->hasAssignment($assignment))
    {
      $this->redirect('@input_date?date=' . $this->getDate());
    }

    $input = InputTable::getInstance()->findOneByAssignmentIdAndDate($assignment->getId(), $request->getParameter('date'));

    if ($input)
    {
      // an input already exists for this assignment and date, just edit it
      $this->redirect(sprintf('@input_edit?id=%d', $input->getId()));
    }

    $request->setParameter('assignment_object', $assignment);
    $request->setAttribute('new_input', true);
    $this->forward('input', 'index');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $input = InputTable::getInstance()->find($request->getParameter('id'));

    if (! $input || ! $this->getUser()->hasAssignment($input->getAssignment()))
    {
      $this->redirect('@input_date?date=' . $this->getDate());
    }

    $request->setParameter('input_object', $input);
    $request->setParameter('date', $input->getDate());
    $request->setAttribute('edit_input', true);
    $this->forward('input', 'index');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $input = InputTable::getInstance()->find($request->getParameter('id'));

    if (! $input)
    {
      $this->getUser()->setFlash('error', 'Could not find input.');
      $this->redirect('@input');
    }

    $date = $input->getDate();

    if ($input->delete())
    {
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    }

    $this->redirect(sprintf('@input_date?date=%s', $date));
  }

  public function executeSwitchUser(sfWebRequest $request)
  {
    if ($request->isMethod('post') && $request->hasParameter('user_id'))
    {
      $project = $this->getUser()->getCurrentProject();
      $user = sfGuardUserTable::getInstance()->find((int) $request->getParameter('user_id'));

      if ($project && $user && $user->hasProject($project))
      {
        $this->getUser()->setCurrentInputsUser($user);
      }
    }

    $this->redirect($request->getReferer());
  }

  protected function getDate()
  {
    $request = $this->getRequest();
    $date = date('Y-m-d');

    if ($request->hasParameter('date'))
    {
      try
      {
        $checkDate = $request->getParameter('date');
        $validator = new sfValidatorDate();
        $checkDate = $validator->clean($checkDate);
        $date = $checkDate; // date is ok here
      }
      catch (Exception $e)
      {
        // nothing to do, just keep current date
      }
    }

    return $date;
  }
}
