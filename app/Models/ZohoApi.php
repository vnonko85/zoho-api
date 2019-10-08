<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZohoApi extends Model
{
	/**
	 * @var string
	 */
	public $table = 'zoho_api';

	/**
	 * @var array
	 */
    public $fillable = ['access_token', 'refresh_token', 'expires'];
}
