<?php

require_once dirname(__FILE__).'/../lib/milestoneGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/milestoneGeneratorHelper.class.php';

/**
 * milestone actions.
 *
 * @package    TimeTracker
 * @subpackage milestone
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class milestoneActions extends autoMilestoneActions
{
  public function preExecute()
  {
    if (! $this->getUser()->hasCurrentProject())
    {
      $this->redirect('@homepage');
    }
    parent::preExecute();
  }

  public function executeSort(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    $positions = array_flip($request->getParameter('milestone'));
    $milestones = $this->getUser()->getCurrentProject()->getMilestones();

    if (! empty($positions) && $milestones->count())
    {
      foreach ($milestones as $milestone)
      {
        if (isset($positions[$milestone->getId()]))
        {
          $milestone->setPosition($positions[$milestone->getId()] + 1)->save();
        }
      }
    }
    return sfView::HEADER_ONLY;
  }

  protected function buildQuery()
  {
    $q = parent::buildQuery();
    $q->addWhere($q->getRootAlias() . '.project_id = ?', $this->getUser()->getCurrentProject()->getId())
      ->orderBy('position');

    return $q;
  }
}
