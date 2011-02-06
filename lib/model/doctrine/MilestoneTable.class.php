<?php

class MilestoneTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Milestone');
  }

  public function getProjectMilestonesQuery($projectId)
  {
    return $this->createQuery('m')->where('m.project_id = ?', $projectId)->orderBy('m.position');
  }
}