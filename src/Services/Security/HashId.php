<?php
/**
 * Created by PhpStorm.
 * User: tungnt
 * Date: 10/26/19
 * Time: 15:51
 */

namespace OneSite\Module\Services\Security;


use Hashids\Hashids;


/**
 * Class HashId
 * @package OneSite\Module\Services\Security
 */
class HashId
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $salt;

    /**
     * @var string
     */
    private $alphabet;

    /**
     * HashId constructor.
     */
    public function __construct()
    {
        $this->salt = config('security.hash_id.salt');
        $this->alphabet = config('security.hash_id.alphabet', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ012345678');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return string
     */
    public function getAlphabet(): string
    {
        return $this->alphabet;
    }

    /**
     * @param $integer
     * @param int $length
     * @param string $alphabet
     * @return string
     */
    public function encode($integer, $length = 8, $alphabet = '')
    {
        $alphabet = !empty($alphabet) ? $alphabet : $this->getAlphabet();

        $hash = new Hashids($this->getSalt(), $length, $alphabet);

        return $hash->encode($integer);
    }

    /**
     * @param $string
     * @param int $length
     * @param string $alphabet
     * @return int|mixed
     */
    public function decode($string, $length = 8, $alphabet = '')
    {
        $alphabet = !empty($alphabet) ? $alphabet : $this->getAlphabet();

        $hashids = new Hashids($this->getSalt(), $length, $alphabet);

        $ids = $hashids->decode($string);

        return !empty($ids[0]) ? $ids[0] : -1;
    }
}
