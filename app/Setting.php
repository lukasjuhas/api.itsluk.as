<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'setting_name', 'setting_value'
    ];

    /**
     * table
     * @var string
     */
    protected $table = 'settings';

    /**
     * primary key
     * @var string
     */
    public $primaryKey = 'setting_name';

    /**
     * disable incrementing
     * @var boolean
     */
    public $incrementing = false;

    /**
     * get setting
     * @param  string $setting_name
     * @return mixed
     */
    public static function get_setting($setting_name = '')
    {
        $setting = self::where('setting_name', $setting_name)->first();
        return json_decode($setting->setting_value);
    }

    /**
     * update setting
     * @param  string $setting_name
     * @param  mixed $value
     * @return mixed
     */
    public function update_setting($setting_name, $value)
    {
        $setting = $this->where('setting_name', $setting_name)->first();
        return $setting->update([
          'setting_value' => json_encode($value)
        ]);
    }
}
