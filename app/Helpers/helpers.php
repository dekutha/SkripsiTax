<?php

if (!function_exists('addTax')) {
    function addTax($amount, $tax = null) {
        $tax = $tax ?: env('PPN');

        return $amount * (100 + $tax) / 100;
    }
}

if (!function_exists('rp')) {
    function rp($amount, $prefix = 'Rp ', $decimals = 0, $dec_point = ',', $thousands_sep = '.')
    {
        return $prefix . number_format($amount, $decimals, $dec_point, $thousands_sep);
    }
}

if (!function_exists('is_active')) {

    function is_active($needle, $haystack)
    {
        if(!is_array($haystack)){
            $haystack   = [$haystack];
        }

        return in_array($needle, $haystack) ? 'active' : null;
    }
}

if (!function_exists('escape_like')) {

    /**
     * @param $string
     *
     * @return mixed
     */
    function escape_like($string)
    {
        $search = ['%', '_'];
        $replace = ['\%', '\_'];

        return str_replace($search, $replace, $string);
    }

}

if (!function_exists('build_like_query')) {

    /**
     * Build like query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $column
     * @param string                                $keywords
     * @param  string                               $boolean
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function build_like_query($query, $column, $keywords, $boolean = 'and')
    {
        $keywords = array_filter(explode(' ', $keywords));
        $boolean = strtolower($boolean);

        $query->where(function($q) use ($column, $keywords) {
            foreach ($keywords as $keyword) {
                $q->where($column, 'LIKE', '%' . escape_like($keyword) . '%');
            }
        }, null, null, $boolean);

        return $query;
    }

}


if (!function_exists('build_or_like_query')) {

    /**
     * Build like query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $column
     * @param string                                $keywords
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function build_or_like_query($query, $column, $keywords)
    {
        return build_like_query($query, $column, $keywords, 'or');
    }

}

if (!function_exists('object_to_array')) {

    function object_to_array($object, $callback = null)
    {
        $array = [];

        if (!is_object($object) && !is_array($object))
            return $callback;

        foreach ((array)$object as $key => $val) {
            $array[ $key ] = object_to_array($val, $val);
        }

        return $array;
    }
}

if (!function_exists('secure_route')) {

    function secure_route($name, $parameters = [])
    {
        $route = route($name, $parameters, false);

        return secure_url($route, []);
    }
}

if (!function_exists('decrypt_value')) {

    function decrypt_value($value, $defaultValue = '')
    {
        try {
            return decrypt($value);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $ex) {
            return $defaultValue;
        }
    }
}

if (!function_exists('inaDate')) {

    function inaDate($tgl) {
        $dt = new  \Carbon\Carbon($tgl);
        setlocale(LC_TIME, 'IND');
            
        return $dt->formatLocalized('%A, %e %B %Y %H:%M'); // Senin, 3 September 2018 00:00:00
    } 
}