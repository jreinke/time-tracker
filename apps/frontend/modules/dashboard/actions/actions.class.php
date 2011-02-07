<?php

/**
 * dashboard actions.
 *
 * @package    TimeTracker
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dashboardActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->projects = $this->getUser()->getGuardUser()->getActiveProjects();

    if ($this->getUser()->hasCurrentProject())
    {
      $project = $this->getUser()->getCurrentProject();
      $this->report_by_period = $project->getReportByPeriod();
      $this->report_by_user = $project->getReportByUser();
      $this->total_time_spent = $project->getTotalTimeSpent();
      $this->total_time_allocated = $project->getTotalTimeAllocated();
    }
  }
}
