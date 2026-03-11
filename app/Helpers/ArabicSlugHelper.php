<?php

namespace App\Helpers;

class ArabicSlugHelper
{
    /**
     * Generate Arabic & English slug
     * Example: "product-one منتج واحد" => "product-one-منتج-واحد"
     */
    public static function make(string $text): string
    {
        // تحويل الأرقام العربية إلى إنجليزية
        $text = str_replace(
            ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'],
            ['0','1','2','3','4','5','6','7','8','9'],
            $text
        );

        // إزالة التشكيل
        $text = preg_replace('/[\x{064B}-\x{065F}]/u', '', $text);

        // السماح بالعربي + الإنجليزي + الأرقام + المسافات + -
        $text = preg_replace('/[^\p{Arabic}a-zA-Z0-9\s\-]/u', '', $text);

        // تحويل المسافات إلى -
        $text = preg_replace('/\s+/u', '-', trim($text));

        // منع --
        $text = preg_replace('/-+/', '-', $text);

        return strtolower($text);
    }

    /**
     * Generate unique Arabic slug
     */
    public static function unique(
        string $text,
        string $model,
        string $column = 'slug',
        $ignoreId = null
    ): string {
        $slug = self::make($text);

        if (!class_exists($model)) {
            return $slug;
        }

        $query = $model::where($column, $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $count = $query->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
