<?php

class InputTable extends Doctrine_Table
{
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Input');
  }

  public function getInputsByUserAndDate($userId, $date)
  {
    $q = Doctrine_Query::create()
      ->select('a.task_id AS task_id,
                pr.code AS project,
                m.id AS milestone_id,
                mo.name AS module,
                m.name AS milestone,
                a.profile_id AS profile_id,
                t.name AS task,
                prio.class AS priority,
                a.time_allocated AS time_allocated,
                i.time_spent,
                i.time_left,
                i.comment')
      ->addSelect("(SELECT SUM(i2.time_spent) FROM Input i2 WHERE i2.assignment_id = a.id AND i2.date <= '{$date}') AS total_time_spent")
      ->from('Input i')
      ->innerJoin('i.Assignment a')
      ->innerJoin('a.Task t')
      ->innerJoin('a.Profile p')
      ->innerJoin('t.Milestone m')
      ->innerJoin('t.Module mo')
      ->innerJoin('m.Project pr')
      ->innerJoin('t.Priority prio')
      ->where('a.user_id = ?', $userId)
      ->addWhere('i.date = ?', $date);

    return $q->execute();
  }

  public function getInputTimeSpentByUserAndDate($userId, $date, $excludeInputId = null)
  {
    $q = Doctrine_Query::create()
      ->select('SUM(i.time_spent) AS time_spent')
      ->from('sfGuardUser u')
      ->innerJoin('u.Assignment a')
      ->innerJoin('a.Inputs i')
      ->where('u.id = ?', $userId)
      ->addWhere('i.date = ?', $date);

    if ($excludeInputId)
    {
      $q->addWhere('i.id != ?', (int) $excludeInputId);
    }

    return $q->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)->execute();
  }

  public function getInputsForUser($userId)
  {
    $q = Doctrine_Query::create()
      ->select('i.date, SUM(i.time_spent) AS time_spent')
      ->from('Input i')
      ->innerJoin('i.Assignment a')
      ->innerJoin('a.User u')
      ->where('u.id = ?', $userId)
      ->groupBy('i.date');

    $rows = $q->fetchArray();
    $result = array();
    foreach ($rows as $row)
    {
      $result[$row['date']] = $row['time_spent'];
    }

    return $result;
  }
}