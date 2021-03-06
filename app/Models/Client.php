<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

/**
 * Class Client
 */
class Client extends Model
{
    protected $table = 'clients';

    public $timestamps = false;

    protected $fillable = [
        'category',
        'last_name',
        'middle_name',
        'first_name',
        'attn',
        'title',
        'suffix',
        'company',
        'primary_phone',
        'work_phone',
        'home_phone',
        'mobile_phone',
        'other_phone',
        'fax_phone',
        'email_address',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip',
        'billing_rate',
        'use_contact_name',
        'use_care_of',
        'use_attn',
        'use_attn_as_second_name',
        'include_in_merge',
        'referral_id',
        'referral_detail',
        'soundex',
        'notes'
    ];

    protected $guarded = [];

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    /* Static methods *************************************/

    public static function getFullAddressInfo($client_id)
    {
        $client = Client::find($client_id);

        $full_address = [
            'top_line' => $client->top_line,
            'address_1' => $client->address_1,
            'address_2' => $client->address_2,
            'city_state_zip' => $client->city_state_zip,
            'attention' => $client->attention,
        ];
        return $full_address;
    }


    /* Client Accessors *************************************/

    public function getAttentionAttribute()
    {
        $attn = ($this->use_attn) ? 'Attn: ' : '';
        $care_of = ($this->use_care_of) ? 'Care of: ' : '';
        $attn_line = ($this->use_attn || $this->use_care_of) ? $attn . $care_of . $this->full_name : '';

        return (empty($attn_line)) ? '' : $attn_line;
    }

    public function getCityStateZipAttribute($value)
    {
        $comma = (!empty($this->city) && !empty($this->state)) ? ', ' : '';
        return $this->city . $comma . $this->state . ' ' . $this->zip_code;
    }

    public function getFullNameAttribute($value)
    {
        $middle = (empty($this->middle_name)) ? '' : $this->middle_name . ' ';
        return trim($this->first_name . ' ' . $middle . $this->last_name);
    }

    public function getTopLineAttribute($value)
    {
        return (empty($this->company)) ? $this->full_name : $this->company;
    }

    public function getZipCodeAttribute($value)
    {
        return preg_replace('/(.{5})(.{4})/', '\1-\2', $this->zip);
    }

    public function getFoo($text)
    {
        return strrev($text);
    }
}