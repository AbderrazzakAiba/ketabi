<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\Copy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait
use App\Http\Resources\BookResource; // Import BookResource
use App\Http\Requests\StoreBookRequest; // Import the Store Form Request
use App\Http\Requests\UpdateBookRequest; // Import the Update Form Request
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    use AuthorizesRequests; // Use the trait

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Book::class);

        $books = Book::all();
        return BookResource::collection($books);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book) // Use Route Model Binding
    {
        $this->authorize('view', $book);

        return new BookResource($book);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request) // Use the Form Request
    {
        $this->authorize('create', Book::class);

        $validated = $request->validated(); // Validation is handled by the Form Request

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images/books', 'public');
            $imagePath = Storage::url($imagePath);
        }

        $pdfPath = null;
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('public/pdfs/books', 'public');
            $pdfPath = Storage::url($pdfPath);
        }

        // محاولة إيجاد كتاب بنفس العنوان
        $book = Book::where('title', $validated['title'])->first();

        if ($book) {
            // الكتاب موجود → نضيف النسخ المطلوبة
            for ($i = 0; $i < $validated['quantite']; $i++) { // Use quantite for number of copies
                Copy::create([
                    'id_book' => $book->id_book, // Correct foreign key name
                    'etat_copy_liv' => \App\Enums\CopyStatus::AVAILABLE, // Set default status
                    'date_achat' => now(), // Set purchase date
                ]);
            }

            return response()->json([
                'message' => "تمت إضافة {$validated['quantite']} نسخة جديدة للكتاب الموجود.",
                'book' => new BookResource($book), // Return BookResource
            ], 201);
        } else {
            // الكتاب غير موجود → ننشئه ثم نضيف النسخ
            $book = Book::create([
                'title' => $validated['title'],
                'auteur' => $validated['auteur'],
                'num_page' => $validated['num_page'],
                'num_RGE' => $validated['num_RGE'],
                'category' => $validated['category'],
                'quantite' => $validated['quantite'], // Store total quantity
                'etat_liv' => $validated['etat_liv'] ?? \App\Enums\BookStatus::AVAILABLE, // Set default status
                'id_editor' => $validated['id_editor'],
                'image_path' => $imagePath,
                'pdf_path' => $pdfPath,
            ]);

            for ($i = 0; $i < $validated['quantite']; $i++) { // Use quantite for number of copies
                Copy::create([
                    'id_book' => $book->id_book, // Correct foreign key name
                    'etat_copy_liv' => \App\Enums\CopyStatus::AVAILABLE, // Set default status
                    'date_achat' => now(), // Set purchase date
                ]);
            }

            return response()->json([
                'message' => "تم إنشاء كتاب جديد مع {$validated['quantite']} نسخة.",
                'book' => new BookResource($book), // Return BookResource
            ], 201);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book) // Use Form Request and Route Model Binding
    {
        // Authorization and validation are handled by the Form Request
        $validated = $request->validated();

        $book->update($validated);

        // Note: Updating quantity here might require creating/deleting copies.
        // This logic is not implemented here and might be needed depending on requirements.

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book) // Use Route Model Binding
    {
        $this->authorize('delete', $book);

        // Optional: Check if there are any active borrows for this book's copies
        if ($book->copies()->whereHas('borrows', function ($query) {
            $query->where('status', \App\Enums\BorrowStatus::ACTIVE);
        })->exists()) {
            return response()->json(['message' => 'لا يمكن حذف الكتاب لوجود نسخ مستعارة حاليًا.'], 400);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully.']);
    }
}
