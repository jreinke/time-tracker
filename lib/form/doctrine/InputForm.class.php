<?php

/**
 * Input form.
 *
 * @package    TimeTracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InputForm extends BaseInputForm
{
  public function configure()
  {
    unset(
      $this->widgetSchema['created_at'],
      $this->widgetSchema['updated_at'],
      $this->validatorSchema['created_at'],
      $this->validatorSchema['updated_at'],
      $this->validatorSchema['time_spent'],
      $this->validatorSchema['time_left']
    );

    $this->setValidator('time_spent', new sfValidatorNumber(array('min' => 0.1, 'max' => 1)));
    $this->setValidator('time_left', new sfValidatorNumber(array('min' => 0)));

    $this->setWidget('is_completed', new sfWidgetFormInputCheckbox());
    $this->setValidator('is_completed', new sfValidatorBoolean(array('required' => false)));

    $this->validatorSchema->setPostValidator(new InputValidator());
  }
}
