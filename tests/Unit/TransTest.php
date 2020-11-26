<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
const API_PATH = '/api/v1';

const EXPIRED_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC92MVwvYWRtaW5cL2xvZ2luIiwiaWF0IjoxNjA2MTQ4NDY1LCJleHAiOjE2MDYxNTIwNjUsIm5iZiI6MTYwNjE0ODQ2NSwianRpIjoiR0FPSEw2SnFKM0p4cmpXVSIsInN1YiI6MSwicHJ2IjoiY2YyODRjMmIxZTA2ZjMzYzI2YmQ1Nzk3NTY2ZDlmZDc0YmUxMWJmNSJ9.Xvfb8p-P2zO389jrHRLpLjL41OdPK9mRRvQwofCc5IA';

const VALID_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC92MVwvYWRtaW5cL2xvZ2luIiwiaWF0IjoxNjA2MzM4MjA0LCJleHAiOjE2MDY0MjQ2MDQsIm5iZiI6MTYwNjMzODIwNCwianRpIjoibHd4VTVCTEN5anNBckRzaSIsInN1YiI6MSwicHJ2IjoiY2YyODRjMmIxZTA2ZjMzYzI2YmQ1Nzk3NTY2ZDlmZDc0YmUxMWJmNSJ9.no4FYnrzICT7JbEFJBjkoHbgNetZY_xpoNE5qPRKrx4';

const INVALID_TOKEN = 'Invalid Token';

class TransTest extends TestCase
{
   

    public function test_200_api_admin_route()
    {
        $response = $this->get(API_PATH . '/trans/get');
        $response->assertStatus(200);
    }

    // TEST FAIL TOKEN invalid, expired, not found

    public function test_TOKEN_NOTFOUND_add_new_term()
    {
        $response = $this->json('POST', 
        API_PATH .'/trans/add', [
        'term' => 'API',
        'wEN' => 'Application Programming Interface',
        'wAR' => 'واجهة تطبيقات البرمجية',
        ]);
        $response->assertJson([
            "status"=> false,
            "message" => "TOKEN_NOTFOUND"
        ]);
    }

    public function test_INVALID_TOKEN_add_new_term()
    {
        $response = $this->json('POST', 
        API_PATH .'/trans/add', [
        'term' => 'API',
        'wEN' => 'Application Programming Interface',
        'wAR' => 'واجهة تطبيقات البرمجية',
        'token' => INVALID_TOKEN,
        ]);
        $response->assertJson([
            "status"=> false,
            "message" => "INVALID_TOKEN"
        ]);
    }

    public function test_EXPIRED_TOKEN_add_new_term()
    {
        $response = $this->json('POST', 
        API_PATH .'/trans/add', [
        'term' => 'API',
        'wEN' => 'Application Programming Interface',
        'wAR' => 'واجهة تطبيقات البرمجية',
        'token' => EXPIRED_TOKEN,
        ]);
        $response->assertJson([
            "status"=> false,
            "message" => "EXPIRED_TOKEN"
        ]);
    }

    public function test_missed_fields_with_VALID_TOKEN_add_new_term()
    {
        $response = $this->json('POST', 
        API_PATH .'/trans/add', [
        'term' => 'API',
        'wEN' => 'Application Programming Interface',
        // filed wAR missed 
        'token' => VALID_TOKEN,
        ]);
        $response->assertJson([
            "status"=> false,
            "message" => "Fields Required"
        ]);
    }
}
