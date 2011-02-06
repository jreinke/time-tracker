<?php

/**
 * project actions.
 *
 * @package    TimeTracker
 * @subpackage project
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class projectActions extends sfActions
{
  public function executeSwitch(sfWebRequest $request)
  {
    $this->redirectUnless($request->hasParameter('id'), '@homepage');
    $project = ProjectTable::getInstance()->find($request->getParameter('id'));

    if ($project)
    {
      $this->getUser()->switchProject($project);
    }

    $this->redirect($request->getReferer());
  }
}
