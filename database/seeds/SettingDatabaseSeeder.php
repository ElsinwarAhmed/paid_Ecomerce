<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Setting::setMany([
            'default_locale' => 'ar',
            'default_timezone' => 'Africa/Cairo',
            'reviews_enabled' => true,  //موافقة على التعليقات
            'auto_approve_reviews' => true,  //موافقة على التعليقات تلقائي
            'supported_currencies' => ['usd', 'LE', 'SAR'],
            'default_currency' => 'usd',
            'store_email' => 'usd',
            'search_engine' => 'mysql',
            // قيمة التوصيل
            'local_shipping_cost' => 0,
            'outer_shipping_cost' => 0,
            'free_shipping_cost' => 0,

            // العناصر المحتاجة الى ترجمة وضعتها داخل الاراي
            'translatable' => [
                'store_name' => 'متجر السنوار',

                // الكلام يلي حيظهر بجانب قيمة التوصيل
                'free_shipping_label' => 'توصيل مجاني',
                'locale_label' => 'توصيل داخلي',
                'outer_label' => 'توصيل خارجي',
            ],
        ]);
        // $seeting = Setting::create([
        //     'key' => '',
        //     'is_translatable' => '',
        //     'plan_value' => '',
        // ]);
    }
}
