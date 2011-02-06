<?php

/**
 * Milestone form.
 *
 * @package    TimeTracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MilestoneForm extends BaseMilestoneForm
{
  public function configure()
  {
    unset(
      $this->widgetSchema['creator_id'],
      $this->widgetSchema['created_at'],
      $this->widgetSchema['updated_at'],
      $this->widgetSchema['start_date'],
      $this->widgetSchema['end_date'],
      $this->widgetSchema['users_list'],
      $this->validatorSchema['created_at'],
      $this->validatorSchema['updated_at']
    );

    $dateWidget = new sfWidgetFormI18nDate(array('culture' => sfContext::getInstance()->getUser()->getCulture()));
    $this->setWidget('start_date', new sfWidgetFormJQueryDate(array('culture' => sfContext::getInstance()->getUser()->getCulture(), 'date_widget' => $dateWidget)));
    $this->setWidget('end_date', new sfWidgetFormJQueryDate(array('culture' => sfContext::getInstance()->getUser()->getCulture(), 'date_widget' => $dateWidget)));

    $subForm = new sfForm();
    $profiles = ProfileTable::getInstance()->findAll();

    foreach ($profiles as $profile)
    {
      $subForm->setWidget($profile->getId(), new sfWidgetFormInputText(array('label' => $profile->getName())));
      $subForm->setValidator($profile->getId(), new sfValidatorInteger(array('required' => false)));
    }

    if (! $this->object->isNew())
    {
      $subForm->setDefaults($this->object->getProfilesCosts());
    }

    $this->embedForm('costs', $subForm);
  }

  protected function doSave($con = null)
  {
    parent::doSave($con);
    $this->saveProfileCosts($con);
  }

  public function saveProfileCosts($con = null)
  {
    if (! $this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (! isset($this->widgetSchema['costs']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->getProfilesCosts();

    $values = $this->getValue('costs');
    if (!is_array($values))
    {
      $values = array();
    }

    // Update
    $update = array_intersect_key($values, $existing);
    foreach ($update as $profileId => $cost)
    {
      $q = Doctrine_Query::create($con)
        ->update('MilestoneProfile')
        ->set('cost', (int) $cost)
        ->where('milestone_id = ?', $this->object->getId())
        ->addWhere('profile_id = ?', $profileId)
        ->execute();
    }

    // Insert
    $insert = array_diff_key($values, $existing);
    foreach ($insert as $profileId => $cost)
    {
      if (null === $cost)
      {
        continue;
      }

      $mp = new MilestoneProfile();
      $mp->fromArray(array(
        'milestone_id' => $this->object->getId(),
        'profile_id' => $profileId,
        'cost' => $cost
      ));
      $mp->save();
    }
  }
}
