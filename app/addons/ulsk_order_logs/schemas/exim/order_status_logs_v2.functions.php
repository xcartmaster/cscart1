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

function fn_ulsk_order_logs_skip_get_primary_object_id(&$skip_get_primary_object_id)
{
    $skip_get_primary_object_id = true;
}

function fn_ulsk_order_logs_insert_log($object)
{
    $data = array(
        'order_id' => $object['order_id'],
        'user_id' => $object['user_id'],
        'timestamp' => $object['timestamp'],
        'status_old' => $object['status_old'],
        'status_new' => $object['status_new'],
    );

    db_query('INSERT INTO ?:order_status_logs ?e', $data);
}

function fn_ulsk_order_logs_update_log($object)
{
    $data = array(
        'order_id' => $object['order_id'],
        'user_id' => $object['user_id'],
        'timestamp' => $object['timestamp'],
        'status_old' => $object['status_old'],
        'status_new' => $object['status_new'],
    );

    db_query('UPDATE ?:order_status_logs SET ?u WHERE log_id = ?i', $data, $object['log_id']);
}

function fn_ulsk_order_logs_insert_or_update_entity(&$object, &$processed_data)
{
    if (!isset($object['timestamp'])){
        $object['timestamp'] = TIME;
    }

    if (isset($object['log_id'])){
        fn_ulsk_order_logs_update_log($object);
        $processed_data['E']++;
    } else {
        fn_ulsk_order_logs_insert_log($object);
        $processed_data['N']++;
    }
}