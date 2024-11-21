# Laravel User Stamps

Automatically add `created_by`, `updated_by`, and `deleted_by` columns to your Laravel models to track who created, updated, or deleted records.

## Installation

You can install the package via composer:

```bash
composer require user-stamps/laravel
```

## Usage

### 1. Add the columns to your migration:

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    // Add all stamps at once
    $table->userStamps();
    // Or add them individually
    $table->createdBy();
    $table->updatedBy();
    $table->deletedBy();  // Note: Only added if table uses softDeletes
    $table->timestamps();
    $table->softDeletes();  // Optional
});
```

### 2. Add the trait to your model:

```php
use UserStamps\Traits\HasUserStamps;
// Or use them individually
use UserStamps\Traits\HasCreatedBy;
use UserStamps\Traits\HasUpdatedBy;
use UserStamps\Traits\HasDeletedBy;

class Post extends Model
{
    use HasUserStamps;
    // Or use them individually
    use HasCreatedBy, HasUpdatedBy, HasDeletedBy;
}
```

Now your model will automatically:
- Set `created_by` when a record is created
- Set `updated_by` when a record is updated
- Set `deleted_by` when a record is soft deleted (if using softDeletes)

## Database Fields

The package will create the following nullable `unsignedBigInteger` columns:
- `created_by`
- `updated_by`
- `deleted_by` (only when using softDeletes)

## Important Notes

### Model Events
User stamps are set using Laravel's model events. The following methods will properly set the stamps:

✅ These will work:
```php
// Creating
Model::create($data);
$model = new Model();
$model->save();

// Updating
$model = Model::find($id);
$model->update($payload);
$model->save();

// Deleting (with soft deletes)
$model->delete();
Model::destroy($id);
```

❌ These bypass model events and won't set stamps:
```php
// Creating
Model::insert($data);  // Batch inserts

// Updating
Model::where('id', $id)->update($payload);  // Query builder updates

// Deleting
Model::where('id', $id)->forceDelete();  // Force delete
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Your Name](https://github.com/yourusername)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
