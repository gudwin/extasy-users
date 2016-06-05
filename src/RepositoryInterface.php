<?php


namespace Extasy\Users;

use Extasy\Users\Search\Request;

interface RepositoryInterface
{
    public function flush();
    public function insert( User $model );
    public function update( User $model );
    public function delete( User $model );
    /**
     * @param $id
     * @return mixed
     * @throws \Extasy\Model\NotFoundException
     */
    public function get( $id );
    public function find( Request $condition );
    public function findOne( Request $condition );

}