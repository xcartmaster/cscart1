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

$schema['top']['administration']['items']['export_data']['subitems']['abc_exim_menu'] = array(
    'attrs' => [
        'class' => 'is-addon'
    ],
    'href' => 'exim.export?section=abc_exim_common_section',
    'position' => 10
);

$schema['top']['administration']['items']['import_data']['subitems']['abc_exim_menu'] = array(
    'attrs' => [
        'class' => 'is-addon'
    ],
    'href' => 'exim.import?section=abc_exim_common_section',
    'position' => 10
);

return $schema;
