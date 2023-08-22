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

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'delete_order_log' && defined('AJAX_REQUEST')) {
        if (!empty($_REQUEST['log_id']) && !empty($_REQUEST['order_id'])) {
            fn_delete_order_status_log($_REQUEST['log_id']);

            $params = array(
                'order_id' => $_REQUEST['order_id'],
                'sort_order' => 'asc',
                'sort_by' => 'date'
            );

            $order_status_logs = fn_get_order_status_logs($params, DESCR_SL, false);
            $order_statuses = fn_get_statuses(STATUSES_ORDER);

            Tygh::$app['view']->assign('order_status_logs', $order_status_logs);
            Tygh::$app['view']->assign('order_statuses', $order_statuses);
            Tygh::$app['view']->display('addons/ulsk_order_logs/views/orders/components/order_status_logs.tpl');
            exit;
        }
    }
}

if ($mode == 'details') {

    $params = array(
        'order_id' => $_REQUEST['order_id'],
        'sort_order' => 'asc',
        'sort_by' => 'date'
    );

    $order_status_logs = fn_get_order_status_logs($params, DESCR_SL, false);
    $order_statuses = fn_get_statuses(STATUSES_ORDER);

    Tygh::$app['view']->assign('order_status_logs', $order_status_logs);
    Tygh::$app['view']->assign('order_statuses', $order_statuses);
    Registry::set('navigation.tabs.ulsk_order_logs_tab', array(
        'title' => __('ulsk_order_logs.order_status_logs'),
        'js' => true
    ));
}
