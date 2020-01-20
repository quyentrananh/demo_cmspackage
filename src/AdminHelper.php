<?php

namespace Quyen\Cmspackage;

class AdminHelper
{
    public static $status = [
        1 => [
            'text' => 'admin.common.draft',
            'class' => 'btn-warning',
        ],
        2 => [
            'text' => 'admin.common.pending',
            'class' => 'btn-warning',
        ],
        3 => [
            'text' => 'admin.common.disable',
            'class' => 'btn-danger',
        ],
        4 => [
            'text' => 'admin.common.enable',
            'class' => 'btn-success',
        ]
    ];

    public static $emailOption = [
        1 => [
            'text' => 'Mail hoàn thành',
            'class' => 'btn-success',
            'type' => 'contest_confirm'
        ],
        2 => [
            'text' => 'Mail không hợp lệ',
            'class' => 'btn-warning',
            'type' => 'contest_invalid'
        ],
        3 => [
            'text' => 'Mail kêu gọi Share',
            'class' => 'btn-warning',
            'type' => 'contest_share'
        ]
    ];

    public static $yesNo = [
        0 => [
            'text' => 'admin.common.no',
            'class' => 'btn-danger',
        ],
        1 => [
            'text' => 'admin.common.yes',
            'class' => 'btn-success',
        ]
    ];

    public static function statusGroup($fieldName, $id, $current)
    {
        $currentInfo = [];
        foreach (self::$status as $value => $info){
            if ($current == $value) {
                $currentInfo = $info;
            }
        }

        $html[] = '<div class="btn-group btn-status-group">';
        $html[] = '<button type="button" class="btn btn-sm '.$currentInfo['class'].'">'.trans($currentInfo['text']).'</button>';
        $html[] = '<button type="button" class="btn btn-sm '.$currentInfo['class'].' dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $html[] = '<span class="sr-only">Toggle Dropdown</span>';
        $html[] = '</button>';
        $html[] = '<div class="dropdown-menu">';
        foreach (self::$status as $value => $info){
                $html[] = '<a data-action="update_status" 
                    data-id="'.$id.'" data-value="'.$value.'" data-field="'.$fieldName.'" 
                    class="dropdown-item option" href="javascript:void(0)">'.trans($info['text']).'</a>';
        }
        $html[] = '</div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function sendMailGroup($fieldName, $id)
    {

        $html[] = '<div class="btn-group btn-status-group">';
        $html[] = '<button type="button" class="btn btn-sm btn-success">Send</button>';
        $html[] = '<button type="button" class="btn btn-sm dropdown-toggle dropdown-toggle-split btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $html[] = '<span class="sr-only">Toggle Dropdown</span>';
        $html[] = '</button>';
        $html[] = '<div class="dropdown-menu">';
        foreach (self::$emailOption as $value => $info){
            $html[] = '<span data-action="" 
                    data-id="'.$id.'" data-value="'.$value.'" data-field="'.$fieldName.'" data-type="'.$info['type'].'"
                    class="dropdown-item send-mail" href="javascript:void(0)">'.trans($info['text']).'</span>';
        }
        $html[] = '</div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function yesNoGroup($fieldName, $id, $current)
    {
        $html[] = '<div class="btn-group btn-group-sm btn-status-group" role="group">';
        foreach (self::$yesNo as $value => $info){
            $html[] = '<button href="javascript:void(0)" data-action="update_yesno"  data-id="'.$id.'" data-value="'.$value.'" data-field="'.$fieldName.'" 
            type="button" class="option '.($current == $value ? $info['class'] : 'btn-outline-info').' btn ">'.trans($info['text']).'</a>';
        }
        $html[] = '</div>';

        return join('', $html);
    }

    public static function defaultGroup($fieldName, $id, $current)
    {
        $html[] = '<div class="btn-group btn-group-sm btn-status-group" role="group">';
        $html[] = '<button href="javascript:void(0)" data-action="update_default"  data-id="'.$id.'" data-value="1" data-field="'.$fieldName.'" 
            type="button" class="option '.($current == 1 ? 'btn-success' : 'btn-outline-info').' btn ">'.trans($current ? 'Yes' : 'No').'</a>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function orderingBtn($fieldName, $id, $current)
    {
        $html[] = '<span class="btn-order-group" style="width: 50px;">';
        $html[] = '<a href="javascript:void(0);" class="label label-info" data-action="update_ordering" data-id="'.$id.'" data-value="up" data-field="'.$fieldName.'"><i class="la la-angle-up"></i></a> ';
        $html[] = $current;
        $html[] = ' <a href="javascript:void(0);" class="label label-info" data-action="update_ordering" data-id="'.$id.'" data-value="down" data-field="'.$fieldName.'"><i class="la la-angle-down"></i></a>';
        $html[] = '</span>';

        return join('', $html);
    }

    public static function getNumberInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {
        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-xl-3 col-lg-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '<input type="number" '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control" minlength="1" maxlength="191" value="'.$value.'" name="'.$fieldName.'"/>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getTextInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {
        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-xl-3 col-lg-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '<input type="text" '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control" minlength="3" maxlength="191" value="'.$value.'" name="'.$fieldName.'"/>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getSwitchInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {

        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-xl-3 col-lg-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '    <span class="kt-switch kt-switch--icon">';
        $html[] = '        <label>';
        $html[] = '            <input type="checkbox" '.($value ? 'checked="checked"' : '').' value="1" name="'.$fieldName.'">';
        $html[] = '            <span></span>';
        $html[] = '        </label>';
        $html[] = '    </span>';
        //$html[] = '<input '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control" minlength="3" maxlength="191" value="'.$value.'" name="'.$fieldName.'"/>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getPasswordInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {
        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-xl-3 col-lg-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '<input type="password" '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control" minlength="3" maxlength="191" value="'.$value.'" name="'.$fieldName.'"/>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getEmailInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {
        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-xl-3 col-lg-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '<input type="email" '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control" minlength="3" maxlength="191" value="'.$value.'" name="'.$fieldName.'"/>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getTextareaInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {
        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-lg-3 col-xl-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '<textarea '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control" rows="3" name="'.$fieldName.'">'.$value.'</textarea>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getDateInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {
        $inputClass = 'datepiker' . time().rand(1, 1000);

        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-lg-3 col-xl-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '         <div class="input-group date">';
        $html[] =                '<input style="max-width:200px" '.($required ? 'required' : '').' type="text" class="form-control" placeholder="'.$placeHolder.'" id="' . $inputClass . '" value="'.$value.'" name="'.$fieldName.'">';
        $html[] =            '<div class="input-group-append">';
        $html[] =                '<span class="input-group-text"><i class="la la-calendar-check-o glyphicon-th"></i></span>';
        $html[] =           '</div>';
        $html[] =       '</div>';
        $html[] = '<script>';
        $html[] = '(function() { setTimeout(function(){ 
         $("#'. $inputClass .' ").datepicker({
            todayHighlight: true,
            autoclose: true,
            pickerPosition: "bottom-left",
            todayBtn: true,
            format: "yyyy/mm/dd"
        });
         }, 2000); })();';
        $html[] = '</script>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getDateTimeInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {
        $inputClass = 'datepiker' . time().rand(1, 1000);

        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-lg-3 col-xl-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '         <div class="input-group date">';
        $html[] =                '<input style="max-width:200px" '.($required ? 'required' : '').' type="text" class="form-control" placeholder="'.$placeHolder.'" id="' . $inputClass . '" value="'.$value.'" name="'.$fieldName.'">';
        $html[] =            '<div class="input-group-append">';
        $html[] =                '<span class="input-group-text"><i class="la la-calendar-check-o glyphicon-th"></i></span>';
        $html[] =           '</div>';
        $html[] =       '</div>';
        $html[] = '<script>';
        $html[] = '(function() { setTimeout(function(){ 
         $("#'. $inputClass .' ").datetimepicker({
            todayHighlight: true,
            autoclose: true,
            pickerPosition: "bottom-left",
            todayBtn: true,
            format: "yyyy/mm/dd hh:ii:ss"
        });
         }, 2000); })();';
        $html[] = '</script>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getEditorInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ')
    {
        $inputClass = time().rand(1, 1000);

        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-lg-3 col-xl-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-9">';
        $html[] = '         <textarea '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control" id="editor'.$inputClass.'" rows="3" name="'.$fieldName.'">'.$value.'</textarea>';
        $html[] = '         <a data-type="editor" data-value="editor'.$inputClass.'" data-preview="" class="btn btn-outline-primary btn-media btn-sm" href="javascript:void(0);"><i class="la la-picture-o"></i> Chèn Ảnh - Video</a>';
        $html[] = '         <a data-type="editor" data-value="editor'.$inputClass.'" class="btn btn-outline-primary btn-embeded btn-sm" href="javascript:void(0);"><i class="la la-code"></i> Chèn Mã nhúng Youtube</a>';
        $html[] = '    </div>';
        $html[] = '</div>';
        $html[] = '<script>';
        $html[] = '(function() { setTimeout(function(){ CKEDITOR.replace("editor'.$inputClass.'", {allowedContent: true}); }, 2000); })();';
        $html[] = '</script>';

        return join('', $html);
    }

    public static function getCropImageInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ', $size='800,600')
    {
        $inputClass = time().rand(1, 1000);

        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-lg-3 col-xl-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '    <div class="input-group">';
        $html[] = '         <input '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control image_value'.$inputClass.'" minlength="3" maxlength="191" value="'.$value.'" name="'.$fieldName.'"/>';
        $html[] = '        <div class="input-group-append">';
        $html[] = '            <button data-size="'.$size.'" data-preview=".image_preview'.$inputClass.'" data-value=".image_value'.$inputClass.'" class="btn-crop-image btn btn-primary" type="button">Browse...</button>';
        $html[] = '        </div>';
        $html[] = '    </div>';
        $html[] = '    <img class="image_preview'.$inputClass.'" src="'. url(!empty($value) ? $value : 'assets/lib/images/no-image.jpg') .'" style="width: 100px;">';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getSelectMediaInput($fieldTitle, $fieldName, $value = '', $required = false, $placeHolder =' ', $type='text')
    {
        $inputClass = time().rand(1, 1000);

        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-lg-3 col-xl-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '    <div class="input-group">';
        $html[] = '         <input '.($required ? 'required' : '').' placeholder="'.$placeHolder.'" class="form-control image_value'.$inputClass.'" minlength="3" maxlength="191" value="'.$value.'" name="'.$fieldName.'"/>';
        $html[] = '        <div class="input-group-append">';
        $html[] = '            <button data-type="'.$type.'" data-preview=".image_preview'.$inputClass.'" data-value=".image_value'.$inputClass.'" class="btn-media btn btn-primary" type="button">Browse...</button>';
        $html[] = '        </div>';
        $html[] = '    </div>';
        $html[] = '    <div class="image_preview'.$inputClass.'" style="width:100px">';
        $html[] = '         <img src="'. url(!empty($value) ? $value : 'assets/lib/images/no-image.jpg') .'" style="width: 100px;">';
        $html[] = '    </div>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }

    public static function getSelectInput($fieldTitle, $fieldName, $value = '', $required = false, $options =' ')
    {
        $html[] = '<div class="form-group row">';
        $html[] = '    <label for="example-text-input" class="col-lg-3 col-xl-3 col-form-label">'.$fieldTitle . ($required ? '<span style="color:red">*</span>' : '') .'</label>';
        $html[] = '    <div class="col-lg-9 col-xl-6">';
        $html[] = '        <select '.($required ? 'required' : '').' class="form-control" value="'.$value.'" name="'.$fieldName.'">';
        if($options && count($options)) {
            foreach ($options as $k=>$v){
                $html[] = '        <option value="'.$k.'" '.($value == $k ? 'selected' : '').'>'.$v.'</option>';
            }
        }
        $html[] = '        </select>';
        $html[] = '    </div>';
        $html[] = '</div>';

        return join('', $html);
    }
}
