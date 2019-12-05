<?php

namespace simonardejr\Router;

class Response
{
    public static function json($data=[])
    {
        echo json_encode($data, true);
    }

    public static function send($data)
    {
        echo $data;
    }

}