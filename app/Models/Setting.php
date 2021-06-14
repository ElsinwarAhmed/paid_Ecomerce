<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    // يربط العلاقات بين الجدولين
    use Translatable;

    //  معناها انها حترجع  معها الترجمات
    protected $with = ['translations'];

    // الاتربيوت يلي محتاج اترجمها
    protected $translatedAttributes = ['value'];

    protected $fillable = ['key', 'is_translatable', 'plan_value'];

    // تعني تغير النوع تاع الاتربيوت
    protected $casts = ['is_translatable' => 'boolean'];

    public static function setMany($settings)
    {
        foreach ($settings as $key => $value) {
            self::set($key, $value);  // use self >> becouse use static function
            // تعني انك حتمرر البيانات الفاليو والكي لجدول هذا المودل
        }
    }

    public static function set($key, $value)
    {
        if ($key === 'translatable') {
            return static::setTranslatableSetting($value);
            // static:: >> rather than Setting:: >> تشير الى الموديل يلي انا موجود فيه
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        static::updateOrCreate(['key' => $key], ['plan_value' => $value]);
    }

    public static function setTranslatableSetting($settings = [])
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(['key' => $key], [
                'is_translatable' => true,
                'value' => $value,
            ]);
        }
    }
}
