<?php
namespace Extasy\Users\Usecases;

use Extasy\Users\RepositoryInterface;
use Extasy\Users\Search\Request;
use \InvalidArgumentException;

class SearchByLogin extends BaseUsecase
{
    const MinLength = 3;
    const Limit = 100;
    protected $login = '';
    /**
     * @var RepositoryInterface|null
     */
    protected $repository = null;
    public function __construct( $login, RepositoryInterface $repositoryInterface )
    {
        $this->login = trim($login);
        $this->repository = $repositoryInterface;
    }
    public function execute() {
        if (strlen( $this->login ) < self::MinLength ) {
            throw new InvalidArgumentException('Search key too small');
        }

        $condition = new Request();
        $condition->likeFields = ['login' => $this->login ];
        $condition->limit = self::Limit;
        $found = $this->repository->find( $condition );
        return $found;
    }
}