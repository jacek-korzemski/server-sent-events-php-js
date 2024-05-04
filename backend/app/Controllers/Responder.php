<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Responder extends BaseController
{

	use ResponseTrait;

	public function stream()
	{
		$this->response->setHeader('Access-Control-Allow-Origin', '*');
		$this->response->setHeader('Access-Control-Allow-Methods', 'GET');
		$this->response->setHeader('Content-Type', 'text/event-stream');
		$this->response->setHeader('Cache-Control', 'no-cache');

		$this->response->sendHeaders();

        $this->sendEvents();
	}

    private function sendEvents($counter = 0)
    {
        echo "event: ping\n";
        $curDate = date(DATE_ISO8601);
        echo 'data: {"time": "' . $curDate . '"}';
        echo "\n\n";

        $counter--;

        if ($counter <= 0) 
        {
            echo 'data: This is a message at time ' . $curDate . "\n\n";
            $counter = rand(1, 10);
        }

        if (ob_get_contents()) 
        {
            ob_end_flush();
        }
        flush();

        usleep(1000000);
        $this->sendEvents($counter);
    }
}