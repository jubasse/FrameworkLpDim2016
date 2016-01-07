<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 11:27
 */

namespace Framework\Http;

class Header
{
    private $name;
    private $value;

    /**
     * Header constructor.
     * @param $name
     * @param $value
     */
    public function __construct(string $name,string $value)
    {
        $this->name = strtolower($name);
        $this->value = $value;
    }

    public static function createFromString($line)
    {
        $result = preg_match("#^(?P<header>[a-z][a-z0-9\-]+)\: (?P<value>.+)$#i",$line,$header);
        if(!$result){
            throw new MalformedHttpHeaderException("Invalid header line : ".$line);
        }
        return new self($header["header"],$header["value"]);
    }

    public function match($name)
    {
        return (strtolower($name) === $this->name);
    }

    public function __toString()
    {
        return $this->name.": ".$this->value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function toArray()
    {
        return [ $this->name => $this->value ];
    }
}