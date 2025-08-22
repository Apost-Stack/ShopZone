# E-commerce Laravel Project

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## Aperçu du projet

Ce projet est une plateforme e-commerce développée avec **Laravel**, permettant la gestion complète des produits, clients, employés, commandes, livraisons et remises.

### Modèles principaux

- **Product** : nom, quantité, prix, catégorie, remise, images, dimensions, statut, slug.
- **Category** : nom, image, statut.
- **Discount** : nom, pourcentage.
- **Customer** : nom, prénom, date de naissance, civilité, téléphone, province, adresse, statut.
- **Employee** : nom, prénom, téléphone, statut, lié à un utilisateur.
- **Delivery** : nom, province, adresse, description, coût, employé, remise, statut.
- **Order** : référence, client, livraison, produits, remise, statut, méthode de paiement, total, taxes, paiement.

### Enumérations

- **Role** : CUSTOMER, ADMIN, EMPLOYEE
- **PaymentMethod** : CASH, MVOLA, ORANGE_MONEY, AIRTEL_MONEY
- **OrderStatus** : PAID, UNPAID

### Relations principales

- `Category` a plusieurs `Product`
- `Product` a plusieurs `ProductImage` et peut appartenir à plusieurs `Order`
- `Customer` a plusieurs `Order`
- `Order` appartient à un `Customer` et une `Delivery`, et contient plusieurs `Product`
- `Delivery` est lié à un `Employee` et une `Province`
- `Discount` peut être appliqué aux `Product`, `Order` et `Delivery`

### Exemple de flux concret

1. L'**Admin** ajoute des catégories et produits.
2. Un **Client** s’inscrit et ajoute des produits au panier.
3. Le Client passe une **commande** (`Order`) avec calcul du total, taxes et remise.
4. Le Client effectue le **paiement** via Cash, Mvola, Orange Money, ou Airtel Money.
5. La **livraison** est effectuée par un employé, selon la province du client.
6. Les **statuts** des produits, commandes, clients et livraisons sont mis à jour dynamiquement.

### Structure des tables (extrait)

| Table | Champs principaux |
|-------|------------------|
| `products` | name, quantity, price, discount_id, slug, category_id |
| `categories` | name, picture, status_id |
| `customers` | first_name, last_name, phone, province_id, status_id |
| `employees` | first_name, last_name, phone, status_id |
| `deliveries` | name, address, province_id, cost, employee_id, discount_id |
| `orders` | reference, customer_id, delivery_id, order_status, payment_method, price_total, tax |
| `discounts` | name, percent |

### Diagramme ER

```text
Customer ---< Order >--- Product
Category ---< Product
Product ---< ProductImage
Discount ---< Product
Discount ---< Order
Discount ---< Delivery
Delivery --- Employee
OrderStatus, PaymentMethod, Role (Enums)
```
