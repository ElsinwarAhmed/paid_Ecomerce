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
                                        <form class="form" action="{{route('admin.products.inventory.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="product_id" value="{{$product_id}}">
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-home"></i> بيانات المخزون للمنتج </h4>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> كود المنتج </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           placeholder=""
                                                                           value="{{$product -> sku}}"
                                                                           name="sku">
                                                                    @error("sku")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">تتبع للمستودع</label>
                                                                    <select name="manage_stock" id="manageStock" class="select2 form-controll" style="width: 100%">
                                                                        <optgroup label="من فضلك اختر النوع">
                                                                            <option value="0" {{$product -> manage_stock == 0 ? 'selected' : ''}}>عدم اتاحة التتبع</option>
                                                                            <option value="1" {{$product -> manage_stock == 1 ? 'selected' : ''}}>اتاحة التتبع</option>
                                                                        </optgroup>
                                                                    </select>
                                                                    @error("manage_stock")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            @if ($product -> manage_stock == 1)
                                                            <div class="col-md-6" id="qty" style="display: block">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">الكمية</label>
                                                                    <input type="number"
                                                                           class="form-control"
                                                                           placeholder=""
                                                                           value={{$product -> qty}}
                                                                           name="qty">
                                                                    @error("qty")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            @else
                                                            <div class="col-md-6" id="qty" style="display: none">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">الكمية</label>
                                                                    <input type="number"
                                                                           class="form-control"
                                                                           placeholder=""
                                                                           value= '0'
                                                                           name="qty">
                                                                    @error("qty")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            @endif


                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">حالة المنتج</label>
                                                                    <select name="in_stock" class="select2 form-controll" style="width: 100%">
                                                                        <optgroup label="من فضلك اختر ">
                                                                            <option value="1" {{$product -> in_stock == 1 ? 'selected' : ''}}>متاح </option>
                                                                            <option value="0" {{$product -> in_stock == 0 ? 'selected' : ''}}>عدم متاح </option>
                                                                        </optgroup>
                                                                    </select>
                                                                    @error("in_stock")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
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


@section('script')

<script>
    $('#manageStock').change(function (){
        if($(this).val() == 1){
            $('#qty').css('display', 'block');
        }else {
            $('#qty').css('display', 'none');

        }
    });

</script>

@endsection
