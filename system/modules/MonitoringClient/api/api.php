<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2019 Leo Feyer
 *
 * @license LGPL-3.0+
 */

// Initialize the system
if (file_exists(dirname(__DIR__) . '/../../../../../../system/initialize.php'))
{
  // Contao 4 environment
  define('TL_SCRIPT', ""); // Needed for Contao 4+
  if (!\defined('TL_MODE'))
  {
    \define('TL_MODE', ""); // Needed for Contao 4.5+
  }
  
  require dirname(__DIR__) . '/../../../../../../system/initialize.php';
}
else
{
  require dirname(__DIR__) . '/../../../system/initialize.php';
}

// Get the data
$client = new MonitoringClient();
echo $client->getData();

?>