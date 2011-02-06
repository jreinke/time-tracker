<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
  }

  public function configureDoctrine(Doctrine_Manager $manager)
  {
    $manager->registerHydrator('fetch_assoc', 'FetchAssocHydrator');
    $manager->registerHydrator('fetch_pair', 'FetchPairHydrator');
  }
}
