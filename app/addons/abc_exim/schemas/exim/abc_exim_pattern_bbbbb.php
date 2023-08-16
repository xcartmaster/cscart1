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
    'pattern_id' => 'abc_exim_pattern_bbbbb',
    'name' => __('abc_exim.tab_bbbbb'),
    'key' => array('bbbbb_id'),
    'order' => 2,
    'table' => 'abc_exim_bbbbb',
    'export_fields' => array(
        'BBBBB ID' => array(
            'db_field' => 'bbbbb_id',
            'alt_key' => true,
            'required' => true,
        ),
        'BBBBB' => array(
            'db_field' => 'bbbbb',
            'required' => true,
        ),
    ),
);

return $schema;