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

function fn_ulsk_order_logs_import_date_to_timestamp($date = '')
{
    $date = !empty($date) ? $date : date("H:i:s");

    return strtotime($date);
}

function fn_ulsk_order_logs_export_timestamp_to_date($timestamp = '')
{
    return date("Y-m-d H:i:s", $timestamp);
}

function fn_ulsk_order_logs_export_status($status, $selectable_statuses)
{
    if (!empty($selectable_statuses[$status])) {
        return $selectable_statuses[$status];
    } else {
        return $status;
    }
}

function fn_ulsk_order_logs_export_user ($data)
{
    if (!empty($data['User ID'])){
        $user_data = db_get_row("SELECT firstname, lastname FROM ?:users WHERE user_id = ?i", $data['User ID']);
    }
    elseif (!empty($data['Order ID'])) {
        $user_data = db_get_row("SELECT firstname, lastname FROM ?:orders WHERE order_id = ?i", $data['Order ID']);
    }

    if (isset($user_data)){
        $user_fullname = trim(implode(' ', $user_data));
    }
    else {
        $user_fullname = "Anonymous admin";
    }

    return $user_fullname;
}