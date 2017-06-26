<?php
namespace Custom\Training1_Review\Api;

/**
 * Interface CountryDefinerInterface
 *
 * @package Custom\Training1_Review\Api
 */
interface CountryDefinerInterface
{
    /**
     * @param string $ip
     * @return mixed
     */
    public function defineCountry($ip);
}
