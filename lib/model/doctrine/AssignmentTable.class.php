<?php

class AssignmentTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Assignment');
  }

  public function retrieveAssignmentList(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
    $q->innerJoin($rootAlias . '.Task t')
      ->leftJoin($rootAlias . '.User u')
      ->leftJoin($rootAlias . '.Profile pr')
      ->innerJoin('t.Milestone m')
      ->innerJoin('t.Module mo')
      ->innerJoin('t.Priority p');

    return $q;
  }
}