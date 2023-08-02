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

use Tygh\Enum\ReceiverSearchMethods;
use Tygh\Enum\UserTypes;
use Tygh\Enum\YesNo;
use Tygh\Notifications\Receivers\SearchCondition;
use Tygh\Registry;
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

function fn_get_order_status_logs($params = array(), $lang_code = CART_LANGUAGE)
{
    // Init filter
    $params = LastView::instance()->update('order_status_logs', $params);

    $params = array_merge(array(
        'items_per_page' => 0,
        'page' => 1,
    ), $params);

    $fields = array(
        'r.*',
        'o.firstname as order_firstname',
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

/*
    if (isset($params['firstname']) && fn_string_not_empty($params['firstname'])) {
        $params['firstname'] = trim($params['firstname']);
        $condition[] = db_quote("u.firstname LIKE ?l", '%' . $params['firstname'] . '%');
    }
*/
    if (!empty($params['status_old'])) {
        $condition[] = db_quote("r.status_old = ?s", $params['status_old']);
    }

    if (!empty($params['status_new'])) {
        $condition[] = db_quote("r.status_new = ?s", $params['status_new']);
    }

/*
    if (!empty($params['company_id'])) {
        $condition[] = db_quote("r.company_id = ?i", $params['company_id']);
    }
*/

    if (!empty($params['user_id'])) {
        $condition[] = db_quote("r.user_id = ?s", $params['user_id']);
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

    LastView::instance()->processResults('order_status_logs', $items, $params);

    return [$items, $params];
}