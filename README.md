# E-commerce API

A complete Laravel-based e-commerce API with user management, product catalog, order processing, and warehouse management.

## 🚀 Features

### User & Authentication Module
- ✅ User registration and login with Sanctum
- ✅ Role-based access control (Admin, Seller, Customer)
- ✅ Authorization policies for all actions
- ✅ JSON API responses with proper error handling

### Product & Order Management Module
- ✅ CRUD operations for products and categories
- ✅ Customers can place orders
- ✅ Order statuses (Pending, Processing, Shipped, Completed, Cancelled)
- ✅ Sellers/Admin can update order statuses
- ✅ Pagination for all list endpoints

### Warehouse Module
- ✅ Track product stock levels
- ✅ Deduct stock when orders are placed
- ✅ Prevent orders if stock is insufficient
- ✅ Allow Admin/Seller to adjust stock manually
- ✅ Stock adjustment history

## 🛠 Technology Stack

- **Backend**: Laravel 11
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **API**: RESTful JSON API
- **Validation**: Form Request validation
- **Pagination**: Laravel pagination with custom response format

## 📋 API Endpoints

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user (requires auth)

### Products
- `GET /api/products` - List products (paginated)
- `POST /api/products` - Create product (admin/seller)
- `GET /api/products/{id}` - Get product details
- `PUT /api/products/{id}` - Update product (admin/owner)
- `DELETE /api/products/{id}` - Delete product (admin/owner)

### Categories
- `GET /api/categories` - List categories (paginated)
- `POST /api/categories` - Create category (admin/seller)
- `GET /api/categories/{id}` - Get category details
- `PUT /api/categories/{id}` - Update category (admin/seller)
- `DELETE /api/categories/{id}` - Delete category (admin/seller)

### Orders
- `GET /api/orders` - List orders (paginated)
- `POST /api/orders` - Create order (customer)
- `GET /api/orders/{id}` - Get order details
- `PATCH /api/orders/{id}/status` - Update order status (admin/seller)
- `DELETE /api/orders/{id}` - Cancel order

### Warehouse
- `GET /api/warehouse` - List stock (paginated)
- `GET /api/warehouse/{product}` - Get product stock
- `POST /api/warehouse/{product}/adjust` - Adjust stock (admin/seller)

## 🚀 Quick Start

### Using Docker (Recommended)

1. **Clone the repository**
```bash
git clone https://github.com/YOUR_USERNAME/ecommerce-api.git
cd ecommerce-api
```

2. **Start Docker containers**
```bash
docker-compose up -d
```

3. **Generate application key**
```bash
docker-compose exec app php artisan key:generate
```

4. **Run migrations and seeders**
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

5. **Access the API**
- Base URL: `http://localhost:8000/api`
- Test endpoint: `GET http://localhost:8000/api/test`

### Using Local PHP

1. **Install dependencies**
```bash
composer install
```

2. **Configure environment**
```bash
cp .env.example .env
# Edit .env with your database credentials
```

3. **Generate key and migrate**
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

## 📊 Sample Data

The seeder creates:
- **Users**: Admin, Sellers, Customers with test accounts
- **Categories**: Electronics, Clothing, Books, etc.
- **Products**: 25+ products across categories
- **Orders**: Sample orders with order items
- **Warehouse**: Stock entries for all products

### Test Accounts
- **Admin**: admin@ecommerce.com / password
- **Seller**: john@seller.com / password
- **Customer**: alice@customer.com / password

## 🔧 API Usage Examples

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@ecommerce.com", "password": "password"}'
```

### Create Order
```bash
curl -X POST http://localhost:8000/api/orders \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "items": [
      {"product_id": 1, "quantity": 2},
      {"product_id": 2, "quantity": 1}
    ]
  }'
```

### Get Products with Pagination
```bash
curl -X GET "http://localhost:8000/api/products?per_page=10&page=1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## 📝 Response Format

All API responses follow a consistent format:

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... },
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 100,
    "last_page": 7,
    "from": 1,
    "to": 15
  }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

## 🧪 Testing

The project includes comprehensive test data and can be tested using:
- Postman collection (included)
- API testing tools
- cURL commands

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/Api/     # API Controllers
│   ├── Requests/            # Form validation
│   └── Resources/           # API response formatting
├── Models/                  # Eloquent models
├── Policies/               # Authorization policies
├── Services/               # Business logic
└── Providers/              # Service providers

database/
├── factories/              # Model factories
├── migrations/             # Database migrations
└── seeders/               # Database seeders
```

## 🔒 Security Features

- JWT-based authentication with Sanctum
- Role-based authorization
- Input validation and sanitization
- SQL injection protection
- CSRF protection for web routes

## 📈 Performance Features

- Database pagination
- Eager loading relationships
- Database transactions for data consistency
- Optimized queries

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Built with ❤️ using Laravel**