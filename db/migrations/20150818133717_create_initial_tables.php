<?php

use Phinx\Migration\AbstractMigration;

class CreateInitialTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function change()
    {
        $table = $this->table('site_instances');
        $table->addColumn('adapter', 'string')
              ->addColumn('endpoint', 'string')
              ->addColumn('last_retrieved', 'datetime', array('null' => true))
              ->addColumn('update_interval', 'integer', ['default' => 168])
              ->save();

        $table = $this->table('data');
        $table->addColumn('site_instance_id', 'integer')
              ->addColumn('key', 'string')
              ->addColumn('value', 'string')
              ->addColumn('timestamp', 'datetime')
              ->save();
    }
}
