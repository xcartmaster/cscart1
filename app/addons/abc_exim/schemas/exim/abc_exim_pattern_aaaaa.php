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

$schema = array(
    'section' => 'abc_exim_common_section',
    'pattern_id' => 'abc_exim_pattern_aaaaa',
    'name' => __('abc_exim.tab_aaaaa'),
    'key' => array('aaaaa_id'),
    'order' => 1,
    'table' => 'abc_exim_aaaaa',
    'export_fields' => array(
        'AAAAA ID' => array(
            'db_field' => 'aaaaa_id',
            'alt_key' => true,
            'required' => true,
        ),
        'AAAAA' => array(
            'db_field' => 'aaaaa',
            'required' => true,
        ),
    ),
);

return $schema;
