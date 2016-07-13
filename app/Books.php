<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

// instance of Books class will refer to posts table in database
class Books extends Model {

	//restricts columns from modifying
	protected $guarded = [];

}
