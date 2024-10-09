<?php

namespace Database\Seeders\Tenant;

use App\Models\CollectionMethodType;
use Illuminate\Database\Seeder;
use App\Enums\CollectionMethodFieldTypeEnum;

class CollectionMethodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $list = [
            [
                'name' => '测试',
                'payment_type_ids' => [1, 2, 3],
                'data' => [
                    'fields' => [
                        [
                            'name' => 'collection_method_phone_number',
                            'type' => CollectionMethodFieldTypeEnum::STRING->value,
                            'rules' => [
                                'laravel' => [
                                    'store' => [
                                        'required',
                                        'string',
                                    ],
                                    'update' => [
                                        'filled',
                                        'string',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => 'collection_method_name',
                            'type' => CollectionMethodFieldTypeEnum::STRING->value,
                            'rules' => [
                                'laravel' => [
                                    'store' => [
                                        'required',
                                        'string',
                                    ],
                                    'update' => [
                                        'filled',
                                        'string',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => 'context',
                            'type' => CollectionMethodFieldTypeEnum::QR_FILE->value,
                            'rules' => [
                                'laravel' => [
                                    'store' => [
                                        'required',
                                    ],
                                    'update' => [
                                        'filled',
                                    ],
                                ],
                            ],
                        ]
                    ],
                ],
            ]
        ];

        foreach ($list as $item) {
            CollectionMethodType::create($item);
        }
    }
}
