<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

$schema['order_status_logs'] = [
    'modes' => [
        'delete'       => [
            'permissions' => 'manage_order_status_logs'
        ],
        'm_delete'     => [
            'permissions' => 'manage_order_status_logs'
	    ],
	    'm_update_statuses' => [
	        'permissions' => 'manage_order_status_logs'
        ],
        'export_range' => [
            'permissions' => 'exim_access'
        ],
    ],
    'permissions' => ['GET' => 'view_order_status_logs', 'POST' => 'manage_order_status_logs']
];
//$schema['tools']['modes']['update_status']['param_permissions']['table']['order_status_logs'] = 'manage_order_status_logs';

$schema['exim']['modes']['export']['param_permissions']['section']['order_status_logs_section'] = 'view_order_status_logs';
$schema['exim']['modes']['import']['param_permissions']['section']['order_status_logs_section'] = 'manage_order_status_logs';

return $schema;
