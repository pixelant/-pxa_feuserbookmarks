<?php
defined('TYPO3_MODE') || die('Access denied.');

return [
    'ctrl' => [
        'title' => 'LLL:EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_db.xlf:tx_pxafeuserbookmarks_domain_model_bookmark',
        'label' => 'feuserid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',

        'delete' => 'deleted',
        'searchFields' => 'feuserid,pageid,params,special_identificator',

        'rootLevel' => 1,
        'hideTable' => true
    ],
    'interface' => [
        'showRecordFieldList' => 'feuserid, pageid, special_identificator, params',
    ],
    'types' => [
        '1' => ['showitem' => 'feuserid, pageid, special_identificator, params'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'feuserid' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_db.xlf:tx_pxafeuserbookmarks_domain_model_bookmark.feuserid',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required'
            ],
        ],
        'pageid' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_db.xlf:tx_pxafeuserbookmarks_domain_model_bookmark.pageid',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required'
            ],
        ],
        'special_identificator' => [
            'exclude' => 0,
            'label' => 'special_identificator',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ],
        ],
        'params' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_db.xlf:tx_pxafeuserbookmarks_domain_model_bookmark.params',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
        ],
    ],
];
