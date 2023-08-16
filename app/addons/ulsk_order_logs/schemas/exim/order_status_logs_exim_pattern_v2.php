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
include_once(Registry::get('config.dir.addons') . 'ulsk_order_logs/schemas/exim/order_status_logs_exim_pattern_v2.functions.php');

$selectable_statuses = fn_get_simple_statuses(STATUSES_ORDER, true, true);

return array(
    'section' => 'order_status_logs_section',
    'pattern_id' => 'order_status_logs_exim_pattern_v2',
    'name' => __('ulsk_order_logs.order_status_logs_v2'),
    'key' => array('log_id'),
    'order' => 2,
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

    'import_skip_db_processing'    => true, // !!! Признак того, что при импорте не нужно ничего писать в БД
    'import_get_primary_object_id' => [
        'skip_get_primary_object_id' => [
            'function'    => 'fn_ulsk_order_logs_skip_get_primary_object_id',
            'args'        => ['$skip_get_primary_object_id'],
            'import_only' => true,
        ],
    ],
    'import_after_process_data' => [
        'create_or_update_entity' => [
            'function'    => 'fn_ulsk_order_logs_insert_or_update_entity',
            'args'        => ['$object', '$processed_data'],
        ],
    ],

    'export_fields' => array (
        'Log ID' => array (
            'db_field' => 'log_id',
            'alt_key' => true
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
        )
    )
);
