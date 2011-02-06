<?php

class FetchAssocHydrator extends Doctrine_Hydrator_ScalarDriver
{

  public function hydrateResultSet($stmt)
  {
    $cache = array();
    $result = array();
    while ($data = $stmt->fetch(Doctrine_Core::FETCH_ASSOC))
    {
      $result[] = $this->_gatherRowData($data, $cache, false); // do not want alias prefix
    }
    return $result;
  }
}