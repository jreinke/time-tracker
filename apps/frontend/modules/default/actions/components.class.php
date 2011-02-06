<?php
class defaultComponents extends sfComponents
{
  public function executeProjectSwitcher()
  {
    $this->projects = $this->user->getGuardUser()->getActiveProjects();
  }

  public function executeThemeSwitcher()
  {
    $this->themes = ThemeTable::getInstance()->findAll();
  }
}