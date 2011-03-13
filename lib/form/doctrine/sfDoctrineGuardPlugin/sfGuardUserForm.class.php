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
      $this->widgetSchema['last_login'],
      $this->widgetSchema['created_at'],
      $this->widgetSchema['updated_at'],
      $this->widgetSchema['groups_list'],
      $this->widgetSchema['permissions_list'],
      $this->widgetSchema['projects_list'],
      $this->widgetSchema['current_project_id']
    );
    unset(
      $this->validatorSchema['algorithm'],
      $this->validatorSchema['salt'],
      $this->validatorSchema['last_login'],
      $this->validatorSchema['created_at'],
      $this->validatorSchema['updated_at'],
      $this->validatorSchema['groups_list'],
      $this->validatorSchema['permissions_list'],
      $this->validatorSchema['projects_list'],
      $this->validatorSchema['current_project_id']
    );
  }
}
