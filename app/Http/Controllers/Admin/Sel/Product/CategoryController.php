<?php

namespace App\Http\Controllers\Admin\Sel\Product;

use App\Common\CommonAdminView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sel\Product\CategoryRequest;
use App\Models\Sel\Product\Category;
use App\Services\Pictures\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Class CategoryController
 *
 * CRUD basé sur des vues pour Category.
 */
class CategoryController extends Controller
{
    protected ImageUploadService $images;

    /**
     * CategoryController constructor.
     *
     * @param ImageUploadService $images
     */
    public function __construct(ImageUploadService $images)
    {
        $this->images = $images;
    }

    /**
     * Affiche la liste paginée des catégories.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = Category::with(['status', 'products'])->paginate(10);
        return view(CommonAdminView::getCategoryListView(), compact('categories'));
    }

    /**
     * Affiche le formulaire de création.
     *
     * @return View
     */
    public function create(): View
    {
        $statuses = \App\Models\Base\Status::all();
        return view(CommonAdminView::getCategoryEditOrCreateView(),compact('statuses'));
    }

    /**
     * Enregistre une nouvelle catégorie puis redirige.
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('picture')) {
                $baseFolder = $request->input('folder', 'exemple');
                $data['picture'] = $this->images->saveImage($request->file('picture'), $baseFolder);
            }

            Category::create($data);

            return redirect()->route('categories.index')->with('success', 'Catégorie créée.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erreur lors de la création de la catégorie.']);
        }
    }

    /**
     * Affiche une catégorie.
     *
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        $category->load(['status', 'products']);
        return view(CommonAdminView::getCategoryShowView(), compact('category'));
    }

    /**
     * Affiche le formulaire d'édition.
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        $statuses = \App\Models\Base\Status::all();
        return view(CommonAdminView::getCategoryEditOrCreateView(), compact('category', 'statuses'));
    }

    /**
     * Met à jour une catégorie puis redirige.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('picture')) {
                if ($category->picture) {
                    $storagePath = preg_replace('#^/storage/#', 'public/', $category->picture);
                    Storage::delete($storagePath);
                }
                $baseFolder = $request->input('folder', 'exemple');
                $data['picture'] = $this->images->saveImage($request->file('picture'), $baseFolder);
            }

            $category->update($data);

            return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erreur lors de la mise à jour de la catégorie.']);
        }
    }

    /**
     * Supprime une catégorie puis redirige.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            if ($category->picture) {
                $storagePath = preg_replace('#^/storage/#', 'public/', $category->picture);
                Storage::delete($storagePath);
            }

            $category->delete();

            return redirect()->route('categories.index')->with('success', 'Catégorie supprimée.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erreur lors de la suppression de la catégorie.']);
        }
    }
}
