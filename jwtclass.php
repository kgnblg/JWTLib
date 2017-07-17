<?php
  class JwtClass{
    protected $header;
    protected $claims;
    protected $secretkey;
    protected $key;

    public function __construct(array $header = null, array $claims = null, $secret = null){
      if ($header != null && $claims != null && $secret != null) {
        $this->header = json_encode($header);
        $this->claims = json_encode($claims);
        $this->secretkey = $secret;
      }
    }

    public function setToken($token){
      $this->key = $token;
    }

    public function base64UrlEncode($data){
      return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
    }

    public function base64UrlDecode($data){
      return base64_decode(strtr($data, '-_,', '+/='));
    }

    public function createToken(){
      $encryptedHeader = $this->base64UrlEncode($this->header);
      $encryptedClaims = $this->base64UrlEncode($this->claims);
      $encryptedPayload = $encryptedHeader . "." . $encryptedClaims;

      $signature = hash_hmac("sha256", $encryptedPayload, $this->secretkey);
      return $encryptedPayload. "." . $signature;
    }

    public function decryptToken(){
      $tokenArray = explode('.',$this->key);
      $headerPart = json_decode($this->base64UrlDecode($tokenArray[0]));
      $payloadPart = json_decode($this->base64UrlDecode($tokenArray[1]));
      $returnArray = array('header' => $headerPart, 'payload' => $payloadPart);
      return $returnArray;
    }
  }

  $header_array = array("alg" => "HS256", "typ" => "JWT");
  $claims_array = array("name" => "Kagan Balga", "exp" => "10.10.10");
  $secret = "kaganbalga";

  $jwttest = new JwtClass();
  $jwttest->setToken("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiS2FnYW4gQmFsZ2EiLCJleHAiOiIxMC4xMC4xMCJ9.84b6f588cc75c766342703adccd757198b57fb53cbb090efae6a81c630d33ddd");
  print_r($jwttest->decryptToken());
?>
