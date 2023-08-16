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
include_once(Registry::get('config.dir.addons') . 'ulsk_order_logs/schemas/exim/order_status_logs_exim_pattern_v1.functions.php');

$selectable_statuses = fn_get_simple_statuses(STATUSES_ORDER, true, true);

return array(
    'section' => 'order_status_logs_section',
    'pattern_id' => 'order_status_logs_exim_pattern_v1',
    'name' => __('ulsk_order_logs.order_status_logs_v1'),
    'key' => array('log_id'),
    'order' => 1,
    'table' => 'order_status_logs',
    'permissions' => array(
        'import' => 'manage_order_status_logs',
        'export' => 'view_order_status_logs'
    ),
    'references' => array (
        'orders' => array (
            'reference_fields' => array('order_id' => '&order_id'),
            'join_type' => 'LEFT'
        ),
    ),
    'range_options' => array (
        'selector_url' => 'order_status_logs.manage',
        'object_name' => __('order_status_logs')
    ),
    'export_fields' => array (
        'Log ID' => array (
            'db_field' => 'log_id',
            'alt_key' => true,
            'required' => true
        ),
        'User ID' => array (
            'db_field' => 'user_id',
            'required' => true
        ),
        'Order ID' => array (
            'db_field' => 'order_id',
            'required' => true
        ),
        'Timestamp' => array (
            'db_field' => 'timestamp'
        ),
        'Timestamp date' => array (
            'db_field' => 'timestamp',
            'process_get' => ['fn_ulsk_order_logs_export_timestamp_to_date', '#this'],
            'convert_put' => array ('fn_ulsk_order_logs_import_date_to_timestamp', '#this')
        ),
        'Old status' => array (
            'db_field' => 'status_old',
            'required' => true
        ),
        'New status' => array (
            'db_field' => 'status_new',
            'required' => true
        ),
        'Order status' => array(
            'db_field' => 'status',
            'table' => 'orders',
            'export_only' => true
        ),
        'Order status description' => array(
            'process_get' => ['fn_ulsk_order_logs_export_status', '#this', $selectable_statuses],
            'db_field' => 'status',
            'table' => 'orders',
            'export_only' => true
        ),
        'Old order status description' => array(
            'process_get' => ['fn_ulsk_order_logs_export_status', '#this', $selectable_statuses],
            'db_field' => 'status_old',
            'export_only' => true
        ),
        'New order status description' => array(
            'process_get' => ['fn_ulsk_order_logs_export_status', '#this', $selectable_statuses],
            'db_field' => 'status_new',
            'export_only' => true
        ),
        'User description' => array (
            'db_field' => 'user_id',
            'process_get' => ['fn_ulsk_order_logs_export_user', '#row'],
            'export_only' => true
        )
    )
);
