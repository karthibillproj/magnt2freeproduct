<?php 

namespace Sapient\Freeproduct\Model\Rule\Metadata;
use Magento\SalesRule\Model\Rule;

class ValueProvider extends \Magento\SalesRule\Model\Rule\Metadata\ValueProvider
{ 
    public function getMetadataValues(\Magento\SalesRule\Model\Rule $rule)
    {
        $customerGroups = $this->groupRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $applyOptions = [
            ['label' => __('Percent of product price discount'), 'value' =>  Rule::BY_PERCENT_ACTION],
            ['label' => __('Fixed amount discount'), 'value' => Rule::BY_FIXED_ACTION],
            ['label' => __('Fixed amount discount for whole cart'), 'value' => Rule::CART_FIXED_ACTION],
            ['label' => __('Buy X get Y free (discount amount is Y)'), 'value' => Rule::BUY_X_GET_Y_ACTION],
            ['label' => __('Free products'), 'value' => 'freeproducts']
        ];

        $couponTypesOptions = [];
        $couponTypes = $this->salesRuleFactory->create()->getCouponTypes();
        foreach ($couponTypes as $key => $couponType) {
            $couponTypesOptions[] = [
                'label' => $couponType,
                'value' => $key,
            ];
        }

        $labels = $rule->getStoreLabels();

        return [
            'rule_information' => [
                'children' => [
                    'website_ids' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->store->getWebsiteValuesForForm(),
                                ],
                            ],
                        ],
                    ],
                    'is_active' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => [
                                        ['label' => __('Active'), 'value' => '1'],
                                        ['label' => __('Inactive'), 'value' => '0']
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'customer_group_ids' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->objectConverter->toOptionArray($customerGroups, 'id', 'code'),
                                ],
                            ],
                        ],
                    ],
                    'coupon_type' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $couponTypesOptions,
                                ],
                            ],
                        ],
                    ],
                    'is_rss' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => [
                                        ['label' => __('Yes'), 'value' => '1'],
                                        ['label' => __('No'), 'value' => '0']
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
            ],
            'actions' => [
                'children' => [
                    'simple_action' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $applyOptions
                                ],
                            ]
                        ]
                    ],
                    'discount_amount' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'value' => '0',
                                ],
                            ],
                        ],
                    ],
                     'free_products' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'value' => '0',
                                ],
                            ],
                        ],
                    ],
                    'discount_qty' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'value' => '0',
                                ],
                            ],
                        ],
                    ],
                    'apply_to_shipping' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => [
                                        ['label' => __('Yes'), 'value' => '1'],
                                        ['label' => __('No'), 'value' => '0']
                                    ]
                                ],
                            ],
                        ],
                    ],
                    'stop_rules_processing' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => [
                                        ['label' => __('Yes'), 'value' => '1'],
                                        ['label' => __('No'), 'value' => '0'],
                                    ],
                                ],
                            ]
                        ]
                    ],
                ]
            ],
            'labels' => [
                'children' => [
                    'store_labels[0]' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'value' => isset($labels[0]) ? $labels[0] : '',
                                ],
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }    
}