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

}