<?php

namespace Database\Seeders\Tenant;

use App\Models\CollectionMethodType;
use Illuminate\Database\Seeder;

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
                            'type' => 'string',
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
                            'type' => 'string',
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
