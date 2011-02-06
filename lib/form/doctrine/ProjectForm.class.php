<?php

/**
 * Project form.
 *
 * @package    TimeTracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProjectForm extends BaseProjectForm
{
  public function configure()
  {
    unset(
      $this->widgetSchema['created_at'],
      $this->widgetSchema['updated_at'],
      $this->widgetSchema['start_date'],
      $this->widgetSchema['users_list'],
      $this->validatorSchema['created_at'],
      $this->validatorSchema['updated_at']
    );
    $dateWidget = new sfWidgetFormI18nDate(array('culture' => sfContext::getInstance()->getUser()->getCulture()));
    $this->setWidget('start_date', new sfWidgetFormJQueryDate(array('culture' => sfContext::getInstance()->getUser()->getCulture(), 'date_widget' => $dateWidget)));
  }
}
