<?php

/**
 * Milestone filter form.
 *
 * @package    TimeTracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MilestoneFormFilter extends BaseMilestoneFormFilter
{
  public function configure()
  {
    unset(
      $this->widgetSchema['description'],
      $this->widgetSchema['position']
    );
  }
}
