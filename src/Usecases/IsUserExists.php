<?php
namespace Extasy\Users\Usecases;

use Extasy\Users\Search\Request;
use Extasy\Users\RepositoryInterface;
class IsUserExists extends BaseUsecase
{
    protected $login = '';
    protected $repository = null;
    public function __construct( $login, RepositoryInterface $repositoryInterface )
    {
        $this->login = $login;
        $this->repository = $repositoryInterface;
    }
    public function execute() {
        $condition = new Request();
        $condition->fields = ['login' => $this->login ];
        $found = $this->repository->findOne( $condition );
        return !empty( $found );
    }
}