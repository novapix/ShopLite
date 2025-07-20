<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\BrandImage;
use App\Models\ProductImage;
use App\Services\SupabaseAssetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    public function __construct(
        private SupabaseAssetService $assetService
    ) {}

    /**
     * Upload customer avatar
     */
    public function uploadCustomerAvatar(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,gif,webp|max:5120', // 5MB max
            'customer_id' => 'required|integer|exists:customers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $avatar = $this->assetService->uploadCustomerAvatar(
                $request->file('file'),
                $request->input('customer_id')
            );

            return response()->json([
                'success' => true,
                'avatar' => [
                    'id' => $avatar->id,
                    'url' => $avatar->avatar_url,
                    'thumbnail_url' => $avatar->thumbnail_url,
                    'size' => $avatar->formatted_size,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload brand image
     */
    public function uploadBrandImage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,gif,webp|max:5120', // 5MB max
            'brand_id' => 'required|integer|exists:brands,id',
            'type' => 'required|in:logo,banner,thumbnail'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $brandImage = $this->assetService->uploadBrandImage(
                $request->file('file'),
                $request->input('brand_id'),
                $request->input('type')
            );

            return response()->json([
                'success' => true,
                'image' => [
                    'id' => $brandImage->id,
                    'url' => $brandImage->url,
                    'type' => $brandImage->type,
                    'size' => $brandImage->formatted_size,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload product image
     */
    public function uploadProductImage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,gif,webp|max:5120', // 5MB max
            'product_id' => 'required|integer', // Will be used when Product model exists
            'is_primary' => 'boolean',
            'alt_text' => 'string|nullable|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $productImage = $this->assetService->uploadProductImage(
                $request->file('file'),
                $request->input('product_id'),
                $request->boolean('is_primary'),
                $request->input('alt_text')
            );

            return response()->json([
                'success' => true,
                'image' => [
                    'id' => $productImage->id,
                    'url' => $productImage->url,
                    'thumbnail_url' => $productImage->thumbnail_url,
                    'is_primary' => $productImage->is_primary,
                    'sort_order' => $productImage->sort_order,
                    'size' => $productImage->formatted_size,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload multiple product images
     */
    public function uploadProductImages(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array|max:10', // Max 10 images
            'files.*' => 'image|mimes:jpeg,png,gif,webp|max:5120', // 5MB max per file
            'product_id' => 'required|integer' // Will be used when Product model exists
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $productImages = $this->assetService->uploadProductImages(
                $request->file('files'),
                $request->input('product_id')
            );

            $imagesData = collect($productImages)->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->url,
                    'thumbnail_url' => $image->thumbnail_url,
                    'is_primary' => $image->is_primary,
                    'sort_order' => $image->sort_order,
                    'size' => $image->formatted_size,
                ];
            });

            return response()->json([
                'success' => true,
                'images' => $imagesData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an asset
     */
    public function deleteAsset(Request $request, string $type, int $id): JsonResponse
    {
        $validator = Validator::make(['type' => $type], [
            'type' => 'required|in:avatar,brand,product'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $deleted = $this->assetService->deleteAsset($type, $id);

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Asset deleted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete asset'
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get asset details
     */
    public function getAsset(string $type, int $id): JsonResponse
    {
        try {
            switch ($type) {
                case 'avatar':
                    $asset = Avatar::findOrFail($id);
                    return response()->json([
                        'success' => true,
                        'asset' => [
                            'id' => $asset->id,
                            'url' => $asset->avatar_url,
                            'thumbnail_url' => $asset->thumbnail_url,
                            'size' => $asset->formatted_size,
                            'created_at' => $asset->created_at,
                        ]
                    ]);

                case 'brand':
                    $asset = BrandImage::with('brand')->findOrFail($id);
                    return response()->json([
                        'success' => true,
                        'asset' => [
                            'id' => $asset->id,
                            'url' => $asset->url,
                            'type' => $asset->type,
                            'brand_name' => $asset->brand->name,
                            'size' => $asset->formatted_size,
                            'created_at' => $asset->created_at,
                        ]
                    ]);

                case 'product':
                    $asset = ProductImage::findOrFail($id);
                    return response()->json([
                        'success' => true,
                        'asset' => [
                            'id' => $asset->id,
                            'url' => $asset->url,
                            'thumbnail_url' => $asset->thumbnail_url,
                            'is_primary' => $asset->is_primary,
                            'sort_order' => $asset->sort_order,
                            'alt_text' => $asset->alt_text,
                            'size' => $asset->formatted_size,
                            'created_at' => $asset->created_at,
                        ]
                    ]);

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid asset type'
                    ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Asset not found'
            ], 404);
        }
    }
}
