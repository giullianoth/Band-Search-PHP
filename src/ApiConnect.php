<?php

namespace Src;

abstract class ApiConnect {
    protected $url;
    protected $search;
    protected $apiKey;
    protected $message;
    
    public function __construct(string $url) {
        $this->url = $url;
    }
    
    public function fetch() {
        
        try {
            $ch = curl_init($this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = json_decode(curl_exec($ch));
            curl_close($ch);

            return $response;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
