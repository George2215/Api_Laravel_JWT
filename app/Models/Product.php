<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function scopeFiltered()
    {
        $search = request('search');
        $sortBy = request('sortBy');
        $order = request('sortDesc') == 'true' ? 'desc' : 'asc';

        $products = DB::table('products')
            ->select(
                'id', 
                'name', 
                'price'
            )
            ->whereNotNull("name");
        
        if($search && strlen($search) > 0) {
            $products->where('name', 'LIKE', "%$search%");
        }
        switch ($sortBy) {
            case 'name':
            case 'price': {
                $products->orderBy($sortBy, $order);
            }
        }
        
        return $products;
    }
}
