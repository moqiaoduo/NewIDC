<?php

if (!function_exists('arrayKeyValueSame')) {
    /**
     * 把值复制到键上
     *
     * @param array $array
     * @return array
     */
    function arrayKeyValueSame(array $array)
    {
        foreach ($array as $value) {
            $new_arr[$value] = $value;
        }
        return $new_arr ?? [];
    }
}

if (!function_exists('setOption')) {
    /**
     * 写入options表
     *
     * @param $key
     * @param null $value
     * @param int $uid
     */
    function setOption($key, $value, $uid = 0)
    {
        try {
            if (Schema::hasTable("options")) {
                DB::table("options")->updateOrInsert(compact('key', 'uid'), compact('value'));
            }
        } catch (Exception $e) {
        }
    }
}

if (!function_exists('getOption')) {
    /**
     * 读取option
     *
     * @param $key
     * @param null $default
     * @param int $uid
     * @return mixed|null
     */
    function getOption($key, $default = null, $uid = 0)
    {
        try {
            if (Schema::hasTable("options")) {
                $result = DB::table("options")->where("key", $key)->where('uid', $uid)->first();
                if (!$result || ($val = $result->value) === null) return $default;
                return $val;
            }
        } catch (Exception $e) {
        }
        return $default;
    }
}

if (!function_exists('getOptions')) {
    /**
     * 读取多个option
     *
     * @param null $keys
     * @param int $uid
     * @return \Illuminate\Support\Collection|null
     */
    function getOptions($keys = null, $uid = 0)
    {
        try {
            if (Schema::hasTable("options")) {
                $db = DB::table("options")->where('uid', $uid);
                if (!is_null($keys))
                    $db = $db->whereIn('key', Arr::wrap($keys));
                return $db->get()->pluck('value', 'key');
            }
        } catch (Exception $e) {
        }
        return null;
    }
}

if (!function_exists('modifyEnv')) {
    /**
     * 修改.env
     *
     * @param array $data
     */
    function modifyEnv(array $data)
    {
        $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';

        $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));

        $contentArray->transform(function ($item) use ($data) {
            foreach ($data as $key => $value) {
                if (Str::contains($item, $key)) {
                    return $key . '=' . $value;
                }
            }

            return $item;
        });

        $content = implode($contentArray->toArray(), "\n");

        File::put($envPath, $content);
    }
}

if (!function_exists('getLowestPrice')) {
    /**
     * 获取最低价格
     *
     * @param array $price_table 价格表
     * @return string
     */
    function getLowestPrice($price_table)
    {
        $min = 0;
        $count = 0;
        foreach ((array)$price_table as $price) {
            if ($count++ == 0 || $price['price'] < $min) {
                $min = $price['price'];
            }
        }
        return $min > 0 ? '￥' . $min : 'Free';
    }
}

if (!function_exists('buildFormFromArr')) {
    /**
     * @param array $configs
     * @param \Encore\Admin\Form|\Encore\Admin\Widgets\Form $form
     * @param string $prefix
     */
    function buildFormFromArr(array $configs, $form, $prefix = '')
    {
        foreach ($configs as $key => $config) {
            $type = $config['type'];
            $label = $config['label'];
            unset($config['type'], $config['label']);
            $t = $form->$type($prefix . $key, $label);
            foreach ($config as $k => $v) {
                call_user_func_array([$t,$k],\Arr::wrap($v));
            }
        }
    }
}
