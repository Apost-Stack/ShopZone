# README - Category

## Description

Ce README décrit le fonctionnement du CRUD "Category" (vues + redirections) et comment l'utiliser dans les vues Blade.

## Routes

Utiliser les routes resource :

```php
Route::resource('categories', CategoryController::class);
```

## Contrôleur

Le `CategoryController` fournit :

* `index()` : liste paginée (vue `sel.product.categories.index`)
* `create()` : formulaire de création (vue `sel.product.categories.create`)
* `store()` : validation et sauvegarde, upload d'image, puis redirection
* `show()` : affichage détaillé (vue `sel.product.categories.show`)
* `edit()` : formulaire d'édition (vue `sel.product.categories.edit`)
* `update()` : mise à jour, remplacement d'image si fourni, suppression de l'ancienne image, puis redirection
* `destroy()` : suppression (supprime aussi l'image si présente) puis redirection

## Validation

Utiliser `CategoryRequest` avec ces règles minimales :

* `name` : required|string|max:255
* `picture` : nullable|image|max:5120
* `status_id` : nullable|exists\:statuses,id
* `folder` : sometimes|string|max:255

## Upload d'image

Le service `ImageUploadService::saveImage(UploadedFile $image, string $baseFolder = 'exemple')` crée un dossier basé sur `exemple/Y-m-d/H-i-s` et renvoie l'URL publique (via `Storage::url`). Dans le contrôleur :

* Lors de `store`/`update`, si `picture` est fournie, appeler le service avec la valeur `folder` issue du formulaire (ou `exemple` par défaut).
* Lors de `update`/`destroy`, supprimer l'ancien fichier du disque en transformant l'URL retournée (`/storage/...`) en chemin `public/...` pour `Storage::delete()`.

## Exemples Blade

### `sel/product/categories/index.blade.php`

```blade
@extends('layouts.app')

@section('content')
<h1>Liste des catégories</h1>

<a href="{{ route('categories.create') }}">Créer une catégorie</a>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table>
  <thead>
    <tr><th>#</th><th>Nom</th><th>Image</th><th>Status</th><th>Actions</th></tr>
  </thead>
  <tbody>
    @foreach($categories as $cat)
      <tr>
        <td>{{ $cat->getKey() }}</td>
        <td>{{ $cat->name }}</td>
        <td>
          @if($cat->picture)
            <img src="{{ $cat->picture }}" alt="{{ $cat->name }}" style="height:60px">
          @endif
        </td>
        <td>{{ optional($cat->status)->name }}</td>
        <td>
          <a href="{{ route('categories.show', $cat) }}">Voir</a>
          <a href="{{ route('categories.edit', $cat) }}">Éditer</a>
          <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{ $categories->links() }}
@endsection
```

### `sel/product/categories/create.blade.php` (et edit similaire)

```blade
@extends('layouts.app')

@section('content')
<h1>Créer une catégorie</h1>

<form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div>
    <label for="name">Nom</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}">
    @error('name')<div>{{ $message }}</div>@enderror
  </div>

  <div>
    <label for="picture">Image</label>
    <input type="file" name="picture" id="picture">
    @error('picture')<div>{{ $message }}</div>@enderror
  </div>

  <div>
    <label for="folder">Dossier (optionnel)</label>
    <input type="text" name="folder" id="folder" value="{{ old('folder', 'exemple') }}">
  </div>

  <div>
    <label for="status_id">Status</label>
    <select name="status_id" id="status_id">
      <option value="">--</option>
      @foreach($statuses as $s)
        <option value="{{ $s->id }}">{{ $s->name }}</option>
      @endforeach
    </select>
  </div>

  <button type="submit">Enregistrer</button>
</form>
@endsection
```

### `sel/product/categories/edit.blade.php`

* Même formulaire que `create` mais :

  * méthode `POST` + `@method('PUT')`
  * remplir `value` avec `$category->name`, et afficher l'image existante

---

# README - Product

## Description

Ce README décrit le CRUD "Product" (vues + redirections) et la gestion de plusieurs images (`ProductImage`) associées à un produit.

## Routes

Utiliser les routes resource :

```php
Route::resource('products', ProductController::class);
```

## Contrôleur

Le `ProductController` fournit :

* `index()` : liste paginée (vue `sel.product.products.index`)
* `create()` : formulaire de création (vue `sel.product.products.create`)
* `store()` : validation, création, upload de plusieurs images (le premier fichier devient `is_main=true` par défaut)
* `show()` : affichage détaillé (vue `sel.product.products.show`)
* `edit()` : formulaire d'édition (vue `sel.product.products.edit`)
* `update()` : mise à jour, suppression d'images sélectionnées, ajout d'images, gestion `is_main`
* `destroy()` : suppression du produit et de ses images physiques

## Validation

Utiliser `ProductRequest` avec (extraits) :

* `name`, `quantity`, `category_id`, `price` etc.
* `images` : array of files
* `images.*` : image|max:5120
* `remove_image_ids` : array d'ids à supprimer
* `main_image_id` : id de l'image principale
* `folder` : dossier optionnel pour les uploads

## Upload d'images

* Le service `ImageUploadService` est réutilisé ; chaque image est enregistrée dans un dossier `exemple/Y-m-d/H-i-s` ou `folder` fourni.
* Lors de suppression d'images, supprimer également le fichier sur le disque.
* Si aucune image principale n'est définie, après une suppression, définir la première image restante comme `is_main=true`.

## Exemples Blade

### `sel/product/products/create.blade.php`

```blade
@extends('layouts.app')

@section('content')
<h1>Créer un produit</h1>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div>
    <label for="name">Nom</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}">
    @error('name')<div>{{ $message }}</div>@enderror
  </div>

  <div>
    <label for="category_id">Catégorie</label>
    <select name="category_id" id="category_id">
      @foreach($categories as $c)
        <option value="{{ $c->getKey() }}">{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label for="price">Prix</label>
    <input type="text" name="price" id="price" value="{{ old('price') }}">
  </div>

  <div>
    <label for="images">Images (plusieurs)</label>
    <input type="file" name="images[]" id="images" multiple>
    @error('images.*')<div>{{ $message }}</div>@enderror
  </div>

  <div>
    <label for="folder">Dossier (optionnel)</label>
    <input type="text" name="folder" id="folder" value="{{ old('folder', 'exemple') }}">
  </div>

  <button type="submit">Enregistrer</button>
</form>
@endsection
```

### `sel/product/products/edit.blade.php`

```blade
@extends('layouts.app')

@section('content')
<h1>Éditer le produit</h1>

<form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <!-- champs texte / selects similaires à create -->

  <h3>Images existantes</h3>
  @foreach($product->images as $img)
    <div style="display:inline-block; text-align:center; margin:8px">
      <img src="{{ $img->path }}" alt="" style="height:80px"><br>
      <label>
        <input type="checkbox" name="remove_image_ids[]" value="{{ $img->id }}"> Supprimer
      </label>
      <label>
        <input type="radio" name="main_image_id" value="{{ $img->id }}" {{ $img->is_main ? 'checked' : '' }}> Image principale
      </label>
    </div>
  @endforeach

  <div>
    <label for="images">Ajouter des images</label>
    <input type="file" name="images[]" id="images" multiple>
  </div>

  <button type="submit">Mettre à jour</button>
</form>
@endsection
```

### `sel/product/products/show.blade.php`

```blade
@extends('layouts.app')

@section('content')
<h1>{{ $product->name }}</h1>

@if($product->images->count())
  <div>
    <img src="{{ $product->images->where('is_main', true)->first()->path ?? $product->images->first()->path }}" alt="" style="height:200px">
  </div>
  <div>
    @foreach($product->images as $img)
      <img src="{{ $img->path }}" style="height:60px; margin:4px">
    @endforeach
  </div>
@endif

<p>Prix : {{ $product->price }}</p>
<p>Quantité : {{ $product->quantity }}</p>
<p>Catégorie : {{ optional($product->category)->name }}</p>
@endsection
```

## Bonnes pratiques

* Toujours valider les inputs côté serveur (requests dédiées).
* Protéger les routes par middleware d'auth si nécessaire.
* Purger les fichiers orphelins si un enregistrement est supprimé en dehors du flow normal.
* Utiliser des transactions (\$DB::transaction) pour les opérations impliquant plusieurs écritures (product + images).

---

