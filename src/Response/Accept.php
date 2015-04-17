<?php

namespace Dafiti\Silex\Response;

use Dafiti\Silex\Exception\AcceptNotAllowed;

class Accept
{
    /**
     * @var array
     */
    private $availablesAccepts = [];

    /**
     * @var string
     */
    private $default;

    /**
     * @param string $defaultAccept
     * @param array  $availablesAccepts
     */
    public function __construct($defaultAccept, array $availablesAccepts = [])
    {
        $this->default = $defaultAccept;
        $this->availablesAccepts = $availablesAccepts;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param array $accepts
     *
     * @return string
     *
     * @throws AcceptNotAllowed
     */
    public function getBest(array $accepts)
    {
        if (empty($accepts)) {
            return $this->getDefault();
        }

        foreach ($accepts as $accept) {
            if ($this->isAllowed($accept)) {
                return $accept;
            }
        }

        throw new AcceptNotAllowed($accepts);
    }

    /**
     * @param string $accept
     *
     * @return bool
     */
    public function isAllowed($accept)
    {
        if (!in_array($accept, $this->availablesAccepts)) {
            return false;
        }

        return true;
    }

    public function hasAllowed(array $accepts)
    {
        if (empty($accepts)) {
            return false;
        }

        foreach ($accepts as $accept) {
            if ($this->isAllowed($accept)) {
                return true;
            }
        }

        return false;
    }
}
