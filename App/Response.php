<?php namespace App;

use App\Helpers\SingleTrait;

class Response
{
    use SingleTrait;

    protected $status;
    protected $body;
    protected $type;

    protected static $cache = false;

    public static function set_cache(bool $turn)
    {
        self::$cache = $turn;

        if (self::$cache) {
            header("Cache-Control: no-transform,public,max-age=300,s-maxage=900"); # enable cache
        }
    }

    public static function get_cache()
    {
        return self::$cache;
    }

    public function set_body($body)
    {
        $this->body = $body;
    }

    public function get_body()
    {
        return $this->body;
    }

    public function set_type($type)
    {
        $this->type = $type;
        header('Content-Type: ' . $this->get_type());
    }

    public function get_type()
    {
        return $this->type;
    }

    public function set_status($code)
    {
        $this->status = $code;

        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );

        http_response_code($this->get_status()); # set code

        header('Status: ' . $status[$this->status]); # ok, validation error, or failure
    }

    public function get_status()
    {
        // prepare if u need
        return $this->status;
    }

    public function json_response($message, $code, $cache = true)
    {
        header_remove();

        $this->__prepare($message, $code, $cache);

        // return response on json format
        return json_encode(array(
            'status' => $this->get_status() < 300, // success or not?
            'message' => $this->get_body()
        ));
    }

    public function html_response($html, $code, $cache = true)
    {
        header_remove();

        $this->__prepare($html, $code, $cache);

        return $this->get_body();
    }

    private function __prepare($message, $code, $type, $cache = false)
    {
        $this->set_status($code);
        $this->set_type($type);
        $this->set_body($message);
        self::set_cache($cache);
    }
}