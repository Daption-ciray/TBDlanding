<?php

namespace App\Http\Middleware;

use App\Models\Viewer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureViewerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $viewerId = $request->input('viewer_id') ?? $request->header('X-Viewer-Id');
        $viewerToken = $request->input('viewer_token') ?? $request->header('X-Viewer-Token');

        if (!$viewerId || !$viewerToken) {
            return response()->json([
                'success' => false,
                'error' => 'İzleyici kimlik doğrulaması gerekli.',
            ], 401);
        }

        $viewer = Viewer::where('id', $viewerId)
            ->where('session_token', $viewerToken)
            ->first();

        if (!$viewer) {
            return response()->json([
                'success' => false,
                'error' => 'Geçersiz izleyici oturumu.',
            ], 401);
        }

        $request->merge(['authenticated_viewer' => $viewer]);

        return $next($request);
    }
}
