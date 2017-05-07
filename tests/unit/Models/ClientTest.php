<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Client;

class ClientTest extends TestCase
{
    /**
     * Test accessor for get_attention if 'use_attn' is true
     */
    public function testGetAttentionAttributeWithUseAttentionIsTrue()
    {
        $client = new Client();
        $client->fill([
            'first_name' => 'Snuffy',
            'last_name' => 'Smith',
            'use_attn' => 1
        ]);
        $this->assertEquals('Attn: Snuffy Smith',$client->getAttentionAttribute());
    }

    /**
     * Test accessor for get_attention if 'use_attn' is false
     */
    public function testGetAttentionAttributeWithUseAttentionIsFalse()
    {
        $client = new Client();
        $client->fill([
            'first_name' => 'Snuffy',
            'last_name' => 'Smith',
            'use_attn' => 0
        ]);
        $this->assertEquals('',$client->getAttentionAttribute());
    }

    /**
     * Test accessor for get_attention if 'use_care_of' is true
     */
    public function testGetAttentionAttributeWithUseCareOfIsTrue()
    {
        $client = new Client();
        $client->fill([
            'first_name' => 'Snuffy',
            'last_name' => 'Smith',
            'use_care_of' => 1
        ]);
        $this->assertEquals('Care of: Snuffy Smith',$client->getAttentionAttribute());
    }

    /**
     * Test accessor for get_attention if 'use_care_of' is false
     */
    public function testGetAttentionAttributeWithUseCareOfIsFalse()
    {
        $client = new Client();
        $client->fill([
            'first_name' => 'Snuffy',
            'last_name' => 'Smith',
            'use_care_of' => 0
        ]);
        $this->assertEquals('',$client->getAttentionAttribute());
    }

}
