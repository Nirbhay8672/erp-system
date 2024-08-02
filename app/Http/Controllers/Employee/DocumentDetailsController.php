<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeDocumentDetailFormRequest;
use App\Models\EmployeeDocumentDetails;
use App\Services\EmployeeDocumentsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentDetailsController extends Controller
{
    public function index(EmployeeDocumentsService $employeeDocumentsService, string $employee_id) : JsonResponse
    {
        return response()->json([
            'message' => 'Record fetch.',
            'data' => $employeeDocumentsService->fetchAllTypeOfDocuments($employee_id)
        ]);
    }

    public function updateDocumentDetails(EmployeeDocumentDetailFormRequest $request, EmployeeDocumentsService $employeeDocumentsService): JsonResponse
    {
        foreach ($request->id_proof_documents ?? [] as $document) {
            $employeeDocumentsService->createDocumentRecord($request->employee_id, $document, 'id_proof');
        }

        foreach ($request->other_documents ?? [] as $document) {
            $employeeDocumentsService->createDocumentRecord($request->employee_id, $document, 'other_documents');
        }

        if($request->has('address_proof_documents')) {
            $employeeDocumentsService->createDocumentRecord($request->employee_id, $request->address_proof_documents, 'address_proof');
        }

        $employeeDocumentsService->removeFiles($request->deleted_documents ?? []);

        return response()->json([
            'message' => 'Document details update Successfully.',
            'data' => [
                'employee_document_details' => $employeeDocumentsService->fetchAllTypeOfDocuments($request->employee_id)
            ]
        ]);
    }

    function getFile(EmployeeDocumentDetails $document): StreamedResponse
    {
        return Storage::download($document->file_path, $document->file_name.'.'.$document->file_extension);
    }

    function deleteFile(EmployeeDocumentDetails $document, string $employee_id, EmployeeDocumentsService $employeeDocumentsService): JsonResponse
    {
        // $employeeDocumentsService->removeFiles([$document->id]);

        return response()->json([
            'message' => 'File deleted successfully.',
            'data' => $employeeDocumentsService->fetchAllTypeOfDocuments($employee_id)
        ]);
    }
}