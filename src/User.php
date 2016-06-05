<?php
namespace Extasy\Users;

use Extasy\Model\Model as BaseModel;
use Extasy\Users\Configuration\ConfigurationRepository;

/**
 * Class User
 * @package Extasy\Users
 * @property \Extasy\Model\Columns\Index $id
 * @property \Extasy\Users\Columns\Login $login
 * @property \Extasy\Users\Columns\Password $password
 * @property \Extasy\Users\Columns\TimeAccess $time_access
 * @property \Extasy\Model\Columns\Datetime $registered
 * @property \Extasy\Users\Columns\ConfirmationCode $confirmation_code
 * @property \Extasy\Model\Columns\Input $email_confirmation_code
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

    public function getFieldsInfo()
    {
        $initialFields = [
            'id' => '\\Extasy\\Model\\Columns\\Index',
            'login' => '\\Extasy\\Users\\Columns\\Login',
            'password' => '\\Extasy\\Users\\Columns\\Password',
            'time_access' => '\\Extasy\\Users\\Columns\\TimeAccess',
            'registered' => '\\Extasy\\Model\\Columns\\Datetime',
            'confirmation_code' => '\\Extasy\\Users\\Columns\\ConfirmationCode',
            'email_confirmation_code' => '\\Extasy\\Model\\Columns\\Input',
            'email' => '\\Extasy\\Users\\Columns\\Email',
            'new_email' => '\\Extasy\\Model\\Columns\\Input',

        ];
        $fields = $this->configurationRepository->read()->fields;
        $fields = array_merge($initialFields, $fields);

        return [
            'fields' => $fields
        ];
    }

}