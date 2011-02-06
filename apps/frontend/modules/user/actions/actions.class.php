<?php

require_once dirname(__FILE__).'/../lib/userGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/userGeneratorHelper.class.php';

/**
 * user actions.
 *
 * @package    TimeTracker
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends autoUserActions
{
  public function preExecute()
  {
    if (! $this->getUser()->hasCurrentProject())
    {
      $this->redirect('@homepage');
    }
    parent::preExecute();
  }

  protected function getFilters()
  {
    return array_merge(parent::getFilters(), array('project_id' => $this->getUser()->getCurrentProject()->getId()));
  }
}
