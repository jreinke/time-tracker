<?php

/**
 * Project filter form.
 *
 * @package    TimeTracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProjectFormFilter extends BaseProjectFormFilter
{
  public function configure()
  {
    unset(
      $this->widgetSchema['description'],
      $this->widgetSchema['created_at'],
      $this->widgetSchema['updated_at'],
      $this->widgetSchema['day_hours'],
      $this->widgetSchema['users_list'],
      $this->widgetSchema['currency_id'],
      $this->widgetSchema['start_date']
    );
  }
}
