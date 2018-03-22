<?php

class AuthModel extends test1\Model
{

    protected $table = 'admins';

    public function login(array $data)
    {
        $get = [
            'table'     => $this->table,
            'where'     => [
                ['email', $data['email']],
                ['password', crypt($data['password'], ENV_SALT)],
            ],
        ];
        $find = $this->getArray($get);
        if (count($find) > 0) {
            return $find[0]['id'];
        }
        return false;
    }

}
