<?php

class ModuleTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Module');
  }

  public function getProjectModulesQuery($projectId)
  {
    return $this->createQuery('m')->where('m.project_id = ?', $projectId)->orderBy('m.name');
  }
}