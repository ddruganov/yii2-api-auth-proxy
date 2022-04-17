<?php

namespace ddruganov\Yii2ApiAuthProxy\components;

use yii\base\Component;

class AuthServiceUser extends Component
{
    public int $id;
    public string $email;
    public string $name;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }
}
