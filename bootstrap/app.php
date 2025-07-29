<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;






return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:[
            
       __DIR__.'/../routes/web.php',
       __DIR__.'/../routes/study.php',
       __DIR__.'/../routes/reading.php',
       __DIR__.'/../routes/writing.php',
       __DIR__.'/../routes/users.php',


    ], 

    api: [
        __DIR__.'/../routes/api.php', // ← ضيف ملف الـ API هنا
    ],
    
       
        commands: __DIR__.'/../routes/console.php',
        
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->api(prepend: [

            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                        
        ]); 
    
        $middleware->encryptCookies([
            'lang',
        ]);
    
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        $exceptions->render(function (NotFoundHttpException $e,Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Record not found in database.'
                ], 404);
            }
        });

    })->create();
