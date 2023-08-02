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

use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');

if ($mode === 'manage') {
    $params = array_merge(
        ['items_per_page' => Registry::get('settings.Appearance.admin_elements_per_page')],
        $_REQUEST
    );

/*
    $params['company_id'] = Registry::get('runtime.company_id');

    list($call_requests, $search) = fn_get_call_requests($params, DESCR_SL);

    $statuses = db_get_list_elements('call_requests', 'status', true, DESCR_SL, 'call_requests.status.');
    $order_statuses = fn_get_statuses(STATUSES_ORDER);
    $responsibles = fn_call_requests_get_responsibles();

    Tygh::$app['view']
        ->assign('call_requests', $call_requests)
        ->assign('search', $search)
        ->assign('call_request_statuses', $statuses)
        ->assign('order_statuses', $order_statuses)
        ->assign('responsibles', $responsibles);
*/

    $params['company_id'] = Registry::get('runtime.company_id');

    list($order_status_logs, $search) = fn_get_order_status_logs($params, DESCR_SL);

     Tygh::$app['view']
        ->assign('order_status_logs', $order_status_logs)
        ->assign('search', $search);

    fn_print_r($order_status_logs, $search);
}
