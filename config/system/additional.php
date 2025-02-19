<?php
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    [
        'DB' => [
            'Connections' => [
                'Default' => [
                    'dbname' => getenv('TYPO3__DB__Connections__Default__dbname'),
                    'host' => getenv('TYPO3__DB__Connections__Default__host'),
                    'password' => getenv('TYPO3__DB__Connections__Default__password'),
                    'port' => getenv('TYPO3__DB__Connections__Default__port'),
                    'user' => getenv('TYPO3__DB__Connections__Default__user'),
                    'driver' => 'mysqli',
                ],
            ],
        ],
        'GFX' => [
            'processor' => getenv('TYPO3_GFX_PROCESSOR'),
            'processor_path' => getenv('TYPO3_GFX_PROCESSOR_PATH'),
            'processor_path_lzw' => getenv('TYPO3_GFX_PROCESSOR_PATH_LZW'),
        ],
        'MAIL' => [
            'transport' => getenv('TYPO3_MAIL_TRANSPORT'),
            'transport_smtp_server' => getenv('TYPO3_MAIL_TRANSPORT_SMTP_SERVER'),
            'transport_smtp_username' => getenv('TYPO3_MAIL_TRANSPORT_SMTP_USERNAME'),
            'transport_smtp_password' => getenv('TYPO3_MAIL_TRANSPORT_SMTP_PASSWORD'),
            'defaultMailFromAddress' => getenv('TYPO3_MAIL_DEFAULTMAILFROMADDRESS'),
        ],
        'SYS' => [
            'trustedHostsPattern' => getenv('TYPO3_TRUSTED_HOST_PATTERN'),
            'devIPmask' => '*',
            'displayErrors' => getenv('TYPO3_DISPLAY_ERRORS'),
        ],
        'FE' => [
            'debug' => getenv('TYPO3_FE_DEBUG'),
        ],
        'BE' => [
            'debug' => getenv('TYPO3_BE_DEBUG'),
        ],
    ]
);
