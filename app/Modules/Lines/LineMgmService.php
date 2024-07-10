<?php

namespace App\Modules\Lines;

class LineMgmService {

    /** @var string */
    protected $loginChannelId;

    /** @var string */
    protected $liffUrl;

    public function __construct() {
        $this->loginChannelId = config('line.liff.login_channel_id');
        $this->liffUrl = config('line.liff.url');
        
    }

    public function getNewMemberOAuthUrl(string|null $redirectTargetUrl) {

        $redirectUrl = $this->liffUrl;
        if ($redirectTargetUrl) {
            $encodedUrl = urlencode($redirectTargetUrl);
            $redirectUrl = $redirectUrl."?_target_url=".$encodedUrl;
        }

        $channelId = $this->loginChannelId;
        $encodedRedirectUrl = urlencode($redirectUrl);

        return "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id={$channelId}&redirect_uri={$encodedRedirectUrl}&bot_prompt=aggressive&scope=profile&state=0";
    }
}