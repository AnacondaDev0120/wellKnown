<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/protobuf/descriptor.proto

namespace Google\Protobuf\Internal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\GPBWire;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\InputStream;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Describes a value within an enum.
 *
 * Generated from protobuf message <code>google.protobuf.EnumValueDescriptorProto</code>
 */
class EnumValueDescriptorProto extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>optional string name = 1;</code>
     */
    protected $name = null;
    /**
     * Generated from protobuf field <code>optional int32 number = 2;</code>
     */
    protected $number = null;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.EnumValueOptions options = 3;</code>
     */
    protected $options = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *     @type int $number
     *     @type \Google\Protobuf\Internal\EnumValueOptions $options
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Protobuf\Internal\Descriptor::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>optional string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return isset($this->name) ? $this->name : '';
    }

    public function hasName()
    {
        return isset($this->name);
    }

    public function clearName()
    {
        unset($this->name);
    }

    /**
     * Generated from protobuf field <code>optional string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional int32 number = 2;</code>
     * @return int
     */
    public function getNumber()
    {
        return isset($this->number) ? $this->number : 0;
    }

    public function hasNumber()
    {
        return isset($this->number);
    }

    public function clearNumber()
    {
        unset($this->number);
    }

    /**
     * Generated from protobuf field <code>optional int32 number = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setNumber($var)
    {
        GPBUtil::checkInt32($var);
        $this->number = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.EnumValueOptions options = 3;</code>
     * @return \Google\Protobuf\Internal\EnumValueOptions|null
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function hasOptions()
    {
        return isset($this->options);
    }

    public function clearOptions()
    {
        unset($this->options);
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.EnumValueOptions options = 3;</code>
     * @param \Google\Protobuf\Internal\EnumValueOptions $var
     * @return $this
     */
    public function setOptions($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Internal\EnumValueOptions::class);
        $this->options = $var;

        return $this;
    }

}

