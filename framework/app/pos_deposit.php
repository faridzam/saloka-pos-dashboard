<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class pos_deposit extends Model
{
    //
    protected $fillable = [
        'admin',
        'id_store',
        'pec100',
        'pec50',
        'pec20',
        'pec10',
        'pec5',
        'pec2',
        'pec1',
        'nominal',
    ];

    public function save(array $options = array())
    {
    	if( ! $this->admin)
        {
            $this->admin = Auth::user()->id;
        }
    	parent::save($options);
    }
}
