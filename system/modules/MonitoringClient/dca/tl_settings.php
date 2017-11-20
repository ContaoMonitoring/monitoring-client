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
 * Add to palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{monitoringClient_legend},monitoringClientApiUrl,monitoringClientToken;';

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringClientApiUrl'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringClientApiUrl'],
  'inputType'               => 'text',
  'eval'                    => array('readonly'=>true, 'tl_class'=>'clr long'),
  'load_callback'           => array(array('tl_settings_MonitoringClient', 'getClientApiUrl'))
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringClientToken'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringClientToken'],
  'inputType'               => 'text',
  'eval'                    => array('readonly'=>true, 'mandatory'=>true, 'tl_class'=>'clr w50'),
  'load_callback'           => array(array('tl_settings_MonitoringClient', 'generateToken'))
);

/**
 * Class tl_settings_MonitoringClient
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * PHP version 5
 * @copyright  Cliff Parnitzky 2017-2017
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class tl_settings_MonitoringClient extends Backend
{
  /**
   * Import the back end user object
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get the url to the monitoring client api
   * @param mixed         $varValue
   * @param DataContainer $dc
   *
   * @return mixed
   */
  public function getClientApiUrl($varValue, DataContainer $dc)
  {
    return \Environment::get('base')."system/modules/MonitoringClient/api/api.php";
  }

  /**
   * Dynamically generate a token, if there is none
   * @param mixed
   * @param object
   * @return string
   */
  public function generateToken($varValue, DataContainer $dc)
  {
    if (strlen($varValue) == 0)
    {
      $varValue = md5(uniqid(mt_rand(), true));
      \Config::persist('monitoringClientToken', $varValue);
    }
    return $varValue;
  }
}

?>