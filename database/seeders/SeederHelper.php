<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

class SeederHelper
{
    public static function insertWithBasicFields(string $tableName, array $arrayData, bool $noEmitError = false) {
       try {
            $count = DB::table($tableName)->max('id') + 1;
            foreach ($arrayData as $data) {
                $basicDatas = [
                    'id' => $count,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                DB::table($tableName)->insert(collect($data)->merge($basicDatas)->toArray());
                $count += 1;
            }
       }
       catch (\Exception $e) {
            if (!$noEmitError) {
                throw $e;
            }
       }
    }

    public static function insertWithId(string $tableName, array $arrayData) {
        $count = DB::table($tableName)->max('id') + 1;
        foreach ($arrayData as $data) {
            $basicDatas = [
                'id' => $count,
            ];

            DB::table($tableName)->insert(collect($data)->merge($basicDatas)->toArray());
            $count += 1;
        }
    }
}