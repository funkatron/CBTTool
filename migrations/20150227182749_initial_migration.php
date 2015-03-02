<?php

use Phinx\Migration\AbstractMigration;

class InitialMigration extends AbstractMigration
{
    public function change()
    {
        $tm_table = $this->table('thinking_mistake');
        $tm_table->addColumn('value', 'string', array('limit' => 255))
            ->addColumn('label', 'text')
            ->addColumn('order', 'integer')
            ->addIndex(array('value'), array('unique' => true))
            ->create();

        $tr_table = $this->table('thought_record');
        $tr_table->addColumn('id_hash', 'string', array('limit' => 255))
            ->addColumn('event', 'text')
            ->addColumn('thoughts', 'text')
            ->addColumn('feelings', 'text')
            ->addColumn('behaviors', 'text')
            ->addColumn('thoughts_accurate', 'text')
            ->addColumn('thoughts_helpful', 'text')
            ->addColumn('thinking_mistake_id', 'integer')
            ->addColumn('say_to_self', 'text')
            ->addColumn('how_feel', 'text')
            ->addColumn('date_created', 'datetime')
            ->addIndex(array('id_hash'), array('unique' => true))
            ->create();

        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('no', 'Nope', 1)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('black-and-white', 'Black-and-white thinking', 2)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('unreal-ideal', 'Unreal ideal', 3)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('filtering-for-negative', 'Filtering (only seeing negative)', 4)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('personalizing', 'Personalizing: The self-blame game', 5)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('mind reading', 'Mind-reading', 6)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('catastrophizing', 'Catastrophizing', 7)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('over-generalizing', 'Over-generalizing (always/never)', 8)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('fact-vs-feeling', 'Fact versus feeling', 9)");
        $this->execute("insert into thinking_mistake('value', 'label', 'order') values ('labeling', 'Labeling (I'm stupid/ugly)', 10)");

    }
}