<?php
if (!function_exists('enCodeId'))
{
    function enCodeId($var)
    {
        $hashids = new Hashids\Hashids(md5('sadeghi'));
        return $hashids->encode($var);
    }
}
if (!function_exists('deCodeId'))
{
    function deCodeId($var)
    {
        try
        {
            $hashids = new Hashids\Hashids(md5('sadeghi'));
            return $hashids->decode($var);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e)
        {
            return false;
        }
    }
}
