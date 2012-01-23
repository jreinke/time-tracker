<?php

class ttUser extends sfGuardSecurityUser
{
  public static function authLDAP($username, $password)
  {
      $conf = sfConfig::get('app_sf_guard_plugin_ldap_params');
      $host = $conf['host'];
      $port = isset($conf['port']) ? $conf['port'] : null;
      $ldapconn = ldap_connect($host, $port);
      if ($ldapconn)
      {
          if (isset($conf['protocol']))
          {
              ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, $conf['protocol']);
          }
          $ldaprdn = sprintf($conf['base_dn'], $username);
          $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $password);
          if ($ldapbind)
          {
              ldap_unbind($ldapconn);
              return true;
          }
      }

      return false;
  }
}