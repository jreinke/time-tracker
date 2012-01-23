<?php


class PriorityTable extends Doctrine_Table
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Priority');
    }

    public function construct()
    {
      $this->_options['orderBy'] = 'id asc';
    }
}