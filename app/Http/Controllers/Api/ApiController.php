<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\ActionException;
use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\NotOwnerException;
use App\Exceptions\Api\UnknownException;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    protected $compacts;
    protected function jsonRender($data = [])
    {
        $this->compacts['code'] = 200;
        $compacts = array_merge($data, $this->compacts);

        return response()->json($compacts);
    }
    protected function getData(callable $callback, $code = 500)
    {
        try {
            if (is_callable($callback)) {
                call_user_func_array($callback, []);
            }
        } catch (Exception $e) {
            throw new UnknownException($e->getMessage(), $e->getCode());
        }
        $this->compacts['description'] = 'success';

        return $this->jsonRender();
    }

    protected function doAction(callable $callback, $action = null, $code = 500)
    {
        DB::beginTransaction();
        try {
            if (is_callable($callback)) {
                call_user_func_array($callback, []);
            }

            DB::commit();
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            throw new NotFoundException();
        } catch (NotOwnerException $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            throw new NotOwnerException();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            if (in_array($action, config('settings.action_exception_method'))) {
                throw new ActionException($action);
            }

            throw new UnknownException($e->getMessage(), $e->getCode());
        }

        return $this->jsonRender();
    }
}
