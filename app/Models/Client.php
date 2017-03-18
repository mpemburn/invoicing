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

    public function getAttentionAttribute($value)
    {
        $attn = ($this->use_attn) ? 'Attn: ' : '';
        $care_of = ($this->use_care_of) ? 'Care of: ' : '';
        $attn_line = ($this->use_attn || $this->care_of) ? $attn . $care_of . $this->full_name : '';

        return (empty($attn_line)) ? '' : $attn_line;
    }

    public function getCityStateZipAttribute($value)
    {
        return $this->city . ', ' . $this->state . ' ' . $this->zip_code;
    }

    public function getFullNameAttribute($value)
    {
        $middle = (empty($this->middle_name)) ? '' : $this->middle_name . ' ';
        return $this->first_name . ' ' . $middle . $this->last_name;
    }

    public function getTopLineAttribute($value)
    {
        return (empty($this->company)) ? $this->full_name : $this->company;
    }

    public function getZipCodeAttribute($value)
    {
        return preg_replace('/(.{5})(.{4})/', '\1-\2', $this->zip);
    }
}