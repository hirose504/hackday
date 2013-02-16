<?php
use Orm\Model;

class Model_Point extends Model
{
	protected static $_properties = array(
		'id',
		'line_id',
		'point',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('line_id', 'Line Id', 'required|valid_string[numeric]');
		$val->add_field('point', 'Point', 'required');

		return $val;
	}

}
