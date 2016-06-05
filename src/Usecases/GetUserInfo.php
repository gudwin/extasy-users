<?php
namespace Extasy\Users\Usecases;

use Extasy\Users\User;

class GetUserInfo extends BaseUsecase
{
    /**
     * @var User|null
     */
    protected $user = null;
    protected $fields = [];
    public function __construct( User $user, array $fields )
    {
        $this->user = $user;
        $this->fields = $fields;
    }
    public function execute()
    {
        $result = [];
        foreach ( $this->fields as $fieldName ) {
            $result[ $fieldName ] = $this->user->$fieldName->getValue();
        }
        return $result;
    }
}