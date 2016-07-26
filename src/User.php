<?php
namespace Extasy\Users;

use Extasy\Model\Model as BaseModel;
use Extasy\Users\Configuration\ConfigurationRepository;
use \InvalidArgumentException;

/**
 * Class User
 * @package Extasy\Users
 * @property \Extasy\Model\Columns\Index $id
 * @property \Extasy\Users\Columns\Login $login
 * @property \Extasy\Users\Columns\Password $password
 * @property \Extasy\Users\Columns\TimeAccess $time_access
 * @property \Extasy\Model\Columns\Datetime $registered
 * @property \Extasy\Users\Columns\ConfirmationCode $confirmation_code
 * @property \Extasy\Model\Columns\ConfirmationCode $email_confirmation_code
 * @property \Extasy\Users\Columns\Email $email
 * @property \Extasy\Model\Columns\Input $new_email
 */
class User extends BaseModel
{
    const ModelName = '\\Extasy\\Users\\User';
    /**
     * @var ConfigurationRepository
     */
    protected $configurationRepository = null;

    public function __construct(array $initialData, ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;

        parent::__construct($initialData);

    }
    public function isBanned() {
        $isBanned = !empty( $this->confirmation_code->getValue());
        return $isBanned;
    }
    public function getFieldsInfo()
    {
        $initialFields = [
            'id' => '\\Extasy\\Model\\Columns\\Index',
            'login' => [
                'class' => '\\Extasy\\Users\\Columns\\Login',
                'parse_field' => 'getValue',
            ],
            'password' => [
                'class' => '\\Extasy\\Users\\Columns\\Password',
                'hash' => $this->configurationRepository->read()->securityHash,
                'parse_field' => 'getValue',
            ],
            'time_access' => [
                'class' => '\\Extasy\\Users\\Columns\\TimeAccess',
                'parse_field' => 'getValue',
            ],
            'registered' => [
                'class' => '\\Extasy\\Model\\Columns\\Datetime',
                'parse_field' => 'getValue',
            ],
            'confirmation_code' => [
                'class' => '\\Extasy\\Users\\Columns\\ConfirmationCode',
            ],
            'email_confirmation_code' => [
                'class' => '\\Extasy\\Users\\Columns\\ConfirmationCode',
            ],
            'email' => [
                'class' => '\\Extasy\\Users\\Columns\\Email',
                'parse_field' => 'getValue',
            ],
            'new_email' => '\\Extasy\\Users\\Columns\\Email',

        ];
        $fields = $this->configurationRepository->read()->fields;
        $fields = array_merge($initialFields, $fields);

        return [
            'fields' => $fields
        ];
    }

}