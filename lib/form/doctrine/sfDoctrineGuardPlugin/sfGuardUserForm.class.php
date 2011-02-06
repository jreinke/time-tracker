<?php

/**
 * sfGuardUser form.
 *
 * @package    TimeTracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    unset(
      $this->widgetSchema['algorithm'],
      $this->widgetSchema['salt'],
      $this->widgetSchema['password'],
      $this->widgetSchema['last_login'],
      $this->widgetSchema['created_at'],
      $this->widgetSchema['updated_at'],
      $this->widgetSchema['groups_list'],
      $this->widgetSchema['permissions_list'],
      $this->widgetSchema['projects_list'],
      $this->widgetSchema['theme_id'],
      $this->widgetSchema['current_project_id']
    );
  }
}
