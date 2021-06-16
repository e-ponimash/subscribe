<?php


namespace App\Http;


use Illuminate\Contracts\Support\Responsable;

class ApiResponse implements Responsable
{
    private $response = [];

    public function setData($data){
        $this->response = [
            'data' => $data
        ];
        return $this;
    }

    public function setError($code, $error, $description){
        $this->response = [
            'code' => $code,
            'error' => $error,
            'description' => $description
        ];
        return $this;
    }

    public function toResponse($request)
    {
        if ($request->input('format')=='xml'){

            return response()->xml($this->response);
        }
        return response()->json($this->response);
    }
}
