<?php
namespace CBTTool\Model;

use Aura\SqlQuery\QueryFactory;
use Aura\Sql\ExtendedPdo;
use CBTTool\Lib\Config;

/**
 * this is really a Database abstraction layer, not a "model" per se.
 */
class Thoughtrecord
{
    public static $DB_TYPE = 'sqlite';
    public static $DB_TABLE = 'thought_record';

    /**
     * @var CBTTool\Lib\Config
     */
    public $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->extendedPdo = $this->makeExtendedPdo();
    }

    /**
     * @return Aura\SqlQuery\QueryFactory
     */
    public function makeQueryFactory()
    {
        return new QueryFactory(self::$DB_TYPE);
    }

    public function makeExtendedPdo()
    {
        return new ExtendedPdo($this->config->get('db.pdo.connect')); 
    }

    /**
     * [sendQuery description]
     * @param  Aura\SqlQuery\Common\Select|Aura\SqlQuery\Common\Insert|Aura\SqlQuery\Common\Update|Aura\SqlQuery\Common\Delete $query [description]
     * @return PDOStatement
     */
    public function sendQuery($query)
    {
        // prepare the statement
        $sth = $this->extendedPdo->prepare($query->__toString());

        // execute with bound values
        $sth->execute($query->getBindValues());

        return $sth;
    }

    /**
     * return an array of rows.
     * @param  integer $limit default 10
     * @param  integer $skip  default 0
     * @return array
     */
    public function getAll($limit = 10, $skip = 0)
    {
        $select = $this->makeQueryFactory()->newSelect();
    }

    /**
     * returns a single record by ID
     * @param  int   $id
     * @return array
     */
    public function getById($id)
    {
        $select = $this->makeQueryFactory()->newSelect();
        $select->from(self::$DB_TABLE)
            ->cols(array(
                'id',
                'id_hash',
                'event',
                'thoughts',
                'feelings',
                'behaviors',
                'thoughts_accurate',
                'thoughts_helpful',
                'thinking_mistake_id',
                'say_to_self',
                'how_feel',
            ))
            ->where('id = :id')
            ->bindValue('id', $id);
        $sth = $this->sendQuery($select);
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }



    public function save(array $record_data)
    {
        $insert = $this->makeQueryFactory()->newInsert();
        $insert->into(self::$DB_TABLE)
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
