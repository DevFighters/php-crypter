<?php

namespace DF\Encryption;

final readonly class Crypter {

    private const SIGNATURE = '<ENC>';
    private const NPUBYTES = SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES;

    public static function generateKey():string{
        return base64_encode(sodium_crypto_aead_xchacha20poly1305_ietf_keygen());
    }

    public function __construct(private string $key){}

    public function encrypt(string $textToEncrypt):string{
        $nonce = random_bytes($this->getNpuBytes());
        $crypt = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($text, $nonce, $nonce, $this->getKey());
        $textEncrypted = base64_encode($nonce).base64_encode($crypt);
        return $this->addSignature($textEncrypted);
    }
    public function decrypt(string $textEncrypted):string{
        if($this->isNotEncrypted($textEncrypted)){
            throw new \Exception("This string appears unencrypted");
        }
        $textEncrypted = $this->removeSignature($textEncrypted);
        $nonce = base64_decode(substr($textEncrypted,0,$this->getBase64LengthOfRandomBytes()));
        $data = base64_decode(substr($textEncrypted,$this->getBase64LengthOfRandomBytes()));
        return sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($data, $nonce, $nonce, $this->getKey());
    }

    public function isEncrypted(string $textEncrypted):bool{
        return substr($textEncrypted,-$this->getSignatureLength()) === $this->getSignature();
    }
    public function isNotEncrypted(string $textEncrypted):bool{
        return !$this->isEncrypted($textEncrypted);
    }

    private function addSignature(string $text):string{
        return $text.$this->getSignature();
    }
    private function removeSignature(string $text):string{
        return substr($text,0,-$this->getSignatureLength());
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
        return self::NPUBYTES;
    }
    private function getSignature():string{
        return self::SIGNATURE;
    }
    private function getSignatureLength():int{
        return strlen($this->getSignature());
    }

}