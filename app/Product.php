<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ShoppingCart;
use App\OrderProduct;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    protected $fillable =['name','description','price','weight','brand_id','category_id','sale','img_url','pospal_id','real_sale','spec','RRP','sale_price','reward_points','expired_date'];

    use SoftDeletes;
    use Searchable;

    protected $hidden = [
        'real_sale','pospal_id','reward_points'
    ];

    protected $dates = ['deleted_at'];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function brand(){
        return $this->belongsTo('App\Brand');
    }

    public function get_cart_quantity($user_id){
        return ShoppingCart::where('user_id', $user_id)->
            where('product_id',$this->id)->firstOrFail()->quantity;
    }

    public function get_order_quantity($order_id){
        return OrderProduct::where('order_id', $order_id)->
            where('product_id',$this->id)->firstOrFail()->quantity;
    }

    public function searchableAs()
    {
        return 'name';
    }

    public function collection(){
        return $this->belongsToMany('App\Collection','collection_products');
    }

}
