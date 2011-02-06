<?php

/**
 * overview actions.
 *
 * @package    TimeTracker
 * @subpackage overview
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class overviewActions extends sfActions
{
  public function preExecute()
  {
    if (! $this->getUser()->hasCurrentProject())
    {
      $this->redirect('@homepage');
    }
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->filters = new OverviewFormFilter();
    $this->filters->setDefaults($this->getFilters());
    $this->overview = $this->getUser()->getCurrentProject()->getOverview($this->getFilters());
    $this->profiles = $this->getUser()->getCurrentProject()->getProfiles();
    $this->costs = $this->getUser()->getCurrentProject()->getMilestonesProfilesCosts();
    $this->currency = $this->getUser()->getCurrentProject()->getCurrency()->getSymbol();
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->filters = new OverviewFormFilter();
    $this->filters->bind($request->getParameter($this->filters->getName()));

    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());
      $this->redirect('@overview');
    }

    $this->setTemplate('index');
  }

  public function executeResetFilter(sfWebRequest $request)
  {
    $this->setFilters(array());
    $this->redirect('@overview');
  }

  protected function getFilters()
  {
    return $this->getUser()->getAttribute('overview.filters', array(), 'admin_module');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('overview.filters', $filters, 'admin_module');
  }
}
