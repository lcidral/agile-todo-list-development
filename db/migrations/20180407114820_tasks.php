<?php


use Phinx\Migration\AbstractMigration;

class Tasks extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $session_table = $this->table('tasks');
        $session_table->addColumn('uuid', 'char', ['limit' => 36])
            ->addColumn('type', 'enum', ['values' => ['shopping', 'work']])
            ->addColumn('content', 'text')
            ->addColumn('sort_order', 'integer')
            ->addColumn('done', 'boolean', ['default' => false])
            ->addColumn('date_created', 'datetime')
            ->addIndex(['uuid'], ['unique' => true])
            ->create();

    }
}
