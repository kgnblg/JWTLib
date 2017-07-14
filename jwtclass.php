<?php
  class JwtClass{
    protected $header;
    protected $claims;
    protected $secretkey;

    public function __construct(array $header = null, array $claims = null, $secret = null){
      if ($header != null && $claims != null && $secret != null) {
        $this->header = json_encode($header);
        $this->claims = json_encode($claims);
        $this->secretkey = $secret;
      }
    }

    public function base64UrlEncode($data){
      return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
    }

    public function createToken(){
      $encryptedHeader = $this->base64UrlEncode($this->header);
      $encryptedClaims = $this->base64UrlEncode($this->claims);
      $encryptedPayload = $encryptedHeader . "." . $encryptedClaims;

      $signature = hash_hmac("sha256", $encryptedPayload, $this->secretkey);
      return $encryptedPayload. "." . $signature;
    }
  }

  $header_array = array("alg" => "HS256", "typ" => "JWT");
  $claims_array = array("name" => "Kagan Balga", "exp" => "10.10.10");
  $secret = "kaganbalga";

  $jwttest = new JwtClass($header_array, $claims_array, $secret);
  echo $jwttest->createToken();
?>
