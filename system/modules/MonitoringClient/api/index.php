<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */

// Initialize the system
define('TL_MODE', 'BE');
require dirname(__DIR__) . '../../../../system/initialize.php';

// Get the data
$client = new MonitoringClient();
echo $client->getData();

?>