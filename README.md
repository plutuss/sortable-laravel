## Installed packages

Laravel:
- [GitHub](https://github.com/plutuss/sortable-laravel ).




```shell
 composer require plutuss/sortable-laravel
```


Add:
- Plutuss\Sortable\Traits\Sortable
- Plutuss\Sortable\Contracts\SortableInterface


- 

```php
<?php

namespace App\Models;

use Plutuss\Sortable\Contracts\SortableInterface;
use  Plutuss\Sortable\Traits\Sortable;

class Movie extends Model implements SortableInterface
{
    use Sortable;
    
     public function sortables(): array
    {
        return [
            'views_desc',
            
                 or
            
            'views_key' => [
                'views',
                'ASC',
            ],
        ];
    }

```


Add:
- sort()

```php
<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class MovieController extends Controller
{


    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $movies = Movie::sort()->paginate(12)
           
        return view('movies.index', compact('movies'));
    }

```