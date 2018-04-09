<?php

namespace Recruiting\Test;

class CreditCard
{
    public $number;
    protected $error;

    /**
     * @param $length
     * @param $category
     * @return bool|int
     */
    function checkLength($number, $category)
    {
        $length = strlen($number);

        switch ($category) {
            case 0:
                $result = (($length == 13) || ($length == 16));
                break;
            case 1:
                $result = (($length == 16) || ($length == 18) || ($length == 19));
                break;
            case 2:
                $result = ($length == 16);
                break;
            case 3:
                $result = ($length == 15);
                break;
            case 4:
                $result = ($length == 14);
                break;
            default:
                $result = 1;
        }

        return $result;
    }

    /**
     * @param null $number
     * @return bool|string
     */
    function isValid($number = null)
    {
        if (is_null($number)) {
            $this->error = CredCardErrors::INVALID_CHAR;
        }

        $number = $this->getValue($number);
        $lencat = $this->getLengthCategory($number);

        $this->error = CredCardErrors::INVALID_LENGTH;

        if ($this->checkLength($number, $lencat)) {
            $this->number = $number;
            $this->error = true;
        }

        return $this->error;
    }


    /**
     * Retrieve the current card number
     *
     * @return number
     */
    function getNumber()
    {
        return $this->number;
    }

    /**
     *
     * Get category length
     *
     * Visa = 4XXX - XXXX - XXXX - XXXX
     * MasterCard = 5[1-5]XX - XXXX - XXXX - XXXX
     * Discover = 6011 - XXXX - XXXX - XXXX
     * Amex = 3[4,7]X - XXXX - XXXX - XXXX
     * Diners = 3[0,6,8] - XXXX - XXXX - XXXX
     * Any Bankcard = 5610 - XXXX - XXXX - XXXX
     * JCB =  [3088|3096|3112|3158|3337|3528] - XXXX - XXXX - XXXX
     * Enroute = [2014|2149] - XXXX - XXXX - XXX
     * Switch = [4903|4911|4936|5641|6333|6759|6334|6767] - XXXX - XXXX - XXXX
     *
     * @param $number
     * @return int|null
     */
    public function getLengthCategory($number)
    {
        $number = (int) $number[0];

        $lencat = null;
        switch ($number) {
            case 4:
                $lencat = 2;
                break;
            case 5:
                $lencat = 2;
                break;
            case 3:
                $lencat = 4;
                break;
            case 2:
                $lencat = 3;
                break;
        }

        return $lencat;
    }

    /**
     * @param $number
     * @return string
     */
    private function getValue($number)
    {
        $length = strlen($number);

        $return = '';
        for ($index = 0; $index < $length; $index++) {
            $character = $number[$index];

            if (ctype_digit($character)) {
                $return .= $character;
            } elseif (!ctype_space($character) && !ctype_punct($character)) {
                $this->error = CredCardErrors::INVALID_CHAR;
                break;
            }
        }

        return $return;
    }

    /**
     * @param $number
     * @return bool|string
     */
    public function setNumber($number)
    {
        if (!is_null($number)) {
            return $this->isValid($number);
        }

        $this->number = $number;
    }

}
