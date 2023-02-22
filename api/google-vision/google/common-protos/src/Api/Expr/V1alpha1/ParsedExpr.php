<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/expr/v1alpha1/syntax.proto

namespace Google\Api\Expr\V1alpha1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * An expression together with source information as returned by the parser.
 *
 * Generated from protobuf message <code>google.api.expr.v1alpha1.ParsedExpr</code>
 */
class ParsedExpr extends \Google\Protobuf\Internal\Message
{
    /**
     * The parsed expression.
     *
     * Generated from protobuf field <code>.google.api.expr.v1alpha1.Expr expr = 2;</code>
     */
    private $expr = null;
    /**
     * The source info derived from input that generated the parsed `expr`.
     *
     * Generated from protobuf field <code>.google.api.expr.v1alpha1.SourceInfo source_info = 3;</code>
     */
    private $source_info = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Api\Expr\V1alpha1\Expr $expr
     *           The parsed expression.
     *     @type \Google\Api\Expr\V1alpha1\SourceInfo $source_info
     *           The source info derived from input that generated the parsed `expr`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Api\Expr\V1Alpha1\Syntax::initOnce();
        parent::__construct($data);
    }

    /**
     * The parsed expression.
     *
     * Generated from protobuf field <code>.google.api.expr.v1alpha1.Expr expr = 2;</code>
     * @return \Google\Api\Expr\V1alpha1\Expr
     */
    public function getExpr()
    {
        return $this->expr;
    }

    /**
     * The parsed expression.
     *
     * Generated from protobuf field <code>.google.api.expr.v1alpha1.Expr expr = 2;</code>
     * @param \Google\Api\Expr\V1alpha1\Expr $var
     * @return $this
     */
    public function setExpr($var)
    {
        GPBUtil::checkMessage($var, \Google\Api\Expr\V1alpha1\Expr::class);
        $this->expr = $var;

        return $this;
    }

    /**
     * The source info derived from input that generated the parsed `expr`.
     *
     * Generated from protobuf field <code>.google.api.expr.v1alpha1.SourceInfo source_info = 3;</code>
     * @return \Google\Api\Expr\V1alpha1\SourceInfo
     */
    public function getSourceInfo()
    {
        return $this->source_info;
    }

    /**
     * The source info derived from input that generated the parsed `expr`.
     *
     * Generated from protobuf field <code>.google.api.expr.v1alpha1.SourceInfo source_info = 3;</code>
     * @param \Google\Api\Expr\V1alpha1\SourceInfo $var
     * @return $this
     */
    public function setSourceInfo($var)
    {
        GPBUtil::checkMessage($var, \Google\Api\Expr\V1alpha1\SourceInfo::class);
        $this->source_info = $var;

        return $this;
    }

}

