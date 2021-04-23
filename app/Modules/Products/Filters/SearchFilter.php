<?php

namespace App\Modules\Products\Filters;

use App\Modules\Products\Models\Product;
use EloquentFilter\ModelFilter;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Lang;

/**
 * Class SearchFilter
 *
 * @package App\Core\Modules\Products\Filters
 */
class SearchFilter extends ModelFilter
{
    use EloquentTentacle;

    public function query(string $query)
    {
        $query = Str::lower($query);
        return $this->whereHas('current', function (Builder $db) use ($query) {
            return $db
                ->whereRaw('LOWER(vendor_code) LIKE ?', ["%$query%"])
                ->orWhereRaw('LOWER(name) LIKE ?', ["%$query%"])
                ->orWhereRaw('LOWER(hidden_name) LIKE ?', ["%$query%"]);
        });
    }
    
    public function order(string $order)
    {
        $table = (new Product())->getTable();
        $tableToJoin = Product::getRelatedTableName();
        switch ($order) {
            case 'price-asc':
                $this->oldest('price');
                break;
            case 'price-desc':
                $this->latest('price');
                break;
            case 'name-asc':
                $this
                    ->select("$table.*", "$tableToJoin.name")
                    ->join($tableToJoin, "$table.id", '=', "$tableToJoin.row_id")
                    ->where("$tableToJoin.language", Lang::getLocale())
                    ->oldest("$tableToJoin.name");
                break;
            case 'name-desc':
                $this
                    ->select("$table.*", "$tableToJoin.name")
                    ->join($tableToJoin, "$table.id", '=', "$tableToJoin.row_id")
                    ->where("$tableToJoin.language", Lang::getLocale())
                    ->latest("$tableToJoin.name");
                break;
            default:
                $this->latest("$table.id");
        }
        $this->latest('is_main');
        $this->latest('available');
        return $this;
    }

}
