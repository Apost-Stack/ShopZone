<?php

namespace App\Http\Controllers\Sel\Product;

use App\Common\CommonAdminView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sel\Product\ProductRequest;
use App\Models\Sel\Product\Product;
use App\Models\Sel\Product\ProductImage;
use App\Services\Pictures\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Class ProductController
 *
 * CRUD basé sur des vues pour Product.
 */
class ProductController extends Controller
{
    protected ImageUploadService $images;

    /**
     * ProductController constructor.
     *
     * @param ImageUploadService $images
     */
    public function __construct(ImageUploadService $images)
    {
        $this->images = $images;
    }

    /**
     * Affiche la liste paginée des produits.
     *
     * @return View
     */
    public function index(): View
    {
        $products = Product::with(['category', 'status', 'images'])->paginate(10);
        return view(CommonAdminView::getProductListView(), compact('products'));
    }

    /**
     * Affiche le formulaire de création.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = \App\Models\Sel\Product\Category::all();
        $statuses = \App\Models\Base\Status::all();
        $discounts = \App\Models\Sel\Discount::all();
        return view(CommonAdminView::getProductEditOrCreateView(), compact('categories', 'statuses', 'discounts'));
    }

    /**
     * Enregistre un nouveau produit puis redirige.
     *
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            DB::transaction(function () use ($request, $data, &$product) {
                $product = Product::create($data);

                if ($request->hasFile('images')) {
                    $baseFolder = $request->input('folder', 'exemple');
                    foreach ($request->file('images') as $index => $file) {
                        $path = $this->images->saveImage($file, $baseFolder);
                        $isMain = ($index === 0) ? true : false;
                        $product->images()->create([
                            'path' => $path,
                            'is_main' => $isMain,
                        ]);
                    }
                }

                if ($request->filled('main_image_id')) {
                    $mainId = (int) $request->input('main_image_id');
                    $product->images()->update(['is_main' => false]);
                    $product->images()->where('id', $mainId)->update(['is_main' => true]);
                }
            });

            return redirect()->route('products.index')->with('success', 'Produit créé.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erreur lors de la création du produit.']);
        }
    }

    /**
     * Affiche un produit.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'status', 'images', 'discount']);
        return view(CommonAdminView::getProductShowView(), compact('product'));
    }

    /**
     * Affiche le formulaire d'édition.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $categories = \App\Models\Sel\Product\Category::all();
        $statuses = \App\Models\Base\Status::all();
        $discounts = \App\Models\Sel\Discount::all();
        $product->load('images');
        return view(CommonAdminView::getCategoryEditOrCreateView(), compact('product', 'categories', 'statuses', 'discounts'));
    }

    /**
     * Met à jour un produit puis redirige.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        try {
            $data = $request->validated();

            DB::transaction(function () use ($request, $data, $product) {
                $product->update($data);

                if (!empty($data['remove_image_ids'] ?? null)) {
                    $toRemove = ProductImage::whereIn('id', $data['remove_image_ids'])->where('product_id', $product->getKey())->get();
                    foreach ($toRemove as $img) {
                        $storagePath = preg_replace('#^/storage/#', 'public/', $img->path);
                        Storage::delete($storagePath);
                        $img->delete();
                    }
                }

                if ($request->hasFile('images')) {
                    $baseFolder = $request->input('folder', 'exemple');
                    foreach ($request->file('images') as $file) {
                        $path = $this->images->saveImage($file, $baseFolder);
                        $product->images()->create([
                            'path' => $path,
                            'is_main' => false,
                        ]);
                    }
                }

                if ($request->filled('main_image_id')) {
                    $mainId = (int) $request->input('main_image_id');
                    $product->images()->update(['is_main' => false]);
                    $product->images()->where('id', $mainId)->update(['is_main' => true]);
                } else {
                    if (!$product->images()->where('is_main', true)->exists()) {
                        $first = $product->images()->first();
                        if ($first) {
                            $product->images()->update(['is_main' => false]);
                            $first->update(['is_main' => true]);
                        }
                    }
                }
            });

        return redirect()->route('products.index')->with('success', 'Produit mis à jour.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erreur lors de la mise à jour du produit.']);
        }
    }

    /**
     * Supprime un produit puis redirige.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
       try {
            DB::transaction(function () use ($product) {
                foreach ($product->images as $img) {
                    $storagePath = preg_replace('#^/storage/#', 'public/', $img->path);
                    Storage::delete($storagePath);
                    $img->delete();
                }
                $product->delete();
            });

            return redirect()->route('products.index')->with('success', 'Produit supprimé.');
       } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erreur lors de la suppression du produit.']);
       }
    }
}
