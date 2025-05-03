<?php

namespace App\Repositories;

use App\Models\OrderLiv;
use Illuminate\Database\Eloquent\Collection;

class OrderLivRepository
{
    // استرجاع جميع الطلبات
    public function all(): Collection
    {
        return OrderLiv::all();
    }

    // استرجاع طلب معين حسب المعرف
    public function find($id): ?OrderLiv
    {
        return OrderLiv::find($id);
    }

    // إنشاء طلب جديد
    public function create(array $data): OrderLiv
    {
        return OrderLiv::create($data);
    }

    // تحديث الطلب
    public function update($id, array $data): ?OrderLiv
    {
        $orderLiv = OrderLiv::find($id);
        if ($orderLiv) {
            $orderLiv->update($data);
        }
        return $orderLiv;
    }

    // حذف الطلب
    public function delete($id): bool
    {
        $orderLiv = OrderLiv::find($id);
        if ($orderLiv) {
            return $orderLiv->delete();
        }
        return false;
    }
}
