<?php

use DF\Encryption\Crypter;
use PHPUnit\Framework\TestCase;

class CrypterTest extends TestCase {

    public function test(){

        $text = 'Hello world !! ABCDE <br/> 1234 <br/> é\'^';
        $key = Crypter::generateKey();

        $crypter = new Crypter($key);

        $encryptedText = $crypter->encrypt($text);
        $decryptedText = $crypter->decrypt($encryptedText);

        $this->assertEquals($text, $decryptedText);
    }

}
