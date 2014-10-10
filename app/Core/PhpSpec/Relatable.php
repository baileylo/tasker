<?php namespace Portico\Core\PhpSpec;

use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use Illuminate\Database\Query\Processors\MySqlProcessor;
use Illuminate\Database\Eloquent\Model as Eloquent;

trait Relatable
{
    protected $connection;

    public function relate($connection)
    {
        $this->connection = $connection;
        $connection->getQueryGrammar()->willReturn(new MySqlGrammar);
        $connection->getPostProcessor()->willReturn(new MySqlProcessor);

        $resolver = new ConnectionResolver(['default' => $connection->getWrappedObject()]);
        $resolver->setDefaultConnection('default');

        Eloquent::setConnectionResolver($resolver);
    }
}
