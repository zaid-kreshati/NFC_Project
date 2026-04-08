<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Traits\JsonResponseTrait;

class InvoiceExpiredException extends Exception
{
    use JsonResponseTrait;
    public function render($request,): JsonResponse
    {
        return $this->error('انتهت مدة الحصول على الفاتورة .', 410);
    }
}
