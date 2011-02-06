<?php

class sfGuardUserTable extends PluginsfGuardUserTable
{
  public static function getInstance()
  {
    return Doctrine_Core::getTable('sfGuardUser');
  }

  public function getProjectUsersQuery($projectId)
  {
    $q = $this->createQuery('u')
      ->innerJoin('u.ProjectUsers p')
      ->where('p.project_id = ?', $projectId);

    return $q;
  }
}