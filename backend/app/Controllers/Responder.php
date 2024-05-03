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

		$time = date('r');
		echo "data: The server time is: {$time}\n\n";
		flush();
	}
}