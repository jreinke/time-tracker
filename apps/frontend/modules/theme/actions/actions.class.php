<?php

/**
 * theme actions.
 *
 * @package    TimeTracker
 * @subpackage theme
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class themeActions extends sfActions
{
  public function executeSwitch(sfWebRequest $request)
  {
    $this->redirectUnless($request->hasParameter('id'), '@homepage');
    $theme = ThemeTable::getInstance()->find($request->getParameter('id'));
    if ($theme)
    {
      $this->getUser()->getGuardUser()->setThemeId($theme->getId())->save();
    }
    $this->redirect($request->getReferer());
  }
}
