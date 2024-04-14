<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSigninController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ThemeSettingsController;
use App\Http\Controllers\CrmSettingsController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ProductStockController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('administrator/auth')->group(function () {
    Route::group(['middleware' => 'ifNotAuth'], function() {
        Route::get('/', [UserSigninController::class, 'index'])->name('signin.index');
        Route::post('/signin-process', [UserSigninController::class, 'signin'])->name('signin.signin');
    });
});

Route::prefix('auth')->group(function () {
    Route::group(['middleware' => ['ifAuth']], function() {
        Route::prefix('my-account')->group(function () {
            Route::controller(UserSigninController::class)->group(function () {
                Route::get('/logout', 'logout')->name('signin.logout');
            });
            Route::name('dashboard.')->group(function () {
                Route::controller(DashboardController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                });
            });
            Route::prefix('crmajaxaction')->group(function () {
                Route::name('ajax.')->group(function () {
                    Route::controller(AjaxController::class)->group(function () {
                        Route::post('remove-table-image', 'removeTableImage')->name('removeTableImage');
                        Route::get('users', 'getUsers')->name('getUsers');
                        Route::get('products', 'getProducts')->name('getProducts');
                    });
                });
            });
            Route::prefix('my-profile')->group(function () {
                Route::name('myprofile.')->group(function () {
                    Route::controller(UserController::class)->group(function () {
                        Route::get('/', 'myProfile')->name('myProfile');
                        Route::post('/', 'myProfileUpdate')->name('myProfileUpdate');
                        Route::get('/change-password', 'changePassword')->name('changePassword');
                        Route::post('/change-password', 'changePasswordUpdate')->name('changePasswordUpdate');
                    });
                });
            });
            Route::prefix('users')->group(function () {
                Route::name('user.')->group(function () {
                    Route::group(['middleware' => ['accessRoles:super-admin|sales-man']], function() {
                        Route::controller(UserController::class)->group(function () {
                            Route::get('/', 'index')->name('index')->middleware(['accessRoles:super-admin']);
                            Route::get('/add', 'addUser')->name('add');
                            Route::post('/save', 'saveUser')->name('save');
                            Route::get('/edit/{id}', 'editUser')->name('edit');
                            Route::post('/update/{id}', 'updateUser')->name('update');
                            Route::get('/delete/{id}', 'deleteUser')->name('delete');
                            Route::get('/lock-unload/{id}/{statusId}', 'lockUnlockUser')->name('lockUnlock');
                            Route::get('/profile-information/{id}', 'profileInformation')->name('profileInformation');
                            Route::post('/profile-information/{id}', 'saveProfileInformation')->name('saveProfileInformation');
                            Route::get('/reset-password/{id}', 'profileInformation')->name('resetPassword');
                            Route::post('/reset-password/{id}', 'resetPassword')->name('resetSavePassword');
                            Route::get('/reset-username/{id}', 'profileInformation')->name('resetUsername');
                            Route::post('/reset-username/{id}', 'resetUsername')->name('resetSaveUsername');
                            Route::prefix('vendors')->group(function () {
                                Route::name('vendor.')->group(function () {
                                    Route::get('/', 'allVendors')->name('allVendors')->middleware(['accessRoles:super-admin']);
                                });
                            });
                            Route::prefix('sales-man')->group(function () {
                                Route::name('salesman.')->group(function () {
                                    Route::get('/', 'allSalesman')->name('allSalesman')->middleware(['accessRoles:super-admin']);
                                });
                            });
                            Route::prefix('customers')->group(function () {
                                Route::name('customer.')->group(function () {
                                    Route::get('/', 'allCustomer')->name('allCustomer');
                                });
                            });
                            Route::post('/quick-add', 'quickAddUser')->name('quick-add');
                        });
                    });
                });
            });
            Route::prefix('products')->group(function () {
                Route::name('product.')->group(function () {
                    Route::controller(ProductController::class)->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/add', 'addProduct')->name('add');
                        Route::post('/save', 'saveProduct')->name('save');
                        Route::get('/edit/{id}', 'editProduct')->name('edit');
                        Route::post('/update/{id}', 'updateProduct')->name('update');
                        Route::get('/delete/{id}', 'deleteProduct')->name('delete');

                        Route::post('/quick-add', 'quickAddProduct')->name('quick-add');
                        Route::post('/quick-add-unit', 'quickAddProductUnit')->name('quick-add-unit');
                    });
                    Route::prefix('categories')->group(function () {
                        Route::name('category.')->group(function () {
                            Route::controller(ProductController::class)->group(function () {
                                Route::get('/', 'allCategories')->name('allCategories');
                                Route::get('/add', 'addCategory')->name('addCategory');
                                Route::post('/save', 'saveCategory')->name('saveCategory');
                                Route::get('/edit/{id}', 'editCategory')->name('editCategory');
                                Route::post('/update/{id}', 'updateCategory')->name('updateCategory');
                                Route::get('/delete/{id}', 'deleteCategory')->name('deleteCategory');
                                Route::post('/all-subcategories', 'getAllCategories')->name('getAllCategories');
                            });
                        });
                    });
                    Route::prefix('sub-categories')->group(function () {
                        Route::name('subcategory.')->group(function () {
                            Route::controller(ProductController::class)->group(function () {
                                Route::get('/', 'allSubCategories')->name('allSubCategories');
                                Route::get('/add', 'addSubCategory')->name('addSubCategory');
                                Route::post('/save', 'saveSubCategory')->name('saveSubCategory');
                                Route::get('/edit/{id}', 'editSubCategory')->name('editSubCategory');
                                Route::post('/update/{id}', 'updateSubCategory')->name('updateSubCategory');
                                Route::get('/delete/{id}', 'deleteSubCategory')->name('deleteSubCategory');
                            });
                        });
                    });
                    Route::prefix('variants')->group(function () {
                        Route::name('variant.')->group(function () {
                            Route::controller(ProductController::class)->group(function () {
                                Route::get('/', 'allVariants')->name('allVariants');
                                Route::get('/add', 'addVariants')->name('addVariants');
                                Route::post('/save', 'saveVariants')->name('saveVariants');
                                Route::get('/edit/{id}', 'editVariants')->name('editVariants');
                                Route::post('/update/{id}', 'updateVariants')->name('updateVariants');
                                Route::get('/delete/{id}', 'deleteVariants')->name('deleteVariants');
                            });
                            Route::prefix('bundle-products')->group(function () {
                                Route::name('bundle.')->group(function () {
                                    Route::controller(ProductController::class)->group(function () {
                                        Route::get('/{variant_id}', 'allVariantBundleProducts')->name('allVariantBundle');
                                    });
                                });
                            });
                            Route::prefix('free-products')->group(function () {
                                Route::name('free.')->group(function () {
                                    Route::controller(ProductController::class)->group(function () {
                                        Route::get('/{variant_id}', 'allVariantFreeProducts')->name('allVariantFree');
                                    });
                                });
                            });
                        });
                    });
                });
            });
            Route::prefix('units')->group(function () {
                Route::name('unit.')->group(function () {
                    Route::controller(UnitController::class)->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/add', 'addUnit')->name('add');
                        Route::post('/save', 'saveUnit')->name('save');
                        Route::get('/edit/{id}', 'editUnit')->name('edit');
                        Route::post('/update/{id}', 'updateUnit')->name('update');
                        Route::get('/delete/{id}', 'deleteUnit')->name('delete');
                    });
                });
            });
            Route::prefix('brands')->group(function () {
                Route::name('brand.')->group(function () {
                    Route::controller(BrandController::class)->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/add', 'addBrand')->name('add');
                        Route::post('/save', 'saveBrand')->name('save');
                        Route::get('/edit/{id}', 'editBrand')->name('edit');
                        Route::post('/update/{id}', 'updateBrand')->name('update');
                        Route::get('/delete/{id}', 'deleteBrand')->name('delete');
                    });
                });
            });

            Route::prefix('stocks')->group(function () {
                Route::name('stock.')->group(function () {
                    Route::controller(ProductStockController::class)->group(function () {
                        Route::get('/', 'stockReport')->name('report');
    
                        Route::get('/in', 'stockInIndex')->name('in');
                        Route::get('/in/add', 'addStock')->name('add');
                        Route::post('/in/save', 'saveStock')->name('save');
    
                        Route::get('/out', 'stockOutIndex')->name('out');
                        Route::get('/out/add', 'outStock')->name('out-add');
                        Route::post('/out/save', 'saveOutStock')->name('out-save');
                    });
                });
            });
            
            Route::group(['middleware' => ['accessRoles:super-admin']], function() {
                Route::prefix('theme-settings')->group(function () {
                    Route::name('theme.')->group(function () {
                        Route::controller(ThemeSettingsController::class)->group(function () {
                            Route::get('/', 'index')->name('index');
                            Route::post('/add', 'saveChanges')->name('save');
                        });
                    });
                });
                Route::prefix('crm')->group(function () {
                    Route::name('crm.')->group(function () {
                        Route::controller(CrmSettingsController::class)->group(function () {
                            Route::get('/', 'index')->name('index');
                            Route::post('/add', 'saveChanges')->name('save');
                        });
                    });
                });
            });
        });
    });
});