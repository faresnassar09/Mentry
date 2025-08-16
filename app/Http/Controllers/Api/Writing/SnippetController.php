<?php

namespace App\Http\Controllers\Api\Writing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Writing\SnippetRequest;
use App\Http\Resources\Writing\SnippetResource;
use App\Models\Writing\WritingSnippet;
use App\Service\Api\Logging\LoggingService;
use App\Service\Api\ResponseHandelerService;
use App\Service\Api\Writing\SnippetService as UserSnippetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class SnippetController extends Controller
{
    public $objectName = 'User snippet';

    public function __construct(

        public UserSnippetService $userSnippetService,
        public ResponseHandelerService $responseHandelerService,
        public LoggingService $loggingService,

    ) {}

    public function index()
    {

        $snippet =  $this->userSnippetService->getUsersnippets();

        return $this->responseHandelerService->successResponse(

            "{$this->objectName}s retrieved successfully",
            SnippetResource::collection($snippet),
            200
        );
    }

    public function store(SnippetRequest $request)
    {
        try {

            $snippet = $this->userSnippetService->createUserSnippet($request->content);

            $this->loggingService->successLogger($this->objectName, 'created', [

                'snippet_id' => $snippet->id,
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} created successfully",
                new SnippetResource($snippet),
                200
            );
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'creating', [

                'exception_details'  => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Error occurred while saving {$this->objectName}",
                [],
                500
            );
        }
    }

    public function show(WritingSnippet $snippet)
    {

        Gate::authorize('view', $snippet);


        return $this->responseHandelerService->successResponse(

            "{$this->objectName} retrieved successfully",
            new SnippetResource($snippet),
            200

        );
    }

    public function update(SnippetRequest $request, WritingSnippet $snippet)
    {

        Gate::authorize('update', $snippet);
        try {

            $this->userSnippetService->updateUserSnippet($snippet, $request->content);

            $this->loggingService->successLogger($this->objectName, 'updated', [

                'snippet_id' => $snippet->id,
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} updated successfully",
                new SnippetResource($snippet),
                200
            );

        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'updating', [

                'snippet_id' => $snippet->id,
                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Error occurred while updating {$this->objectName}",
                [],
                500
            );
        }
    }

    public function destroy(WritingSnippet $snippet)
    {

        Gate::authorize('delete', $snippet);

        try {

            $this->loggingService->successLogger($this->objectName, 'deleted', [

                'snippet_id' => $snippet->id
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} deleted successfully",
                new SnippetResource($snippet),
                200
            );

        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'deleting', [

                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Error occurred while deleting {$this->objectName}",
                [],
                500
            );
        }
    }
}