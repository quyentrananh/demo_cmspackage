@extends('admin.layout')

@section('header')

@endsection

@section('content')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                {{ $item->id ? 'Sửa' : 'Thêm mới' }} Tin tức
            </h3>
            <span class="kt-subheader__separator kt-hidden"></span>
            <div class="kt-subheader__breadcrumbs">
                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">
                    Dashboard
                </a>

                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="{{ route($route) }}" class="kt-subheader__breadcrumbs-link">
                    Tin tức
                </a>
            </div>
        </div>
        <div class="kt-subheader__toolbar">
        </div>
    </div>
</div>
<!-- end:: Subheader -->

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <!--begin::Form-->
                {!! Form::open( ['url' => ($item->id ? route($route).'/'.$item->id : route($route)), 'method' => ($item->id ? 'PATCH' : 'POST'), 'class' => 'kt-form kt-form--label-right formData', 'name'=>'formData', 'files'=>true] ) !!}
                    <input type="hidden" name="_action" value="save"/>

                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-3 col-form-label">Chuyên mục</label>
                            <div class="col-9">
                                {!! Form::select('category_id', $selectCategory, $item->id ? $item->category_id : '', ['class'=>'form-control', 'required']) !!}
                            </div>
                        </div>

                        {!! \App\Helpers\AdminHelper::getTextInput('Tiêu đề', 'title', $item->title ? $item->title : '', true) !!}
                        {!! \App\Helpers\AdminHelper::getTextInput('Link bài viết', 'refer_link', $item->refer_link ? $item->refer_link : '', true) !!}
                        {!! \App\Helpers\AdminHelper::getDateInput('Ngày xuất bản', 'refer_date', $item->refer_date ? $item->refer_date : '', true) !!}
                        {!! \App\Helpers\AdminHelper::getCropImageInput('Ảnh đại diện (800x400)', 'image', $item->image ? $item->image : '', false, '', '800,400') !!}
                        {!! \App\Helpers\AdminHelper::getCropImageInput('Ảnh đại diện (400x400)', 'image2', $item->image2 ? $item->image2 : '', false, '', '400,400') !!}

                        {!! \App\Helpers\AdminHelper::getTextareaInput('Mô tả ngắn', 'introtext', $item->introtext ?? '', false, '') !!}
                        {!! \App\Helpers\AdminHelper::getEditorInput('Mô tả đầy đủ', 'fulltext', $item->fulltext ?? '', false, '') !!}
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-3">
                                </div>
                                <div class="col-9">
                                    <button type="submit" class="btn btn-primary btn-submit" data-action="save"><i class="la la-save"></i>@lang('admin.common.save')</button>
                                    <button type="submit" class="btn btn-success btn-submit" data-action="apply"><i class="la la-check"></i>@lang('admin.common.apply')</button>
                                    <a href="{{ route($route) }}" class="btn btn-secondary">@lang('admin.common.back')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
<!-- end:: Content -->
@endsection

@section('pageJs')
@endsection
