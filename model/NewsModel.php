<?php

class NewsModel extends test1\Model
{

    protected $table = "news";
    protected $values = [];

    protected $fields = [
        'id',
        'title',
        'user_id',
        'message',
        'image',
        'created_at',
        'updated_at',
    ];

    public function __construct()
    {
        return $this;
    }

}
