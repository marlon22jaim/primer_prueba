<?php

namespace App\Filters;
use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class OrderFilter extends ApiFilter
{
    protected $safeParams = [

        'supplierId' => ['eq'],
        'amount' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'status' => ['eq', 'ne'],
        'billedDate' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'paidDate' => ['eq', 'gt', 'gte', 'lt', 'lte'],


    ];
    protected $columnMap = [
        'supplierId' => 'supplier_id',
        'billedDate' => 'billed_dated',
        'paidDate' => 'paid_dated',

    ];
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'gte' => '>=',
        'lte' => '<=',
        'ne'=> '!=',
    ];
}
