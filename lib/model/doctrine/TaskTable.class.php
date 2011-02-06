<?php

class TaskTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Task');
  }

  public function getQueryForSelect()
  {
    $q = $this->createQuery('t')
      ->select('t.*, m.name AS module')
      ->innerJoin('t.Module m')
      ->orderBy('m.name, t.name');

    return $q;
  }

  public function retrieveTaskList(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
    $q->innerJoin($rootAlias . '.Milestone m')
      ->innerJoin($rootAlias . '.Module mo')
      ->innerJoin($rootAlias . '.Priority p');

    return $q;
  }
}