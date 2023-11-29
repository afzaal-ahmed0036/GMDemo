<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;
use DB;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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

        /* NEW TEQ POS SETTING */
       /*  if(isset($_COOKIE['language'])) {
            \App::setLocale($_COOKIE['language']);
        } else {
            \App::setLocale('en');
        } */
        //get general setting value        
        /* $general_setting = DB::table('general_settings')->latest()->first();
        $currency = \App\Models\Currency::find($general_setting->currency);
        View::share('general_setting', $general_setting);
        View::share('currency', $currency);
        config(['staff_access' => $general_setting->staff_access, 'date_format' => $general_setting->date_format, 'currency' => $currency->code, 'currency_position' => $general_setting->currency_position]);
        
        $alert_product = DB::table('products')->where('is_active', true)->whereColumn('alert_quantity', '>', 'qty')->count(); */
        //View::share('alert_product', $alert_product);
        //Schema::defaultStringLength(191);
        /* NEW TEQ POS SETTING ENDS HERE. */

        $currency = Session::get('Currency');
        $currency_position = 'prefix';
        config(['currency' => $currency, 'currency_position' => $currency_position]);

        view()->composer('*', function ($view) {
            $isSuperAdmin = session::get('isSuperAdmin');
            $warehouseId = Session::get('WarehouseID');
            if($isSuperAdmin == 1)
                $lims_warehouse_data = Warehouse::where('is_active', '1')->get();
            else
                $lims_warehouse_data = Warehouse::where('id',$warehouseId)->get();

            $view->with(compact('lims_warehouse_data'));
        });
    }
}
