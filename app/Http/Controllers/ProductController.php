<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->get();

        return response()->json(
            $items->map(fn (Item $item) => $this->formatItem($item))->values()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity_available' => 'required|integer|min:0',
            'status' => 'nullable|in:available,unavailable',
            'video_link' => 'nullable|url|max:255',

            'gallery_submitted' => 'nullable|boolean',

            'image' => 'nullable|image|max:4096',
            'image_path' => 'nullable|string|max:255',

            'images' => 'nullable|array',
            'images.*' => 'nullable|string|max:255',

            'image_files' => 'nullable|array',
            'image_files.*' => 'nullable|image|max:4096',
        ]);

        $mainImage = $this->resolveMainImage($request);
        $extraImages = $this->collectExtraImages($request);
        $extraImages = $this->removeMainImageFromExtras($extraImages, $mainImage);

        $item = Item::create([
            'item_name' => $validated['item_name'],
            'type' => $validated['type'] ?? $validated['category'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'],

            // Main/head/favorite image.
            'image' => $mainImage,

            // Extra carousel images.
            'images' => $extraImages,

            'quantity_total' => (int) $validated['quantity_available'],
            'quantity_available' => (int) $validated['quantity_available'],
            'status' => $validated['status']
                ?? ((int) $validated['quantity_available'] > 0 ? 'available' : 'unavailable'),
            'video_link' => $validated['video_link'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'item' => $this->formatItem($item->fresh()),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity_available' => 'required|integer|min:0',
            'status' => 'nullable|in:available,unavailable',
            'video_link' => 'nullable|url|max:255',

            'gallery_submitted' => 'nullable|boolean',

            'image' => 'nullable|image|max:4096',
            'image_path' => 'nullable|string|max:255',

            'images' => 'nullable|array',
            'images.*' => 'nullable|string|max:255',

            'image_files' => 'nullable|array',
            'image_files.*' => 'nullable|image|max:4096',
        ]);

        $oldImages = $this->allItemImages($item);

        $mainImage = $this->resolveMainImage($request, $item);
        $extraImages = $this->collectExtraImages($request);
        $extraImages = $this->removeMainImageFromExtras($extraImages, $mainImage);

        $item->update([
            'item_name' => $validated['item_name'],
            'type' => $validated['type'] ?? $validated['category'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'],

            // Main/head/favorite image.
            'image' => $mainImage,

            // Extra carousel images.
            'images' => $extraImages,

            'quantity_total' => (int) $validated['quantity_available'],
            'quantity_available' => (int) $validated['quantity_available'],
            'status' => $validated['status']
                ?? ((int) $validated['quantity_available'] > 0 ? 'available' : 'unavailable'),
            'video_link' => $validated['video_link'] ?? null,
        ]);

        $newImages = $this->allItemImages($item->fresh());

        $this->deleteUnusedStoredImages($oldImages, $newImages);

        return response()->json([
            'success' => true,
            'item' => $this->formatItem($item->fresh()),
        ]);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        foreach ($this->allItemImages($item) as $image) {
            $this->deleteStoredImage($image);
        }

        $item->delete();

        return response()->json(['success' => true]);
    }

    private function formatItem(Item $item): array
    {
        $extraImages = collect($item->images ?? [])
            ->filter()
            ->values();

        return [
            'id' => $item->id,

            'item_name' => $item->item_name,
            'type' => $item->type ?: ($item->category ?: 'Overig'),
            'description' => $item->description,
            'category' => $item->category ?: 'Overig',

            // Raw main image path.
            'image' => $item->image,

            // Public main image URL.
            'image_url' => $this->mediaUrl($item->image),

            // Raw extra image paths.
            'images' => $extraImages->all(),

            // Public extra image URLs.
            'images_urls' => $extraImages
                ->map(fn ($image) => $this->mediaUrl($image))
                ->filter()
                ->values()
                ->all(),

            'quantity_total' => $item->quantity_total,
            'quantity_available' => $item->quantity_available,
            'status' => $item->status,

            'video_link' => $item->video_link,

            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }

    private function resolveMainImage(Request $request, ?Item $item = null): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('items', 'public');
        }

        if ($request->filled('image_path')) {
            return $this->normalizeImagePath($request->input('image_path'));
        }

        // Important:
        // If the gallery was submitted but no main image exists,
        // it means the user removed all images.
        if ($request->boolean('gallery_submitted')) {
            return null;
        }

        return $item?->image;
    }

    private function collectExtraImages(Request $request): array
    {
        $images = collect($request->input('images', []))
            ->map(fn ($image) => $this->normalizeImagePath($image))
            ->filter()
            ->values()
            ->all();

        if ($request->hasFile('image_files')) {
            foreach ($request->file('image_files') as $file) {
                $images[] = $file->store('items', 'public');
            }
        }

        return collect($images)
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function removeMainImageFromExtras(array $extraImages, ?string $mainImage): array
    {
        if (!$mainImage) {
            return collect($extraImages)
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        return collect($extraImages)
            ->filter(fn ($image) => $image !== $mainImage)
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeImagePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $path = trim($path);

        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/storage/')) {
            return substr($path, strlen('/storage/'));
        }

        if (str_starts_with($path, 'storage/')) {
            return substr($path, strlen('storage/'));
        }

        if (str_starts_with($path, '/images/')) {
            return ltrim($path, '/');
        }

        return ltrim($path, '/');
    }

    private function mediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/storage/')) {
            return $path;
        }

        if (str_starts_with($path, '/images/')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return '/' . $path;
        }

        return Storage::disk('public')->url($path);
    }

    private function allItemImages(Item $item): array
    {
        return collect([
            $item->image,
            ...($item->images ?? []),
        ])
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function deleteUnusedStoredImages(array $oldImages, array $newImages): void
    {
        foreach ($oldImages as $oldImage) {
            if (!in_array($oldImage, $newImages, true)) {
                $this->deleteStoredImage($oldImage);
            }
        }
    }

    private function deleteStoredImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        // Only delete files uploaded into storage/app/public/items.
        // Do not delete seeded public/images files or external URLs.
        if (str_starts_with($path, 'items/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
