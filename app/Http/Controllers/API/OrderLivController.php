<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatus;
use App\Repositories\OrderLivRepository;
use App\Http\Resources\OrderLivResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderLivRequest; // Import the Store Form Request
use App\Http\Requests\UpdateOrderLivRequest; // Import the Update Form Request
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait
use App\Models\OrderLiv; // Import OrderLiv model

class OrderLivController extends Controller
{
    use AuthorizesRequests; // Use the trait

    protected $orderLivRepo;

    // تهيئة الـ Repository في الـ Constructor
    public function __construct(OrderLivRepository $orderLivRepo)
    {
        $this->orderLivRepo = $orderLivRepo;
    }

    // استرجاع جميع الطلبات
    public function index()
    {
        $this->authorize('viewAny', OrderLiv::class); // Add authorization check

        $orders = $this->orderLivRepo->all();

        // استخدام Collection Resource لتنسيق الاستجابة لجميع الطلبات
        return OrderLivResource::collection($orders);
    }

    // تخزين الطلب
    public function store(StoreOrderLivRequest $request) // Use the Form Request
    {
        $this->authorize('create', OrderLiv::class); // Add authorization check

        $validated = $request->validated();

        $orderLiv = $this->orderLivRepo->create($validated);

        // استخدام Resource لتنسيق الاستجابة
        return new OrderLivResource($orderLiv);
    }

    // تحديث الطلب
    public function update(UpdateOrderLivRequest $request, OrderLiv $orderLiv) // Use Route Model Binding
    {
        $this->authorize('update', $orderLiv); // Add authorization check

        // Route Model Binding handles finding the orderLiv or returning 404 automatically

        $validated = $request->validated();

        $orderLiv = $this->orderLivRepo->update($orderLiv->id, $validated); // Use model ID for repository update

        // استخدام Resource لتنسيق الاستجابة
        return new OrderLivResource($orderLiv);
    }

    // حذف الطلب
    public function destroy(OrderLiv $orderLiv) // Use Route Model Binding
    {
        $this->authorize('delete', $orderLiv); // Add authorization check

        // Route Model Binding handles finding the orderLiv or returning 404 automatically

        $success = $this->orderLivRepo->delete($orderLiv->id); // Use model ID for repository delete

        if (!$success) {
            // This case might not be reached if Route Model Binding finds the model,
            // but keeping the check from the original code.
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(null, 204);
    }
}
