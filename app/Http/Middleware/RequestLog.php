<?php

namespace App\Http\Middleware;

use App\Models\RequestLog as RequestLogModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $log = [
            'path'    => $request->path(),
            'method'  => $request->method(),
            'query'   => $request->query(),
            'ip'      => $request->ips(),
            'url'     => $request->url(),
            'headers' => $request->header(),
        ];

        if ($request->file()) {
            // 文件内容不做日志记录，使用<file>做标识
            $log['request_body'] = '<file>';
        } else {
            $log['request_body'] = $request->all();
        }

        // 获取并设置 request_id
        $requestId = $request->headers->get('request_id', (string)Str::uuid());
        $request->headers->set('request_id', $requestId);
        $request->headers->set('Accept', 'application/json');

        // 将 request_id 传入日志上下文
        Log::withContext([
            'request_id' => $requestId
        ]);

        $log['request_id'] = $requestId;
        $model = RequestLogModel::query()->create($log);

        $response = $next($request);

        $model->response_body = $response->getOriginalContent();
        $model->save();

        return $response;
    }
}
