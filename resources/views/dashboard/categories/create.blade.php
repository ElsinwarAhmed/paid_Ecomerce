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
                                <li class="breadcrumb-item"><a href="{{route('admin.categories')}}"> الاقسام </a>
                                </li>
                                <li class="breadcrumb-item active">إضافة قسم
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
                                    <h4 class="card-title" id="basic-layout-form"> إضافة قسم  </h4>
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
                                        <form class="form" action="{{route('admin.categories.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            {{-- <div class="form-group">
                                                <label> صوره القسم </label>
                                                <label id="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="photo">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error('photo')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div> --}}

                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> اسم القسم </label>
                                                                    <input type="text" value="{{old('name')}}" id="name"
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
                                                                    <label for="projectinput1"> اسم القسم بالرابط </label>
                                                                    <input type="text" value="{{old('slug')}}" id="name"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="slug">
                                                                    @error("slug")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 hidden" id="cats_list">
                                                                <div class="form-group">
                                                                    <label>اختر القسم الرئيسي</label>
                                                                    <select name="parent_id" class="select2 form-control">
                                                                        <optgroup label="الاقسام الرئيسيية">
                                                                            @if($categories->count() >0)
                                                                            @foreach ($categories as $categorie)
                                                                            <option value="{{$categorie -> id}}">{{$categorie -> name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </optgroup>
                                                                    </select>
                                                                    @error("parent_id")
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


                                                            <div class="col-md-3">
                                                                <div class="form-group mt-1">
                                                                    <input type="radio" value="1"
                                                                           name="type"
                                                                           id="switcheryColor5"
                                                                           class="switchery"
                                                                           checked/>
                                                                    <label for="switcheryColor5" class="card-title ml-1">قسم رئيسي </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group mt-1">
                                                                    <input type="radio" value="2"
                                                                           name="type"
                                                                           id="switcheryColor6"
                                                                           class="switchery"/>
                                                                    <label for="switcheryColor6" class="card-title ml-1">قسم فرعي </label>
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


@section('script')

<script>
    $('input:radio[name="type"]').change(function () {
        if(this.value == '2' && this.checked){
            $('#cats_list').removeClass('hidden');
        } else {
            $('#cats_list').addClass('hidden');
        }
    });
</script>

@endsection
