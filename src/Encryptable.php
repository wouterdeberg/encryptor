<?php

namespace FlexFlux\Encryptor;

use Illuminate\Contracts\Encryption\DecryptException;

trait Encryptable
{
    /**
     * If the attribute is in the encryptable array
     * then decrypt it.
     *
     * @param  $key
     *
     * @return $value
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->encryptable) && !is_null($value) && $value !== '') {
            try {
                $value = decrypt($value);
            } catch (DecryptException $exception) {
                // Ignore exception. Value is not encrypted.
            }
        }
        
        return $value;
    }
    /**
     * If the attribute is in the encryptable array
     * then encrypt it.
     *
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = encrypt($value);
        }
        return parent::setAttribute($key, $value);
    }
    /**
     * When need to make sure that we iterate through
     * all the keys.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        foreach ($this->encryptable as $key) {
            if (isset($attributes[$key])) {
                try {
                    $attributes[$key] = decrypt($attributes[$key]);
                } catch (DecryptException $exception) {
                    // Ignore exception. Value is not encrypted.
                }
            }
        }
        return $attributes;
    }

}