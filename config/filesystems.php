<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'urgs' => [
            'driver' => 'local',
            'root' => storage_path('app/public/urgs'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'anexos_contrato' => [
            'driver' => 'local',
            'root' => storage_path('app/public/anexos_contrato'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'img_expedientes' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img-expedientes'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'cat_producto' => [
            'driver' => 'local',
            'root' => storage_path('app/public/cat-producto'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'grupo_revisor' => [
            'driver' => 'local',
            'root' => storage_path('app/public/grupo-revisor'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'img_contrato' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img-contrato'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'contrato_adhesion' => [
            'driver' => 'local',
            'root' => storage_path('app/public/contrato-adhesion'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'precio_maximo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/precio-maximo'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'img_producto_pfp' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img-producto-pfp'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'ficha_tec_pfp' => [
            'driver' => 'local',
            'root' => storage_path('app/public/ficha-tec-pfp'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'otros_doc_pfp' => [
            'driver' => 'local',
            'root' => storage_path('app/public/otros-doc-pfp'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'validacion_tec_pfp' => [
            'driver' => 'local',
            'root' => storage_path('app/public/validacion-tec-pfp'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'prorroga_solicitud' => [
            'driver' => 'local',
            'root' => storage_path('app/public/proveedor/orden_compra/envios/prorroga_solicitud'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'docs' => [
            'driver' => 'local',
            'root' => storage_path('app/docs'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'contrato_pedido' => [
            'driver' => 'local',
            'root' => storage_path('app/public/contrato-pedido'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'contrato_archivo_bancario' => [
            'driver' => 'local',
            'root' => storage_path('app/public/contrato-archivo-bancario'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'acuse_prorroga' => [
            'driver' => 'local',
            'root' => storage_path('app/public/acuse-prorroga'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'acuse_sustitucion' => [
            'driver' => 'local',
            'root' => storage_path('app/public/acuse-sustitucion'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'comprobante_clc' => [
            'driver' => 'local',
            'root' => storage_path('app/public/comprobante-clc'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'img_mensaje' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img-mensaje'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
