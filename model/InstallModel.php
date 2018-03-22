<?php

class InstallModel extends test1\Model
{

    public function createTables()
    {
        $sqlAdminTable = 'create table if not exists admins ('
            . ' id int not null auto_increment primary key,'
            . ' email varchar(256),'
            . ' password varchar(50),'
            . ' created_at datetime'
            . ')default charset=utf8';
        $sqlNewsTable = 'create table if not exists news ('
            . ' id int not null auto_increment primary key,'
            . ' user_id integer,'
            . ' title varchar(255),'
            . ' message varchar(1023) default null,'
            . ' image varchar(127) default null,'
            . ' created_at datetime,'
            . ' updated_at datetime'
            . ')default charset=utf8';
        $ins1 = $this->query($sqlAdminTable);
        $ins2 = $this->query($sqlNewsTable);
        return $ins1 && $ins2;
    }

    public function createAdmin()
    {
        $sel = [
            'table'     => 'admins',
            'values'    => ['id'],
            'where'     => [
                ['email' , ENV_ADMIN_EMAIL],
            ]
        ];
        $exist = $this->getArray($sel);
        if (count($exist) > 0) {
            return 0;
        }
        $now = $this->now();
        $sql = 'insert into admins (email, password, created_at) values'
            . ' ("' . ENV_ADMIN_EMAIL . '", "' . crypt(ENV_ADMIN_PASSWORD, ENV_SALT) . '", "' . $now . '")';
        $ins = [
            'table'     => 'admins',
            'fields'    => ['email', 'password', 'created_at'],
            'values'    => [
                [ENV_ADMIN_EMAIL, crypt(ENV_ADMIN_PASSWORD, ENV_SALT), $now],
            ],
        ];
        return $this->insert($ins);
    }

}
