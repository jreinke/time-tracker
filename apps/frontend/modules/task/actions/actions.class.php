<?php

require_once dirname(__FILE__).'/../lib/taskGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/taskGeneratorHelper.class.php';

/**
 * task actions.
 *
 * @package    TimeTracker
 * @subpackage task
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class taskActions extends autoTaskActions
{
  public function preExecute()
  {
    if (! $this->getUser()->hasCurrentProject())
    {
      $this->redirect('@homepage');
    }
    parent::preExecute();
  }

  public function executeAssignments(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    $this->task = $this->getRoute()->getObject();
    return $this->renderPartial('task/assignments');
  }

  public function executeDeleteAssignment(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    // @todo : check permissions for current project
    $return = array();
    if ($this->getRoute()->getObject()->delete())
    {
      $return['result'] = true;
    }
    else
    {
      $return['result'] = false;
      $return['message'] = sfContext::getInstance()->getI18n()->__('An error occured when deleting the assignment.');
    }

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');

    return $this->renderText(json_encode($return));
  }

  protected function getFilters()
  {
    return array_merge(parent::getFilters(), array('project_id' => $this->getUser()->getCurrentProject()->getId()));
  }
}
