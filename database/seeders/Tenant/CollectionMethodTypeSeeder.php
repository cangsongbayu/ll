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
                            'rule' => [
                                'laravel' => [
                                    'required',
                                    'string',
                                ],
                            ],
                        ],
                        [
                            'name' => 'collection_method_name',
                            'rule' => [
                                'required',
                                'string',
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
