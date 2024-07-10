<?php

namespace App\Lines;

use Log;
use DateUtilityService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder ;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineCustomMessageBuilder implements MessageBuilder
{
    private $message = [];

    public function __construct($message) {
        $this->message = $message;
    }

    public function buildMessage() {
        return $this->message;
    }
}

class LineService
{
    private $bot;

    const HTTP_TIMEOUT = 30;

    const API_GET_PROFILE = '/v2/profile';
    const API_GET_FRIENDSHIP = '/friendship/v1/status';

    /** @var boolean */
    protected $isUseLineMock;
    /**
     * LineService constructor. */
    public function __construct(){
        $httpClient = new CurlHTTPClient(config('services.line.msgAPIChannelAccessToken'));
        $this->bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.msgAPIChannelSecret')]);
        $this->isUseLineMock = config('services.line.useMockUser');
    }
    

    public function pushTextMessage(string $lineId, string $text_message): bool {
        // 假設 Mocked 就回傳 True
        if ($this->isUseLineMock) {
            return true;
        }

        $msg = new TextMessageBuilder($text_message);
        $res = $this->bot->pushMessage($lineId, $msg);

        if ($res->isSucceeded()) {
            Log::info("pushMessage() success: line_uid=[{$lineId}]");
            return true;
        }
        else {
            $httpStatusCode = $res->getHTTPStatus();
            $errorMessage = $res->getRawBody();
            Log::error("pushMessage() error:  msg=[{$errorMessage}] httpStatus=[({$httpStatusCode})] line_uid=[{$lineId}]");
            echo $errorMessage;
            return false;
        }
    }

    public function pushMessage(string $lineId, $json_messages) {
        // 假設 Mocked 就回傳 True
        if ($this->isUseLineMock) {
            return true;
        }
        
        $msg = new LineCustomMessageBuilder($json_messages);
        $res = $this->bot->pushMessage($lineId, $msg);

        if ($res->isSucceeded()) {
            Log::info("pushMessage() success: line_uid=[{$lineId}]");
            return true;
        }
        else {
            $httpStatusCode = $res->getHTTPStatus();
            $errorMessage = $res->getRawBody();
            Log::error("pushMessage() error:  msg=[{$errorMessage}] httpStatus=[({$httpStatusCode})] line_uid=[{$lineId}]");
            return false;
        }
    }

    public function getProfile(string $accessToken) {
        // 假設 Mocked 就回傳 True
        if ($this->isUseLineMock) {
            return true;
        }

        $client = new Client([
            'verify' => false,
            'base_uri' => 'https://api.line.me',
            'timeout'  => self::HTTP_TIMEOUT,
        ]);
        try {
            $response = $client->request('GET', self::API_GET_PROFILE, [
                'headers' => [ 'Authorization' => "Bearer {$accessToken}" ],
            ]);
            $code = $response->getStatusCode();
            $body = $response->getBody();
            $data = json_decode($body, true);
            return $data;
        }
        catch (RequestException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $code = $res->getStatusCode();
                $body = $res->getBody();
                Log::error("Request [".self::API_GET_PROFILE."] fail, http_code=[{$code}], reason: {$body}");
            }
            return null;
        }
        catch (ConnectException $e) {
            Log::error("Request [".self::API_GET_PROFILE."] fail, http connection error.");
            return null;
        }
    }


    /** 透過 Liff 的 Acess Token 取得 Line OA 的帳號 */
    public function isLineOAFriendship(string $accessToken) {
        $client = new Client([
            'verify' => false,
            'base_uri' => 'https://api.line.me',
            'timeout'  => self::HTTP_TIMEOUT,
        ]);
        try {
            $response = $client->request('GET', self::API_GET_FRIENDSHIP, [
                'headers' => [ 'Authorization' => "Bearer $accessToken" ],
            ]);

            $code = $response->getStatusCode();
            $body = $response->getBody();
            $json = json_decode($body, true);

            return $json['friendFlag'];
        }
        catch (RequestException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $code = $res->getStatusCode();
                $body = $res->getBody();
                Log::error("Request [".self::API_GET_FRIENDSHIP."] fail, http_code=[{$code}], reason: {$body}");
            }
            return false;
        } catch (ConnectException $e) {
            Log::error("Request [".self::API_GET_FRIENDSHIP."] fail, http connection error.");
            return false;
        }
    }

}