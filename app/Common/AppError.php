<?php

namespace App\Common;

use App\Common\AppErrorType;
use Illuminate\Validation\Validator;

class AppError {

    /** @var ErrorType */
    protected $errorCode;

    /** @var string */
    protected $message;

    /** @var array */
    protected $data;

    public static function newInvalidFormat(AppErrorType $errorCode, Validator $validator) {
        $message = '['.$errorCode->message().'], format: '.join(' ', $validator->errors()->all());
        return new AppError($errorCode, $message);
    }

    public static function newNotFound(AppErrorType $errorCode) {
        return new AppError($errorCode, '['.$errorCode->message().'] Not Found');
    }

    public static function new(AppErrorType $errorCode, string $message = '') {
        return new AppError($errorCode, $errorCode->message().$message);
    }

    private function __construct(AppErrorType $errorCode, string $message = '')
    {
        $this->errorCode = $errorCode;
        $this->message = $message;
    }

    public function getErrorCode() {
        return $this->errorCode;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setData(array $data) {
        $this->data = $data;
        return $this;
    }

    public function toArray() {
        $result = [
            'code'      => $this->errorCode->code(),
            'message'   => $this->message,
        ];
        if (!empty($this->data)) {
            $result['data'] = $this->data;
        }
        return $result;
    }


    public function toHttpResponse(int $statusCode = null) {
        return response()->json(self::toArray(), $statusCode ?? 400);
    }
}
