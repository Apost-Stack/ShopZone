# Pack vues Laravel e-commerce (drop-in)

Ces vues supposent l'existence **optionnelle** des routes suivantes (à adapter à votre projet) :

- `home` (GET) → page d'accueil
- `products.index` (GET, filtres: `q`, `category`, `min`, `max`, `sort`)
- `products.show` (GET, paramètre `{product}`)
- `cart.index` (GET)
- `cart.add` (POST, paramètre `{product}`, champs: `qty`)
- `cart.update` (PUT, paramètre `{rowId}`, champs: `qty`)
- `cart.remove` (DELETE, paramètre `{rowId}`)
- `checkout.index` (GET)
- `checkout.process` (POST)
- `orders.index` (GET)
- `orders.show` (GET, paramètre `{order}`)
- `search` (GET, paramètre `q`)
- `legal` (GET)
- `login` (GET/POST)
- `logout` (POST)

### Variables attendues par quelques vues

- `home`: `$latestProducts` (Collection de produits)
- `products.index`: `$products` (paginé ou Collection), `$categories` (Collection)
- `products.show`: `$product`, `$related` (Collection)
- `cart.index`: `$items` (array ligne par ligne), `$totals` (`subtotal`, `tax`, `total`)
- `checkout.index`: `$totals`, `$shipping` (optionnel)
- `orders.index`: `$orders` (paginé)
- `orders.show`: `$order` (`items`, `subtotal`, `tax`, `total`, `status`)

Adaptez les champs (`image_url`, `name`, `price`, `description`, etc.) si votre modèle diffère.

### Installation

Copiez le dossier `resources/views` dans votre projet (remplacez/mergez).

Si vous utilisez déjà Vite + Tailwind, commentez le CDN dans `layouts/app.blade.php` et activez `@vite`.

Bon dev !
