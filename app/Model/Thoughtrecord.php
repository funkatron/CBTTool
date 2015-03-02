<?php
namespace CBTTool\Model;

use Aura\SqlQuery\QueryFactory;
use Aura\Sql\ExtendedPdo;
use CBTTool\Lib\DBAL;
use CBTTool\Lib\Config;

/**
 * this is really a Database abstraction layer, not a "model" per se.
 */
class Thoughtrecord extends DBAL
{
    public $DB_TYPE = 'sqlite';
    public $DB_TABLE = 'thought_record';

    /**
     * returns a single record by ID
     * @param  int   $id
     * @return array
     */
    public function getById($id)
    {
        $select = $this->makeQueryFactory()->newSelect();
        $select->from($this->DB_TABLE)
            ->cols(array(
                'thought_record.id as id',
                'id_hash',
                'event',
                'thoughts',
                'feelings',
                'behaviors',
                'thoughts_accurate',
                'thoughts_helpful',
                'thinking_mistake_id',
                'thinking_mistake.label as thinking_mistake',
                'say_to_self',
                'how_feel',
            ))
            ->join(
                'LEFT',
                'thinking_mistake',
                'thinking_mistake.id = thinking_mistake_id'
            )
            ->where('thought_record.id = :id')
            ->bindValue('id', $id);
        $sth = $this->sendQuery($select);
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }



    public function save(array $record_data)
    {
        $insert = $this->makeQueryFactory()->newInsert();
        $insert->into($this->DB_TABLE)
            ->cols(array(
                'id_hash' => $this->generateIdHash(),
                'event' => $record_data['event'],
                'thoughts' => $record_data['thoughts'],
                'feelings' => $record_data['feelings'],
                'behaviors' => $record_data['behaviors'],
                'thoughts_accurate' => $record_data['thoughts_accurate'],
                'thoughts_helpful' => $record_data['thoughts_helpful'],
                'thinking_mistake_id' => $record_data['thinking_mistake_id'],
                'say_to_self' => $record_data['say_to_self'],
                'how_feel' => $record_data['how_feel'],
            ))
            ->set('date_created', 'datetime(\'now\')');

        $sth = $this->sendQuery($insert);

        // get the last insert ID
        $name = $insert->getLastInsertIdName('id');
        $id = $this->extendedPdo->lastInsertId($name);

        return $id;

    }

    /**
     * generates a unique hash to use with Thoughrecords
     * @return string
     */
    public function generateIdHash()
    {
        return hash('md5', uniqid());
    }
}
