<?php

declare(strict_types=1);

/*
 * @license LGPL-3.0-or-later
 */

namespace ContaoMonitoring\Controller;

use Contao\Config;
use Contao\Input;
use Contao\System;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/_monitoring/api",
 *   name=ContaoMonitoringClientController::class,
 *   defaults={"_scope": "frontend", "_bypass_maintenance": true}
 * )
 */
class ContaoMonitoringClientController
{
    public function __invoke(Request $request, int $pageId = null): Response
    {
        $response = new JsonResponse();

        // at first we have to authenticate the request
        if (Input::get('token') != Config::get('monitoringClientToken'))
        {
            $response->setData(["error" => "TOKEN_INVALID"]);
            return $response;
        }

        if (isset($GLOBALS['TL_HOOKS']['monitoringClientDataRead']) && is_array($GLOBALS['TL_HOOKS']['monitoringClientDataRead']))
        {
            $arrData['monitoring.client.sensors'] = implode(", ", array_keys($GLOBALS['TL_HOOKS']['monitoringClientDataRead']));
            foreach ($GLOBALS['TL_HOOKS']['monitoringClientDataRead'] as $callback)
            {
                $objCallback = System::importStatic($callback[0]);
                $arrData = $objCallback->{$callback[0]}->{$callback[1]}($arrData);
            }
        }

        $arrData = array();
        $arrData['monitoring.client.version'] = MONITORING_CLIENT_VERSION;
        $arrData['monitoring.server.agent']   = $_SERVER['HTTP_USER_AGENT'];

        $response = new JsonResponse();
        $response->setData($arrData);
        return $response;
    }
}
