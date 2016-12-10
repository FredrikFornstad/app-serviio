<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'serviio';
$app['version'] = '1.8';
$app['release'] = '1';
$app['vendor'] = 'Petr Nejedly';
$app['packager'] = 'Fredrik Fornstad';
$app['license'] = 'Custom commercial license: free to use with limitations. Please see LICENCE.txt in source file or http://www.serviio.org/licence';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('serviio_app_description');
$app['tooltip'] = lang('serviio_app_tooltip');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('serviio_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_file');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['serviio']['title'] = lang('serviio_app_name');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////


$app['core_requires'] = array(
    'serviio >= 1.8',
    'webconfig-php-mbstring >= 5.3.3',
    'app-base-core >= 1:1.2.6'
);

$app['core_obsoletes'] = array(
    'serviio-WebUI'
);

$app['core_file_manifest'] = array(
    'serviio.php' => array('target' => '/var/clearos/base/daemon/serviio.php'),
    'serviio.logrotate' => array(
        'target' => '/etc/logrotate.d/serviio',
        'mode' => '0644',
        'owner' => 'root',
        'group' => 'root',
        'config' => TRUE,),
);

$app['delete_dependency'] = array(
    'app-serviio-core',
    'serviio'
);
