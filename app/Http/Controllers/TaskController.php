<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidParenthesesRequest;
use Exception;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * 校验括号的有效性
     *
     * @param ValidParenthesesRequest $request
     * @return Response
     */
    public function validParentheses(ValidParenthesesRequest $request): Response
    {
        $string = $request->s;

        $length = strlen($string) / 2;
        for ($i = 0; $i < $length; $i++) {
            $string = str_replace(['()', '[]', '{}'], '', $string);
        }
        $isValid = strlen($string) === 0;

        return $this->success(['is_valid' => $isValid]);
    }

    /**
     * 抛出意外错误
     *
     * @throws Exception
     */
    public function exception()
    {
        throw new Exception('意外错误');
    }
}
