## Laravel admin panel

### 1. Install
add to composer.json
```
"singapura/merlion": "*@dev",
```

### 2. Add service provider

```php
// app/Providers/AdminServiceProvider.php
class AdminSericeProvider extends AdminProvider
{

    public function admin(Admin $admin): Admin
    {
        return $admin
            ->id('admin')
            ->default()
            ->authenticatedRoutes(function () {
                Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
            })
            ->path('admin');
    }
}
```

### 3. Basic crud

```
// app/Http/Controllers/Admin

class UserController extends CrudController
{
    protected string $model = User::class;

    protected function schemas(): array
    {
        return [
            'id',
            'name',
            'email',
        ];
    }

    protected function searches(): array
    {
        return ['name', 'email'];
    }
}
```

### 4. check result: http://example.test/admin, http://example.test/admin/users
