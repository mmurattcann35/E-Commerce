<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Order;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer(['admin.*'], function($view){
           if(!cache()->has('statistics')){
               $statistics = [
                   'waiting_orders_count'  => Order::where('order_state','Sipariş Alındı')->count(),
                   'users_count'           => User::count(),
                   'categories_count'      => Category::count(),
                   'finished_orders_count' => Order::where('order_state','Sipariş Tamamlandı')->count()
               ];

               $finishTime =  now()->addMinutes(10);
               Cache::put('statistics',$statistics,$finishTime);
           }else{
               $statistics = Cache::get('statistics');
           }
           $view->with('statistics',$statistics);
       });

        /*  For whole app*/

        /*if(!cache()->has('statistics')){
             $statistics = [
                 'waiting_orders_count' => Order::where('order_state','Sipariş Alındı')->count()
             ];

             $finishTime =  now()->addMinutes(10);
             Cache::put('statistics',$statistics,$finishTime);
         }else{
             $statistics = Cache::get('statistics');
         }

         View::share('statistics', $statistics);
        */

        /*  For spesific files or pages */

    }
}
