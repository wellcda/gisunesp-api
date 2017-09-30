<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait RestControllerTrait
{

    /**
     * Manage index request
     * @param Request $request
     * @return type
     */
    public function index()
    {
        $m = self::MODEL;
        $data = $m::all();
        return $this->listResponse($data);
    }

    /**
     * Manage show profile request
     * @param integer $id
     * @return type
     */
    public function show($id)
    {
        $m = self::MODEL;
        $data = $m::find($id);
        return $this->showResponse($data);
    }

    /**
     * Manage store request
     * @param Request $request
     * @return type
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $m = self::MODEL;
        try {
            // $v = \Validator::make($request->all(), $this->validationRules);
            // if ($v->fails()) {
            //     throw new \Exception("ValidationException");
            // }
            $data = $m::create($request->all());
            return $this->createdResponse($data);
        } catch(\Exception $ex) {
            // $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            $data = ['exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }

    /**
     * Manage update request
     * @param type $id
     * @param Request $request
     * @return type
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $m = self::MODEL;
        if (!$data = $m::find($id)) {
            return $this->notFoundResponse();
        }
        try {
            $v = \Validator::make($request->all(), $this->validationPatchRules);
            if($v->fails()) {
                throw new \Exception("ValidationException");
            }
            $data->fill($request->all());
            $data->save();
            return $this->showResponse($data);
        } catch(\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }

    /**
     * Manage delete request
     * @param type $id
     * @return type
     */
    public function destroy($id)
    {
        $m = self::MODEL;
        if(!$data = $m::find($id)) {
            return $this->notFoundResponse();
        }

        $data->delete();
        return $this->deletedResponse();
    }

    /**
     * Show json individual response
     * @param type $data
     * @return type
     */
    protected function createdResponse($data)
    {
        $response = [
            'code'   => 201,
            'status' => 'success',
            'data'   => $data
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Show json individual response
     * @param type $data
     * @return type
     */
    protected function showResponse($data)
    {
        $response = [
            'code'   => 200,
            'status' => 'success',
            'data'   => $data
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * List json individual response with paginate
     * @param type $data
     * @return type
     */
    protected function listResponse($data)
    {
        $response = [
            'code'   => 200,
            'status' => 'success',
            'data'   => $data,
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Not found response
     * @return type
     */
    protected function notFoundResponse($data = null)
    {
        $response = [
            'code'    => 404,
            'status'  => 'error',
            'data'    => $data === null ? 'Resource Not Found' : $data,
            'message' => 'Not Found'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Deleted response
     * @return type
     */
    protected function deletedResponse()
    {
        $response = [
            'code'    => 200,
            'status'  => 'success',
            'data'    => [],
            'message' => 'Resource deleted'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Accepted response
     * @return type
     */
    protected function acceptedResponse()
    {
        $response = [
            'code'    => 202,
            'status'  => 'success',
            'data'    => [],
            'message' => 'Accepted'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Client error response
     * @param type $data
     * @return type
     */
    protected function clientErrorResponse($data)
    {
        $response = [
            'code'    => 422,
            'status'  => 'error',
            'data'    => $data,
            'message' => 'Unprocessable entity'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Client error response
     * @param type $data
     * @return type
     */
    protected function unauthorizedErrorResponse($data)
    {
        $response = [
            'code'    => 401,
            'status'  => 'error',
            'data'    => $data,
            'message' => 'Unauthorized'
        ];
        return response()->json($response, $response['code']);
    }

}
