<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_by', 'input_type', 'label', 'note', 'placeholder', 'required', 'disabled', 'default', 'multiple', 'options'
    ];

    /* input type */
    const TYPE_TEXT = 1;
    const TYPE_SELECT = 2;
    const TYPE_NUMBER = 3;
    const TYPE_DATE = 4;
    const TYPE_CHECKBOX = 5;
    const TYPE_RADIO = 6;
    const TYPE_TEXTAREA = 7;
    const TYPE_FILE = 8;

    public static $input_type_labels = [
        self::TYPE_TEXT => 'Text input filed',
        self::TYPE_NUMBER => 'Number filed',
        self::TYPE_DATE => 'Select Date filed',
        self::TYPE_SELECT => 'Drop Down option',
        self::TYPE_CHECKBOX => 'Check box',
        self::TYPE_RADIO => 'Radio Button',
        self::TYPE_TEXTAREA => 'Text area for long paragraph',
        self::TYPE_FILE => 'Upload File',
    ];

    public static $input_types = [
        self::TYPE_TEXT => 'text',
        self::TYPE_NUMBER => 'number',
        self::TYPE_DATE => 'date',
        self::TYPE_CHECKBOX => 'checkbox',
        self::TYPE_FILE => 'file',
        self::TYPE_RADIO => 'radio',
        self::TYPE_SELECT => 'Drop Down option',
        self::TYPE_TEXTAREA => 'Text area for long paragraph',
    ];


    /* Validation array */
    public static $checkbox_validation = [
        'required',
        'disabled',
        'multiple',
    ];

    public static $placeholder_validation = [
        self::TYPE_TEXT,
        self::TYPE_NUMBER,
        self::TYPE_DATE,
        self::TYPE_TEXTAREA,
    ];

    public static $option_validation = [
        self::TYPE_SELECT,
        self::TYPE_CHECKBOX,
        self::TYPE_RADIO,
    ];

    public static $dynamic_tab_name = [
        self::TYPE_TEXT => '_input-tab',
        self::TYPE_NUMBER => '_number-tab',
        self::TYPE_DATE => '_date-tab',
        self::TYPE_SELECT => '_select-tab',
        self::TYPE_RADIO => '_radio-tab',
        self::TYPE_CHECKBOX => '_checkbox-tab',
        self::TYPE_FILE => '_upload-tab',
        self::TYPE_TEXTAREA => '_textarea-tab',
    ];

    /* Data dave format */
    public static $save_json_array = [
        'order_by' => false,
        'input_type' => false,
        'label' => false,
        'note' => false,
        'placeholder' => false,
        'required' => false,
        'multiple' => false,
        'disabled' => false,
        'default' => false,
        'options' => []
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->options = json_encode($model->options);
        });
        static::retrieved(function ($model) {
            $model->options = json_decode($model->options);
        });
    }
}
