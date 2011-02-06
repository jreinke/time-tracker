<?php

class MilestoneProfileTable extends Doctrine_Table
{
  public static function getInstance ()
  {
    return Doctrine_Core::getTable('MilestoneProfile');
  }

  public static function getMilestoneProfilesCosts($milestoneId)
  {
    $q = self::getInstance()->createQuery('mp')
      ->select('mp.profile_id, mp.cost')
      ->where('mp.milestone_id = ?', $milestoneId);

    return $q->setHydrationMode('fetch_pair')->execute();
  }
}