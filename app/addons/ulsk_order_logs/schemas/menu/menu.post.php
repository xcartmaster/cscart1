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

defined('BOOTSTRAP') or die('Access denied');

$schema['central']['orders']['items']['order_status_logs'] = [
    'attrs' => array(
        'class' => 'is-addon'
    ),
    'href' => 'order_status_logs.manage',
    'position' => 1100,
];

$schema['top']['administration']['items']['export_data']['subitems']['order_status_logs'] = array(
    'href' => 'exim.export?section=order_status_logs_section',
    'position' => 401
);

$schema['top']['administration']['items']['import_data']['subitems']['order_status_logs'] = array(
    'href' => 'exim.import?section=order_status_logs_section',
    'position' => 401
);

return $schema;
