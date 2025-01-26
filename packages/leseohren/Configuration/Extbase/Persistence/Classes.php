<?php

declare(strict_types=1);

return [
    // \SKom\Leseohren\Domain\Model\FileReference::class => [
    //     'tableName' => 'sys_file_reference',
    // ],
    // \SKom\Leseohren\Domain\Model\File::class => [
    //     'tableName' => 'sys_file',
    // ],
    \SKom\Leseohren\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
        'properties' => [
            'parentcategory' => [
                'fieldName' => 'parent',
            ],
        ],
    ],
];
