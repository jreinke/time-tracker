<?php
class ProjectTable extends Doctrine_Table
{
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Project');
  }

  public function getProjectUserAssignments($projectId, $userId, $withTimeSpent = true, $isCompleted = false)
  {
    $q = Doctrine_Query::create()
      ->select('m.*,
                mo.*,
                t.*,
                p.*,
                prio.*,
                a.*,
                SUM(i.time_spent) as time_spent')
      ->addSelect('(SELECT i2.time_left FROM Input i2 WHERE i2.assignment_id = a.id ORDER BY i2.date DESC LIMIT 1) AS time_left')
      ->from('Assignment a')
      ->innerJoin('a.Task t')
      ->innerJoin('t.Milestone m')
      ->innerJoin('t.Module mo')
      ->innerJoin('a.Profile p')
      ->innerJoin('t.Priority prio');

    if ($withTimeSpent)
    {
      $q->innerJoin('a.Inputs i');
    }
    else
    {
      $q->leftJoin('a.Inputs i')
        ->addWhere('i.id IS NULL');
    }

    $q->addWhere('a.user_id = ?', $userId)
      ->addWhere('m.project_id = ?', $projectId)
      ->addWhere('a.is_completed = ?', (int) $isCompleted)
      ->groupBy('a.id');

    return $q->execute();
  }

  public function getProjectOverview($projectId, $filters = array())
  {
    $q = Doctrine_Query::create()
      ->select('m.id AS milestone_id,
                mo.id AS module_id,
                p.id AS profile_id,
                t.id AS task_id,
                m.name AS milestone,
                mo.name AS module,
                m.start_date AS milestone_start_date,
                m.end_date AS milestone_end_date,
                t.name AS task,
                SUM(a.time_estimated) AS time_estimated,
                SUM(a.time_allocated) AS time_allocated')
      ->from('Milestone m')
      ->leftJoin('m.Tasks t')
      ->leftJoin('t.Module mo')
      ->leftJoin('t.Assignments a')
      ->leftJoin('a.Profile p')
      ->where('m.project_id = ?', $projectId)
      ->groupBy('m.id, t.id, p.id')
      ->orderBy('m.position ASC, mo.name ASC, t.name ASC');

    if (! empty($filters))
    {
      foreach ($filters as $col => $value)
      {
        if (null === $value)
        {
          continue;
        }

        switch ($col)
        {
          case 'user_id':
            $q->addWhere('a.user_id = ?', $value);
            break;
          case 'milestone_id':
            $q->addWhere('m.id = ?', $value);
            break;
          case 'module_id':
            $q->addWhere('mo.id = ?', $value);
            break;
          default: // nothing to do
        }
      }
    }

    return $q->setHydrationMode('fetch_assoc')->execute();
  }

  public function getProjectReport($projectId, $filters = array())
  {
    $q = Doctrine_Query::create()
      ->select('a.id,
      			YEARWEEK(i.date) AS period,
                u.id AS user_id,
                a.id AS assignment_id,
                a.is_completed AS is_completed,
                m.id AS milestone_id,
                mo.id AS module_id,
                t.id AS task_id,
                m.name AS milestone,
                mo.name AS module,
                t.name AS task,
                u.first_name AS first_name,
                u.last_name AS last_name,
                a.time_estimated AS time_estimated,
                a.time_allocated AS time_allocated,
                SUM(i.time_spent) AS time_spent')
      ->addSelect('IFNULL((SELECT i2.time_left FROM Input i2 WHERE i2.assignment_id = a.id ORDER BY i2.date DESC LIMIT 1), a.time_allocated) AS time_left')
      ->from('Assignment a')
      ->leftJoin('a.Inputs i')
      ->innerJoin('a.Task t')
      ->innerJoin('a.Profile p')
      ->innerJoin('t.Milestone m')
      ->innerJoin('t.Module mo')
      ->leftJoin('a.User u')
      ->where('m.project_id = ?', $projectId)
      ->groupBy('a.id')
      ->orderBy('i.date');

    if (! empty($filters))
    {
      foreach ($filters as $col => $value)
      {
        if (null === $value)
        {
          continue;
        }

        switch ($col)
        {
          case 'milestone_id':
            $q->addWhere('m.id = ?', $value);
            break;

          case 'module_id':
            $q->addWhere('mo.id = ?', $value);
            break;

          case 'profile_id':
            $q->addWhere('p.id = ?', $value);
            break;

          case 'user_id':
            $q->addWhere('u.id = ?', $value);
            break;

          case 'input_date':
            if (isset($value['from']))
            {
              $q->addWhere('i.date >= ?', $value['from']);
            }

            if (isset($value['to']))
            {
              $q->addWhere('i.date <= ?', $value['to']);
            }
            break;

          default: // nothing to do
        }
      }
    }

    return $q->setHydrationMode('fetch_assoc')->execute();
  }

  public function getProjectMilestonesProfilesCosts($projectId)
  {
    $q = Doctrine_Query::create()
      ->select('m.id AS milestone_id, p.id AS profile_id, mp.cost AS cost')
      ->from('Milestone m')
      ->innerJoin('m.MilestoneProfiles mp')
      ->innerJoin('mp.Profile p')
      ->where('m.project_id = ?', $projectId);

    $rows = $q->setHydrationMode('fetch_assoc')->execute();
    $result = array();

    foreach ($rows as $row)
    {
      $result[$row['milestone_id']][$row['profile_id']] = $row['cost'];
    }

    return $result;
  }

  public function getProjectProfiles($projectId)
  {
    $q = ProfileTable::getInstance()->createQuery('p')
      ->innerJoin('p.Assignments a')
      ->innerJoin('a.Task t')
      ->innerJoin('t.Milestone m')
      ->where('m.project_id = ?', $projectId)
      ->groupBy('p.id')
      ->orderBy('p.id');

    return $q->execute();
  }

  public function getUserActiveProjects($userId)
  {
    $q = $this->createQuery('p')
      ->innerJoin('p.ProjectUsers pu')
      ->where('pu.user_id = ?', $userId)
      ->andWhere('p.is_archived = 0');

    return $q->execute();
  }
}