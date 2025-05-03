<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Editor;
use App\Http\Resources\EditorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Http\Requests\StoreEditorRequest; // Import the Form Request
use App\Http\Requests\UpdateEditorRequest; // Import the Update Form Request
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait

class EditorController extends Controller
{
    use AuthorizesRequests; // Use the trait

    /**
     * عرض جميع دور النشر.
     */
    public function index()
    {
        $this->authorize('viewAny', Editor::class); // Add authorization check

        try {
            $editors = Editor::all();

            // استخدام EditorResource لتنسيق الاستجابة
            return EditorResource::collection($editors);

        } catch (Exception $e) {
            Log::error('Failed to fetch editors: ' . $e->getMessage());

            return response()->json([
                'message' => 'حدث خطأ أثناء جلب دور النشر.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * عرض تفاصيل دار نشر واحدة.
     */
    public function show(Editor $editor) // Use Route Model Binding
    {
        $this->authorize('view', $editor); // Add authorization check

        // Route Model Binding handles finding the editor or returning 404 automatically

        // استخدام EditorResource لتنسيق الاستجابة
        return new EditorResource($editor);
    }

    /**
     * إنشاء دار نشر جديدة.
     */
    public function store(StoreEditorRequest $request)
    {
        $this->authorize('create', Editor::class); // Add authorization check

        $validated = $request->validated();

        try {
            $editor = Editor::create($validated);

            // استخدام EditorResource لتنسيق الاستجابة
            return new EditorResource($editor);

        } catch (Exception $e) {
            Log::error('Failed to create editor: ' . $e->getMessage());

            return response()->json([
                'message' => 'حدث خطأ أثناء إنشاء دار النشر.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * تعديل بيانات دار نشر موجودة.
     */
    public function update(UpdateEditorRequest $request, Editor $editor) // Use Route Model Binding
    {
        $this->authorize('update', $editor); // Add authorization check

        // Route Model Binding handles finding the editor or returning 404 automatically

        $validated = $request->validated();

        try {
            $editor->update($validated);

            // استخدام EditorResource لتنسيق الاستجابة
            return new EditorResource($editor);

        } catch (Exception $e) {
            Log::error('Failed to update editor: ' . $e->getMessage());

            return response()->json([
                'message' => 'حدث خطأ أثناء تحديث دار النشر.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف دار نشر.
     */
    public function destroy(Editor $editor) // Use Route Model Binding
    {
        $this->authorize('delete', $editor); // Add authorization check

        // Route Model Binding handles finding the editor or returning 404 automatically

        if ($editor->books()->exists()) {
            return response()->json([
                'message' => 'لا يمكن حذف دار النشر لأنها مرتبطة بكتب موجودة.'
            ], 400);
        }

        try {
            $editor->delete();

            return response()->json([
                'message' => 'تم حذف دار النشر بنجاح.'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete editor: ' . $e->getMessage());

            return response()->json([
                'message' => 'حدث خطأ أثناء حذف دار النشر.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
