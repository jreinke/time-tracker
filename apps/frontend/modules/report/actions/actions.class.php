<?php

/**
 * report actions.
 *
 * @package    TimeTracker
 * @subpackage report
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportActions extends sfActions
{
  protected static $reportColsMap = array(
    'user'       => 'user_id',
    'milestone'  => 'milestone_id',
    'module'     => 'module_id',
    'profile'    => 'profile_id',
    'task'       => 'task_id',
    'assignment' => 'assignment_id',
  );

  public function preExecute()
  {
    if (! $this->getUser()->hasCurrentProject())
    {
      $this->redirect('@homepage');
    }
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->group_by = $request->getParameter('by', $this->getUser()->getAttribute('group_by', 'user', 'report.group_by'));
    $this->getUser()->setAttribute('group_by', $this->group_by, 'report.group_by');
    $project = $this->getUser()->getCurrentProject();
    $this->filters = new ReportFormFilter();
    $this->filters->setDefaults($this->getFilters());
    $col = self::$reportColsMap[$this->group_by];
    $this->report = $project->getReportBy($col, $this->getFilters(), $this->group_by);
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->filters = new ReportFormFilter();
    $this->filters->bind($request->getParameter($this->filters->getName()));

    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());
      $this->redirect('@report');
    }

    $this->report = array();
    $this->setTemplate('index');
  }

  public function executeResetFilter(sfWebRequest $request)
  {
    $this->setFilters(array());
    $this->redirect('@report');
  }

  protected function getFilters()
  {
    return $this->getUser()->getAttribute('report.filters', array(), 'admin_module');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('report.filters', $filters, 'admin_module');
  }
}
