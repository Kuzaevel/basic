<?php

namespace app\storage;

class PublicKeyStorage {

    // TODO send to config

    private static $pbk = 'pubkey.pem';

    public static function getPublicKey() {
        return file_get_contents(__DIR__ . '/' . self::$pbk, true);
    }

    public static function setPublicKey($publicKey) {
        file_put_contents(__DIR__ . '/' . self::$pbk, $publicKey);
        return file_get_contents(self::$pbk, true);
    }

    public static function getChangeTime() {
        return filemtime(__DIR__ . '/' . self::$pbk);
    }

    public static function isEmpty() {
        return !(bool) filesize(__DIR__ . '/' . self::$pbk);
    }



}