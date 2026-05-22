<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $status = $request->query("status");
        $query = Customers::query();
        if ($status !== null) {
            if (!in_array($status, ["active", "inactive"], true)) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation failed",
                    "errors" => [
                        "status" => ["The selected status is invalid."],
                    ],
                ], 422);
            }
            $query->where("status", $status === "active");
        }
        $customers = $query->latest()->get();
        return response()->json([
            "success" => true,
            "message" => "Customers retrieved successfully",
            "data" => $customers,
        ]);
    }
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "price" => ["required", "integer", "min:0"],
            "description" => ["nullable", "string"],
            "status" => ["nullable", "boolean"],
        ]);
        $data["status"] = $data["status"] ?? true;
        $customer = Customers::query()->create($data);
        return response()->json([
            "success" => true,
            "message" => "Customer created successfully",
            "data" => $customer,
        ], 201);
    }
    public function show(int $customer): JsonResponse
    {
        $customer = Customers::query()->find($customer);
        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "Customer not found",
                "errors" => [],
            ], 404);
        }
        return response()->json([
            "success" => true,
            "message" => "Customer retrieved successfully",
            "data" => $customer,
        ]);
    }
    public function update(Request $request, int $customer): JsonResponse
    {
        $customer = Customers::query()->find($customer);
        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "Customers not found",
                "errors" => [],
            ], 404);
        }
        $data = $request->validate([
            "name" => ["sometimes", "string"],
            "price" => ["sometimes", "integer", "min:0"],
            "description" => ["nullable", "string"],
            "status" => ["nullable", "boolean"],
        ]);
        $customer->update($data);
        return response()->json([
            "success" => true,
            "message" => "Customer updated successfully",
            "data" => $customer,
        ]);
    }
    public function destroy(int $customer): JsonResponse
    {
        $customer = Customers::query()->find($customer);
        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "Customer not found",
                "errors" => [],
            ], 404);
        }
        if ($customer->subscriptions()->exists()) {
            return response()->json([
                "success" => false,
                "message" => "customer cannot be deleted because it has subscriptions",
                "errors" => [],
            ], 422);
        }
        $customer->delete();
        return response()->json([
            "success" => true,
            "message" => "customer deleted successfully",
            "data" => null,
        ]);
    }
    public function activate(int $customer): JsonResponse
    {
        $customer = Customers::query()->find($customer);
        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "customer not found",
                "errors" => [],
            ], 404);
        }
        $customer->update(["status" => true]);
        return response()->json([
            "success" => true,
            "message" => "customer activated successfully",
            "data" => $customer,
        ]);
    }
    public function deactivate(int $customer): JsonResponse
    {
        $customer = Customers::query()->find($customer);
        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "customer not found",
                "errors" => [],
            ], 404);
        }
        $customer->update(["status" => false]);
        return response()->json([
            "success" => true,
            "message" => "customer deactivated successfully",
            "data" => $customer,
        ]);
    }
}
