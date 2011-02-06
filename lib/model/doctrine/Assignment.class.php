<?php

/**
 * Assignment
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    TimeTracker
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Assignment extends BaseAssignment
{
  public function construct()
  {
    parent::construct();
    sfProjectConfiguration::getActive()->loadHelpers('InputTime');
  }

  public function getTimeEstimated()
  {
    return $this->isNew() ? $this->_get('time_estimated') : format_time($this->_get('time_estimated'));
  }

  public function getTimeAllocated()
  {
    return $this->isNew() ? $this->_get('time_allocated') : format_time($this->_get('time_allocated'));
  }
}