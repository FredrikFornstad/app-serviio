<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'serviio';
$app['version'] = '1.5';
$app['release'] = '1';
$app['vendor'] = 'Petr Nejedly';
$app['packager'] = 'Fredrik Fornstad';
$app['license'] = 'Free to use with limitations. Please see LICENCE.txt in source file or http://www.serviio.org/licence';
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
    'serviio >= 1.5',
    'serviio-WebUI >= 1.6.3',
    'webconfig-php-mbstring >= 5.3.3',
    'app-base-core >= 1:1.2.6'
);

$app['core_file_manifest'] = array(
    'serviio.php' => array('target' => '/var/clearos/base/daemon/serviio.php'),
    'Serviio.conf' => array(
        'target' => '/usr/clearos/sandbox/etc/httpd/conf.d/Serviio.conf',
        'mode' => '0644',
        'config' => TRUE,
        'config_params' => 'noreplace',
    ),
);

$app['delete_dependency'] = array(
    'app-serviio-core',
    'serviio-WebUI',
    'serviio'
);
