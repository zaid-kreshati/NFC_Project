<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Traits\JsonResponseTrait;



class InvoiceAlreadyClaimedException extends Exception
{
    use JsonResponseTrait;
    public function render($request): JsonResponse
    {
        return $this->error('هذه الفاتورة تم الحصول عليها من قبل شخص آخر.', 409);
    }
}
