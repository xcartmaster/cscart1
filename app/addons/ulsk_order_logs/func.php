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

if (!defined('BOOTSTRAP')) { die('Access denied'); }

//use Tygh\Enum\ReceiverSearchMethods;
//use Tygh\Enum\UserTypes;
//use Tygh\Enum\YesNo;
//use Tygh\Notifications\Receivers\SearchCondition;
//use Tygh\Registry;
use Tygh\Navigation\LastView;

function fn_ulsk_order_logs_change_order_status_post($order_id, $status_to, $status_from, $force_notification, $place_order, $order_info, $edp_data)
{

    $data = array(
        'order_id' => $order_id,
        'user_id' => Tygh::$app['session']['auth']['user_id'],
        'timestamp' => TIME,
        'status_old' => $status_from,
        'status_new' => $status_to,
    );

    db_query('INSERT INTO ?:order_status_logs ?e', $data);
}

function fn_delete_order_status_log($log_id)
{
    return db_query("DELETE FROM ?:order_status_logs WHERE log_id = ?i", $log_id);
}

function fn_get_status_logs_for_order($order_id){
    $logs = db_get_array("SELECT logs.*, users.firstname, users.lastname FROM ?:order_logs as logs "
        . " LEFT JOIN ?:users as users USING(user_id) WHERE logs.order_id = ?i ORDER BY logs.log_id ASC", $order_id
    );

    return $logs;
}

function fn_get_order_status_logs($params = array(), $lang_code = CART_LANGUAGE, $save_search = true)
{
    if ($save_search) {
        // Init filter
        // manage.tpl -> {include file="common/saved_search.tpl" dispatch="order_status_logs.manage" view_type="order_status_logs_object"}
        $params = LastView::instance()->update('order_status_logs_object', $params);
    }

    $params = array_merge(array(
        'items_per_page' => 0,
        'page' => 1,
    ), $params);

    $fields = array(
        'r.*',
        'o.status',
        'o.firstname as order_firstname',
        'o.lastname as order_lastname',
        'u.firstname as user_firstname',
        'u.lastname as user_lastname',
    );

    $joins = array(
        db_quote("LEFT JOIN ?:users AS u ON u.user_id = r.user_id"),
        db_quote("LEFT JOIN ?:orders o USING(order_id)"),
    );

    $sortings = array (
        'id' => 'r.log_id',
        'date' => 'r.timestamp',
        'status' => 'o.status',
        'status_old' => 'r.status_old',
        'status_new' => 'r.status_new',
        'user_id' => 'r.user_id',
        'user' => array('u.lastname', 'u.firstname'),
        'order' => 'r.order_id',
     );

    $condition = array();

    if (isset($params['id']) && fn_string_not_empty($params['id'])) {
        $params['id'] = trim($params['id']);
        $condition[] = db_quote("r.log_id = ?i", $params['id']);
    }

    if (isset($params['order_id']) && fn_string_not_empty($params['order_id'])) {
        $params['order_id'] = trim($params['order_id']);
        $condition[] = db_quote("r.order_id = ?i", $params['order_id']);
    }

    if (isset($params['firstname']) && fn_string_not_empty($params['firstname'])) {
        $params['firstname'] = trim($params['firstname']);
        $condition[] = db_quote("u.firstname LIKE ?l", '%' . $params['firstname'] . '%');
    }

    if (isset($params['lastname']) && fn_string_not_empty($params['lastname'])) {
        $params['lastname'] = trim($params['lastname']);
        $condition[] = db_quote("u.lastname LIKE ?l", '%' . $params['lastname'] . '%');
    }

    if (isset($params['order_firstname']) && fn_string_not_empty($params['order_firstname'])) {
        $params['order_firstname'] = trim($params['order_firstname']);
        $condition[] = db_quote("o.firstname LIKE ?l", '%' . $params['order_firstname'] . '%');
    }

    if (isset($params['order_lastname']) && fn_string_not_empty($params['order_lastname'])) {
        $params['order_lastname'] = trim($params['order_lastname']);
        $condition[] = db_quote("o.lastname LIKE ?l", '%' . $params['order_lastname'] . '%');
    }

    if (!empty($params['status'])) {
        $condition[] = db_quote("o.status = ?s", $params['status']);
    }

    if (!empty($params['status_old'])) {
        $condition[] = db_quote("r.status_old = ?s", $params['status_old']);
    }

    if (!empty($params['status_new'])) {
        $condition[] = db_quote("r.status_new = ?s", $params['status_new']);
    }

    if (!empty($params['period']) && $params['period'] != 'A') {
        list($params['time_from'], $params['time_to']) = fn_create_periods($params);

        $condition[] = db_quote("(r.timestamp >= ?i AND r.timestamp <= ?i)", $params['time_from'], $params['time_to']);
    }

    $fields_str = implode(', ', $fields);
    $joins_str = ' ' . implode(' ', $joins);
    $condition_str = $condition ? (' WHERE ' . implode(' AND ', $condition)) : '';
    $sorting_str = db_sort($params, $sortings, 'date', 'desc');

    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field(
            "SELECT COUNT(r.log_id) FROM ?:order_status_logs r" . $joins_str . $condition_str
        );
        $limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
    }

    $items = db_get_array(
        "SELECT " . $fields_str
        . " FROM ?:order_status_logs r"
        . $joins_str
        . $condition_str
        . $sorting_str
        . $limit
    );

    if ($save_search) {
        LastView::instance()->processResults('order_status_logs', $items, $params); // fn_get_$func = fn_get_order_status_logs

        return [$items, $params];
    } else {
        return $items;
    }
}