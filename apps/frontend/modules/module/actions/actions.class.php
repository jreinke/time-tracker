<?php

require_once dirname(__FILE__).'/../lib/moduleGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/moduleGeneratorHelper.class.php';

/**
 * module actions.
 *
 * @package    TimeTracker
 * @subpackage module
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class moduleActions extends autoModuleActions
{
  public function preExecute()
  {
    if (! $this->getUser()->hasCurrentProject())
    {
      $this->redirect('@homepage');
    }
    parent::preExecute();
  }

  protected function buildQuery()
  {
    $q = parent::buildQuery();
    $q->addWhere($q->getRootAlias() . '.project_id = ?', $this->getUser()->getCurrentProject()->getId())
      ->orderBy('name');

    return $q;
  }
}
