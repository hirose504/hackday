<?php

namespace Fuel\Migrations;

class Create_yamarecos
{
	public function up()
	{
		\DBUtil::create_table('yamarecos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 1024, 'type' => 'varchar'),
			'line' => array('type' => 'linestring'),
			'time' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('yamarecos');
	}
}