<?php

namespace Fuel\Migrations;

class Create_points
{
	public function up()
	{
		\DBUtil::create_table('points', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'line_id' => array('constraint' => 11, 'type' => 'int'),
			'point' => array('type' => 'point'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('points');
	}
}