<?php

use Phinx\Migration\AbstractMigration;

class RenameOrderColumn extends AbstractMigration
{    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->table('thinking_mistake')
                ->renameColumn('order', 'sort_order');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('thinking_mistake')
                ->renameColumn('sort_order', 'order');
    }
}