<?php

namespace App\Services;

class AppService
{

    private function _client($F5srv)
    {
        $opts = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($opts);
        $wsdl = "wsdl path";

        try {
            $this->client = new \SoapClient($wsdl, array(
                'stream_context' => $context, 'trace' => true,
                'login' => username, 'password' => password)
            );

            return $this->client;
        } catch (\Exception $e) {
            Log::info('Caught Exception in client' . $e->getMessage());
        }
    }
    public function getCurrency($params) {
        $this->client = $this->_client($params['config']);
    
        try {
          $result = $this->client->Currency($parms);
          return $result;
        }
    
        catch (\Exception $e) {
         Log::info('Caught Exception :'. $e->getMessage());
             return $e;       // just re-throw it
           }
     }
     
}
