<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Client;

class ClientTest extends TestCase
{
    /**
     * @dataProvider getAttentionAttributeDataProvider
     *
     * Test accessor for get_attention under conditions specified in getAttentionAttributeDataProvider()
     */
    public function testGetAttentionAttributeFormatsCorrectly($clientValues, $expectedResult)
    {
        var_dump($clientValues);
        $client = new Client();
        $client->fill($clientValues);
        $this->assertEquals($expectedResult, $client->getAttentionAttribute());
    }

    public function getAttentionAttributeDataProvider()
    {
        return [
            [
                [
                    'first_name' => 'Snuffy',
                    'last_name' => 'Smith',
                    'use_attn' => 1
                ],
                'Attn: Snuffy Smith'
            ],
            [
                [
                    'first_name' => 'Snuffy',
                    'last_name' => 'Smith',
                    'use_attn' => 0
                ],
                ''
            ],
            [
                [
                    'first_name' => 'Snuffy',
                    'last_name' => 'Smith',
                    'use_care_of' => 1
                ],
                'Care of: Snuffy Smith'
            ],
            [
                [
                    'first_name' => 'Snuffy',
                    'last_name' => 'Smith',
                    'use_care_of' => 0
                ],
                ''
            ],
        ];
    }

}
