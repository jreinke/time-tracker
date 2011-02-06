<?php

class ProjectUserTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('ProjectUser');
  }

  public function retrieveUserList(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
    $q->innerJoin($rootAlias . '.Permission p');

    return $q;
  }
}