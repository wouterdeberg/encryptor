<?php

namespace FlexFlux\Encryptor;

trait EncryptThis
{
    public function getEncryptable()
    {
        return $this->encryptable;
    }

    public function setEncryptable(array $encryptable)
    {
        $this->encryptable = $encryptable;
    }

}