<?php

namespace PHP_Var;

class PHP_Var
{
    public static $arr = array();
    public static $js_arr = array();

    public static function set($key, $value)
    {
        self::$arr[$key] = $value;
        self::$js_arr[$key] = self::sanitize($value);
    }

    public static function get($key)
    {
        return self::generateJsVar($key, self::$js_arr[$key]);
    }

    public static function all()
    {
        $output = array();
        foreach (self::$js_arr as $key => $value) {
             $output[] = self::generateJsVar($key, $value);
        }

        return implode('', $output);
    }

    private function generateJsVar($key, $value)
    {
        return 'var ' . $key . ' = ' . $value . ';';
    }

    private function sanitize($value)
    {
        $type = gettype($value);
        switch ($type) {
        case 'integer':
            $value = (int)$value;
            break;
        case 'double':
            $value = (double)$value;
            break;
        case 'string':
            $value = "'" . $value . "'";
            break;
        case 'array':
            if (self::isAssoc($value)) {
                $tempObj = new \StdClass();
                foreach ($value as $key => $val) {
                    $tempObj->key = $val;
                }
                $value = "JSON.parse(" . json_encode($value) . ")";
            } else {
                $tempOutput = array();
                foreach ($value as $val) {
                    $tempOutput[] = $val;
                }
                $value = '[' . implode(',', $tempOutput) . ']';
            }
            break;
        case 'boolean':
            $value = $value ? 1 : 0;
            break;
        case 'NULL':
            $value = 'undefined';
            break;
        case 'object':
            $value = "JSON.parse(" . json_encode($value) . ")";
            break;
        default:
            break;
        }

        return $value;
    }

    private function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
