# Checkout and Role-Based Access Updates

## Summary
Updated the checkout functionality and implemented role-based access control for frontend users. All new users are automatically assigned the "client" role upon registration.

## Changes Made

### 1. **User Registration - Client Role Assignment**
   - **File**: `app/Actions/Fortify/CreateNewUser.php`
   - **Changes**:
     - Automatically splits user's name into `first_name` and `last_name`
     - Assigns "client" role to all new users upon registration
     - Creates the "client" role if it doesn't exist

### 2. **Role Seeder Updates**
   - **File**: `database/seeders/RolePermissionSeeder.php`
   - **Changes**:
     - Added "client" role to the roles array
     - Client role has no special permissions (uses standard authenticated routes)

### 3. **Checkout Functionality**
   - **File**: `resources/views/frontend/cart/index.blade.php`
   - **Changes**:
     - Updated `proceedToCheckout()` function to redirect to checkout page
     - Added authentication check - redirects to login if not authenticated
     - Added "Login to Checkout" button for unauthenticated users
     - Preserves redirect URL after login

### 4. **Frontend Controller Updates**
   - **File**: `app/Http/Controllers/FrontendController.php`
   - **Changes**:
     - `checkout()` method: Added cart validation (redirects if empty)
     - `payments()` method: Added cart validation (redirects if empty)
     - Authentication is handled by route middleware

### 5. **Routes Configuration**
   - **File**: `routes/web.php`
   - **Changes**:
     - All frontend routes (checkout, payments, dashboard, etc.) are within authenticated middleware group
     - Routes require authentication before access

### 6. **Login Redirect Configuration**
   - **File**: `app/Providers/FortifyServiceProvider.php`
   - **Changes**:
     - Added `redirectAfterLogin()` to handle post-login redirects
     - Clients are redirected to frontend homepage
     - Admins are redirected to admin dashboard
     - Supports redirect parameter for checkout flow

## User Flow

### New User Registration:
1. User registers with name, email, and password
2. System automatically:
   - Splits name into first_name and last_name
   - Creates user account
   - Assigns "client" role
3. User is redirected to frontend homepage

### Checkout Flow:
1. User adds items to cart (no login required)
2. User clicks "Proceed to Checkout"
3. If not authenticated:
   - Redirected to login page with return URL
   - After login, redirected back to checkout
4. If authenticated:
   - Proceeds directly to checkout page
5. User completes shipping information
6. User proceeds to payment
7. User confirms order

## Database Migrations Required

Run the following migrations:
```bash
php artisan migrate
```

This will create:
- `shipping_infos` table
- `orders` table
- `order_items` table
- Add `first_name`, `last_name`, `profile_photo` to `users` table

## Seeding Roles

Run the seeder to ensure the "client" role exists:
```bash
php artisan db:seed --class=RolePermissionSeeder
```

Or run all seeders:
```bash
php artisan db:seed
```

## Testing Checklist

- [ ] Register a new user - verify "client" role is assigned
- [ ] Add items to cart as guest
- [ ] Click "Proceed to Checkout" - should redirect to login
- [ ] Login - should redirect back to checkout
- [ ] Complete checkout flow (shipping → payment → confirmation)
- [ ] Verify order is created in database
- [ ] Check that clients can access frontend routes
- [ ] Verify admins can still access admin routes

## Notes

- The "client" role is automatically created if it doesn't exist during user registration
- All frontend routes require authentication (handled by route middleware)
- Cart functionality works for both authenticated and guest users
- Checkout and payment pages require authentication
- Users with "client" role are redirected to frontend after login
- Users with "admin" or "super-admin" roles are redirected to admin dashboard
