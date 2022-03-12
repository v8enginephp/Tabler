# Tabler

Make Your Index Tables Like Piece of Cake

## Installation

Install Tabler with composer

```bash
    composer require v8enginephp/tabler 
```

## Usage/Examples

```php
use V8\Tabler;


class Test
{
    use Tabler;
    
    protected static function getDefaultColumns(): array
    {
        return [
            tabler_column('slug','column header',function($row){
                // This function executes the number of your records and passes $row argument as the current row record
                // by default if You dont fill this argument Table will fill with $row->slug
                return $row->id;
            }),
        ];
    } 
}
```

In view

```php
    <?=Test::renderTable($records)?>
```

In Blade

 ```blade
    {!! Test::renderTable($records) !!}
 ```

## Authors

- [Aliakbar Soleimani](https://www.github.com/alisoleimanii)
