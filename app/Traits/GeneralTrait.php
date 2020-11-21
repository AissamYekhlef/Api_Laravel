<?php

namespace App\Traits;

trait GeneralTrait
{

    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($msg="", $errNum="Error")
    {
        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'message' => $msg
        ], 400);
    }


    public function returnSuccessMessage($msg = "", $errNum = "S000")
    {
        return [
            'status' => true,
            'errNum' => $errNum,
            'message' => $msg
        ];
    }

    public function returnData($key, $value, $msg = "")
    {
        return response()->json([
            'status' => true,
            'errNum' => "S000",
            'message' => $msg,
            $key => $value
        ]);
    }


    //////////////////
    public function returnValidationError($code = "E001", $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }


    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input){
        $code = 'NoErrorCode';
        switch($input){
            case "name":
                $code = 'E001';
                break;
            case "password":
                $code = 'E002';
                break;
            case "mobile":
                $code = 'E003';
                break;
            case "id_number":
                $code = 'E004';
                break;  
            case "birth_date":
                $code = 'E005';
                break;
            case "agreement":
                $code = 'E006';
                break;
            case "email":
                $code = 'E007';
                break;
            case "city_id":
                $code = 'E008';
                break;  
        }
        return $code;
    }
}