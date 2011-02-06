<?php

require_once dirname(__FILE__).'/../lib/assignmentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/assignmentGeneratorHelper.class.php';

/**
 * assignment actions.
 *
 * @package    TimeTracker
 * @subpackage assignment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class assignmentActions extends autoAssignmentActions
{
  public function preExecute()
  {
    if (! $this->getUser()->hasCurrentProject())
    {
      $this->redirect('@homepage');
    }
    parent::preExecute();
  }

  public function executeNew(sfWebRequest $request)
  {
    parent::executeNew($request);

    if ($taskId = $request->getParameter('task_id'))
    {
      $this->form->configureForTask($this->getTask($taskId));
    }
  }

  public function executeEdit(sfWebRequest $request)
  {
    parent::executeEdit($request);

    $this->setLayout(false);

    if ($task = $this->assignment->getTask())
    {
      $this->form->configureForTask($task);
    }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $params = $request->getParameter($this->form->getName());

    if (isset($params['force_task_id']))
    {
      $form->configureForTask($this->getTask($params['force_task_id']));
    }

    $form->bind($params, $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $assignment = $form->save();
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $assignment)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        if (! $request->isXmlHttpRequest())
        {
          $this->redirect('@assignment_new');
        }
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        if (! $request->isXmlHttpRequest())
        {
          $this->redirect(array('sf_route' => 'assignment_edit', 'sf_subject' => $assignment));
        }
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }

  protected function getTask($taskId)
  {
    $task = TaskTable::getInstance()->find((int) $taskId);

    // @todo : check task validity in this project
    if (! $task)
    {
      throw new sfException(sprintf('Could not retrieve task for id "%d"', $taskId));
    }

    return $task;
  }

  protected function getFilters()
  {
    return array_merge(parent::getFilters(), array('project_id' => $this->getUser()->getCurrentProject()->getId()));
  }
}
