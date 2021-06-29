@extends('layouts.admin')

@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href=""> المنتجات </a>
                                </li>
                                <li class="breadcrumb-item active">إضافة منتج
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> إضافة منتج جديد  </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{route('admin.products.general.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf


                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-home"></i> البيانات الاساسية للمنتج </h4>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> اسم المنتج </label>
                                                                    <input type="text" value="{{old('name')}}"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="name">
                                                                    @error("name")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> اسم المنتج بالرابط </label>
                                                                    <input type="text" value="{{old('slug')}}"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="slug">
                                                                    @error("slug")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">وصف المنتج</label>
                                                                    <textarea type="text" value="{{old('description')}}"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="description"></textarea>
                                                                    @error("description")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">الوصف المختصر</label>
                                                                    <textarea type="text" value="{{old('short_description')}}"
                                                                           class="form-control"
                                                                           name="short_description"></textarea>
                                                                    @error("short_description")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>اختر القسم</label>
                                                                    <select name="categories[]" class="select2 form-control" multiple style="width: 100%">
                                                                        <optgroup label="الاقسام">
                                                                            @if($categories->count() >0)
                                                                            @foreach ($categories as $category)
                                                                            <option value="{{$category -> id}}">{{$category -> name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </optgroup>
                                                                    </select>
                                                                    @error("category_id")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>اختر العلامات الدلالية</label>
                                                                    <select name="tags[]" class="select2 form-control" multiple style="width: 100%">
                                                                        <optgroup label="العلامات الدلالية">
                                                                            @if($tags->count() >0)
                                                                            @foreach ($tags as $tag)
                                                                            <option value="{{$tag -> id}}">{{$tag -> name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </optgroup>
                                                                    </select>
                                                                    @error("tag_id")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>اختر الماركة</label>
                                                                    <select name="brand_id" class="select2 form-control" style="width: 100%">
                                                                        <optgroup label="الماركات">
                                                                            @if($brands->count() >0)
                                                                            @foreach ($brands as $brand)
                                                                            <option value="{{$brand -> id}}">{{$brand -> name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </optgroup>
                                                                    </select>
                                                                    @error("brand_id")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>





                                                            <div class="col-md-6">
                                                                <div class="form-group mt-1">
                                                                    <input type="checkbox" value="1"
                                                                           name="is_active"
                                                                           id="switcheryColor4"
                                                                           class="switchery" data-color="success"
                                                                           checked/>
                                                                    <label for="switcheryColor4"
                                                                           class="card-title ml-1">الحالة </label>

                                                                    @error("active")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>

                                            </div>


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection
