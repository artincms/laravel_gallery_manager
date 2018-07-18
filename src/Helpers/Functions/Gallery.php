<?php
if (!function_exists('enCodeId'))
{
    function enCodeId($var)
    {
        $hashids = new Hashids\Hashids('SadeghiGallery');
        return $hashids->encode($var);
    }
}
if (!function_exists('deCodeId'))
{
    function deCodeId($var)
    {
        try
        {
            $hashids = new Hashids\Hashids('SadeghiGallery');
            return $hashids->decode($var);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e)
        {
            return false;
        }
    }
}
