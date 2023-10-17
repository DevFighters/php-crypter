<?php

namespace DF\Encryption;

final readonly class Crypter {

    public static function generateKey():string{
        return base64_encode(sodium_crypto_aead_xchacha20poly1305_ietf_keygen());
    }

    public function __construct(private string $key){}
    public function encrypt(string $data):string{
        $nonce = random_bytes($this->getNpuBytes());
        $crypt = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($data, $nonce, $nonce, $this->getKey());
        return base64_encode($nonce).base64_encode($crypt);
    }
    public function decrypt(string $textEncrypted):string{
        $nonce = base64_decode(substr($textEncrypted,0,$this->getBase64LengthOfRandomBytes()));
        $data = base64_decode(substr($textEncrypted,$this->getBase64LengthOfRandomBytes()));
        return sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($data, $nonce, $nonce, $this->getKey());
    }

    private function getKey(): string {
        return base64_decode($this->key);
    }
    private function getRandomBytes():string{
        return random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES);
    }
    private function getBase64LengthOfRandomBytes():int{
        return $this->getNpuBytes() * 8 / 6;
    }
    private function getNpuBytes():int{
        return SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES;
    }

}