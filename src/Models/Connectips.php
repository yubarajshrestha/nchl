<?php
namespace YubarajShrestha\NCHL\Models;

use Illuminate\Database\Eloquent\Model;

class Connectips extends Model {

    protected $table = 'connectips';

    protected $fillable = ['txn_id', 'details', 'status'];

    protected $casts = [
        'details' => 'json'
    ];

}