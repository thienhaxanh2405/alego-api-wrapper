<?php
namespace AlegoApiWrapper\Connection;

class RequestData
{
    /**
     * @param        $string
     * @param string $seed
     *
     * @return string
     */
    public static function encrypt($string, $seed = "1234567890123")
    {
        $input = trim($string);
        $block = mcrypt_get_block_size('tripledes', 'ecb');
        $len = strlen($input);
        $padding = $block - ($len % $block);
        $input .= str_repeat(chr($padding), $padding);

        // generate a 24 byte key from the md5 of the seed
        $key = substr(md5($seed), 0, 24);
        $iv_size = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        // encrypt
        $encrypted_data = mcrypt_encrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv);
        // clean up output and return base64 encoded
        $encrypted_data = base64_encode($encrypted_data);
        return $encrypted_data;
    } // end encrypt

    /**
     * @param        $string
     * @param string $seed
     *
     * @return bool|string
     */
    public static function decrypt($string, $seed = "1234567890123")
    {
        $input = base64_decode($string);
        $key = substr(md5($seed), 0, 24);

        $text = mcrypt_decrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, 'Mkd34ajdfka5');
        $block = mcrypt_get_block_size('tripledes', 'ecb');
        $packing = ord($text{strlen($text) - 1});

        if ($packing and ( $packing < $block)) {
            for ($P = strlen($text) - 1; $P >= strlen($text) - $packing; $P--) {
                if (ord($text{$P}) != $packing) {
                    $packing = 0;
                }
            }
        }

        $text = substr($text, 0, strlen($text) - $packing);
        return $text;
    }
} // end class
