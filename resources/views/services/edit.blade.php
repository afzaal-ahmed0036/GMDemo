@extends('template.tmp')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        @if (session('error'))
        <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
        {{ Session::get('error') }}
        </div>
        @endif
        @if (count($errors) > 0)
        <div>
        <div class="alert alert-danger p-1   border-3">
           <p class="font-weight-bold"> There were some problems with your input.</p>
            <ul>                    
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        </div>
        @endif
            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.service.title_singular') }}
                </div>

                <div class="card-body">
                    <form action="{{ route("admin.services.update", [$service->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">{{ trans('cruds.service.fields.name') }}*</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($service) ? $service->name : '') }}" required>
                            @if($errors->has('name'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.service.fields.name_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                            <label for="price">{{ trans('cruds.service.fields.price') }}</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ old('price', isset($service) ? $service->price : '') }}" step="0.01">
                            @if($errors->has('price'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.service.fields.price_helper') }}
                            </p>
                        </div>
                        <div>
                            <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection