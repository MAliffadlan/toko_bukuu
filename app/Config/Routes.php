<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =============================================================================
// PUBLIC ROUTES (Tanpa autentikasi)
// =============================================================================
$routes->get('/', 'DesktopController::index');  // macOS Desktop
$routes->get('/browser', 'Home::index');         // Toko Buku (untuk iframe)
$routes->get('/book/(:segment)', 'Home::detail/$1');
$routes->get('/category/(:segment)', 'Home::category/$1');

// PDF Viewer Routes (allow in iframe)
$routes->get('pdf/view/(:any)', 'PdfController::view/$1');
$routes->get('pdf/stream/(:any)', 'PdfController::stream/$1');
$routes->get('pdf/demo', 'PdfController::demo');


// =============================================================================
// GUEST ROUTES (Hanya untuk yang belum login)
// =============================================================================
$routes->group('', ['filter' => 'guest'], static function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::attemptRegister');
});

// Logout (harus sudah login)
$routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);

// =============================================================================
// CUSTOMER ROUTES (Semua user yang sudah login)
// =============================================================================
$routes->group('', ['filter' => 'customer'], static function ($routes) {
    // Cart
    $routes->get('cart', 'CartController::index');
    $routes->post('cart/add', 'CartController::add');
    $routes->post('cart/update', 'CartController::update');
    $routes->post('cart/remove', 'CartController::remove');
    
    // Checkout
    $routes->get('checkout', 'CheckoutController::index');
    $routes->post('checkout/process', 'CheckoutController::process');
    $routes->get('orders', 'CheckoutController::history');
    $routes->get('orders/(:num)', 'CheckoutController::detail/$1');
    $routes->post('orders/pay/(:num)', 'CheckoutController::pay/$1');
    
    // Profile
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');
    
    // E-Library (Buku yang sudah dibeli)
    $routes->get('library', 'LibraryController::index');
    $routes->get('library/read/(:num)', 'LibraryController::read/$1');
    $routes->get('library/download/(:num)', 'LibraryController::download/$1');
    
    // Wishlist
    $routes->get('wishlist', 'WishlistController::index');
    $routes->post('wishlist/toggle/(:num)', 'WishlistController::toggle/$1');
    $routes->post('wishlist/add/(:num)', 'WishlistController::add/$1');
    $routes->post('wishlist/remove/(:num)', 'WishlistController::remove/$1');
    $routes->get('wishlist/check/(:num)', 'WishlistController::check/$1');
});

// =============================================================================
// ADMIN/STAFF ROUTES (Admin dan Staff)
// =============================================================================
$routes->group('admin', ['filter' => 'staff'], static function ($routes) {
    // Dashboard
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');
    
    // Books CRUD
    $routes->get('books', 'Admin\BookController::index');
    $routes->get('books/create', 'Admin\BookController::create');
    $routes->post('books/store', 'Admin\BookController::store');
    $routes->get('books/edit/(:num)', 'Admin\BookController::edit/$1');
    $routes->post('books/update/(:num)', 'Admin\BookController::update/$1');
    
    // Categories CRUD
    $routes->get('categories', 'Admin\CategoryController::index');
    $routes->get('categories/create', 'Admin\CategoryController::create');
    $routes->post('categories/store', 'Admin\CategoryController::store');
    $routes->get('categories/edit/(:num)', 'Admin\CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\CategoryController::update/$1');
    
    // Transactions
    $routes->get('transactions', 'Admin\TransactionController::index');
    $routes->get('transactions/(:num)', 'Admin\TransactionController::detail/$1');
    $routes->post('transactions/status/(:num)', 'Admin\TransactionController::updateStatus/$1');
});

// =============================================================================
// ADMIN ONLY ROUTES (Hanya Admin - untuk delete dan user management)
// =============================================================================
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    // Delete operations - hanya admin
    $routes->post('books/delete/(:num)', 'Admin\BookController::delete/$1');
    $routes->post('categories/delete/(:num)', 'Admin\CategoryController::delete/$1');
    
    // User Management - hanya admin
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->post('users/delete/(:num)', 'Admin\UserController::delete/$1');
});
