<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2017 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Cliff Parnitzky 2017-2017
 * @author     Cliff Parnitzky
 * @package    MonitoringClient
 * @license    LGPL
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Monitoring;

/**
 * Class MonitoringClient
 *
 * Read data from current system and send it back to requesting server.
 * @copyright  Cliff Parnitzky 2017-2017
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class MonitoringClient extends \Backend
{
  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * Read the data and send the back as json.
   */
  public function getData()
  {
    // at first we have to authenticate the request
    if (\Input::get('token') != \Config::get('monitoringClientToken'))
    {
      return json_encode(array("error"=>"TOKEN_INVALID"));
    }
    
    $arrData = array();
    $arrData['monitoring.client.version'] = MONITORING_CLIENT_VERSION;
    $arrData['monitoring.server.agent']   = $_SERVER['HTTP_USER_AGENT'];
    
    if (isset($GLOBALS['TL_HOOKS']['monitoringClientDataRead']) && is_array($GLOBALS['TL_HOOKS']['monitoringClientDataRead']))
    {
      $arrData['monitoring.client.sensors'] = implode(", ", array_keys($GLOBALS['TL_HOOKS']['monitoringClientDataRead']));
      foreach ($GLOBALS['TL_HOOKS']['monitoringClientDataRead'] as $callback)
      {
        $this->import($callback[0]);
        $arrData = $this->{$callback[0]}->{$callback[1]}($arrData);
      }
    }

    echo json_encode($arrData);
  }
}

?>