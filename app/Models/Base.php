<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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
	// llamada por wh? dejame quitarle el telefono a mi madre

	public static function search(array $data = array(), $q, $table)
	{

		if (!empty($data['dataSearch'])) {
			$fields = json_decode($data['dataSearch'], true);
			$fields = array_filter($fields, 'strlen');
			$fields = Arr::only($fields, static::$filterable);
			$q->where(function ($query) use ($fields, $data) {
				foreach ($fields as $field => $value) {
					if (isset($fields[$field])) {
						$query->orWhere($field, 'LIKE', "%$fields[$field]%")->orderBy($data['sortField'], $data['sortOrder']);
					}
				}
			});
			$q->where($table.'.status', 'y');
		}
		if ($data['paginate'] === "true") {
			return $q->paginate($data['perPage']);
		} else {
			return $q->get();
		}
	}
}
