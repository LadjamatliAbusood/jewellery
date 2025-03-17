<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GoldCalculateController extends Controller
{
   protected $goldcalculate;


   public function __construct(){
    $this -> goldcalculate = new Product();
   }
   public function index(){

    $GoldCalculate = collect(DB::select(
        "
    SELECT
            
    gold_type,
    cost_per_gram,
    price_per_gram,
    SUM(quantity) AS total_quantity,
    SUM(grams) AS total_grams,
    cost_per_gram * SUM(grams) AS total_cost,
    SUM(price) AS Total_Price,
    SUM(price - cost) AS total_grossIncome
FROM 
    products
WHERE 
    quantity = 1
GROUP BY 
    gold_type,cost_per_gram, price_per_gram

        "
    ));

    //Old query:

    
    return view('product.goldcalculate', compact('GoldCalculate'));
    

   }
}
