<?php
include 'jwtclass.php';
use PHPUnit\Framework\TestCase;

class JwtClassTest extends TestCase
{
  public function testBase64UrlEncode(){
    $ceviriText = "kaganbalga";
    $encryptText = strtr(rtrim(base64_encode($ceviriText), '='), '+/', '-_');
    $jwt = new JwtClass(null, null, null);
    $cikti = $jwt->base64UrlEncode($ceviriText);
    $this->assertEquals($encryptText, $cikti);
  }

  public function testCreateToken(){
    $header_array = array("alg" => "HS256", "typ" => "JWT");
    $claims_array = array("name" => "Kagan Balga", "exp" => "10.10.10");
    $secret = "kaganbalga";

    $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiS2FnYW4gQmFsZ2EiLCJleHAiOiIxMC4xMC4xMCJ9.84b6f588cc75c766342703adccd757198b57fb53cbb090efae6a81c630d33ddd";
    $jwt = new JwtClass($header_array, $claims_array, $secret);
    $cikti = $jwt->createToken();

    $this->assertEquals($token, $cikti);
  }
}
?>
