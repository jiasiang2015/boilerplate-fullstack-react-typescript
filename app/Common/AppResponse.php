<?php

namespace App\Common;

class AppResponse {
    public static function wrapWithData(mixed $data) {
        return response()->json(['data' => $data]);
    }

    public static function onlySuccessMsg() {
        return response()->json(['data' => 'success']);
    }
}
