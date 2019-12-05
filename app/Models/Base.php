<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
	public static $filterable = [];

	/**
	 * Search function of fields in the database.
	 *
	 * @param array fields for searches
	 *
	 * @return results data
	 */

    public static function search (array $data = array(), $q) {

		if (!empty($data['dataSearch'])) {
        	$fields = json_decode($data['dataSearch'], true);
        	$fields = array_filter($fields, 'strlen');
        	$fields = array_only($fields, static::$filterable);
	        foreach ($fields as $field => $value) {
	            if (isset($fields[$field])) {
	                $q->orWhere($field, 'LIKE', "%$fields[$field]%")->orderBy($data['sortField'], $data['sortOrder']);
	            }
	        }
    	}

        if ($data['paginate'] === "true") {
        	return $q->paginate($data['perPage']);
        } else {
        	return $q->get();
        }
	}

}
