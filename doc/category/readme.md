<?php

namespace App\Models\Sel\Product;

use App\Models\Base\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $primaryKey = 'categoryId';
    protected $fillable = ['name', 'picture', 'status_id'];


    public function status()
    {
    return $this->belongsTo(Status::class);
    }


    public function products()
    {
    return $this->hasMany(Product::class);
    }
}
 
## Picture ici est une image

<?php

namespace App\Services\Pictures;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Sauvegarde une image dans un dossier défini par l'utilisateur + date/heure
     *
     * @param UploadedFile $image
     * @param string $baseFolder  // nom du dossier fourni par l'utilisateur
     * @return string chemin du fichier sauvegardé
     */
    public function saveImage(UploadedFile $image, string $baseFolder = 'exemple')
    {
        $folder = $baseFolder . '/' . now()->format('Y-m-d/H-i-s');

        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

        $path = $image->storeAs("public/$folder", $fileName);

        return Storage::url($path);
    }
}

<?php

namespace App\Http\Controllers\Sel\Product;

use App\Http\Controllers\Controller;
use App\Models\Sel\Product\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
