<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

Class OrganizationService{

	use ConsumesExternalService;

	public $baseUri;
	public $secret;

	public function __construct(){
		$this->baseUri = config('microservices.organization.base_uri');
		$this->secret = config('microservices.organization.secret');
	}

	public function obtainBookings(){
		return $this->performRequest('GET', '/api/v1/booking');
	}

	public function createBooking($data){
		return $this->performRequest('POST', '/api/v1/booking', $data);
	}

//	public function obtainBookings($author){
//		return $this->performRequest('GET', "/authors/{$author}");
//	}
//
//
//	public function updateBookings($data, $author){
//		return $this->performRequest('PUT', "/authors/{$author}", $data);
//	}
//
//	public function deleteBookings($author){
//		return $this->performRequest('DELETE', "/authors/{$author}");
//	}
}
