<?php

/**
 * Module form.
 *
 * @package    TimeTracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ModuleForm extends BaseModuleForm
{
  public function configure()
  {
    $this->widgetSchema->setNameFormat('project_module[%s]');
  }
}
