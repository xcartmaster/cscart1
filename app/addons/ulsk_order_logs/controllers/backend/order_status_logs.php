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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode === 'delete') {
        if ($_REQUEST['log_id']) {
            fn_delete_order_status_log($_REQUEST['log_id']);
        }
    }

    if ($mode === 'm_delete') {
        if (!empty($_REQUEST['logs_post_data'])) {
            foreach (array_keys($_REQUEST['logs_post_data']) as $log_id) {
                fn_delete_order_status_log($log_id);
            }
        }
    }

    if (
        $mode === 'm_update_statuses'
        && !empty($_REQUEST['logs_post_data'])
        && !empty($_REQUEST['status'])
    ) {
        foreach ($_REQUEST['logs_post_data'] as $data) {
            fn_change_order_status($data['order_id'], $_REQUEST['status'], '', fn_get_notification_rules([], true));
        }
    }

    return [CONTROLLER_STATUS_OK, 'order_status_logs.manage'];
}

if ($mode === 'manage') {
    $params = array_merge(
        ['items_per_page' => Registry::get('settings.Appearance.admin_elements_per_page')],
        $_REQUEST
    );

    list($order_status_logs, $search) = fn_get_order_status_logs($params, DESCR_SL);

    $order_statuses = fn_get_statuses(STATUSES_ORDER);

    Tygh::$app['view']
        ->assign('order_status_logs', $order_status_logs)
        ->assign('order_statuses', $order_statuses)
        ->assign('selectable_statuses', fn_get_simple_statuses(STATUSES_ORDER, true, true))
        ->assign('search', $search);

 // fn_print_r($order_status_logs, $search, $order_statuses);
}
