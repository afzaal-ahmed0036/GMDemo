@extends('template.tmp')
@section('title', 'Edit Dish Recipe')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- <script src="{{asset('assets/invoice/js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('assets/invoice/js/jquery-ui.min.js')}}"></script>
<script src="js/ajax.js"></script> -->
<!-- 
<script src="{{asset('assets/invoice/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/invoice/js/bootstrap-datepicker.js')}}"></script>  -->


<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<!-- multipe image upload  -->
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="multiple/dist/imageuploadify.min.css" rel="stylesheet">

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
    .form-control {
    display: block;
    width: 100%;
    padding: 0.47rem 0.75rem;
    font-size: .8125rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
     border-radius: 0rem !important; 
    -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;

}




.form-select {
    display: block;
    width: 100%;
    padding: 0.47rem 1.75rem 0.47rem 0.75rem;
    font-size: .8125rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e);
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0rem !important; 
}

.select2-container .select2-selection--single {
    background-color: #fff;
    border: 1px solid #ced4da;
    height: 38px
}
.select2-container .select2-selection--single:focus {
    outline: 0
}
.select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: .75rem;
    color: #495057
}
.select2-container .select2-selection--single .select2-selection__arrow {
    height: 34px;
    width: 34px;
    right: 3px
}
.select2-container .select2-selection--single .select2-selection__arrow b {
    border-color: #adb5bd transparent transparent transparent;
    border-width: 6px 6px 0 6px
}
.select2-container .select2-selection--single .select2-selection__placeholder {
    color: #495057
}
.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #adb5bd transparent!important;
    border-width: 0 6px 6px 6px!important
}
.select2-container--default .select2-search--dropdown {
    /*padding: 10px;*/
    background-color: #fff
}
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da;
    background-color: #fff;
    color: #74788d;
    outline: 0
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #556ee6
}
.select2-container--default .select2-results__option[aria-selected=true] {
    /*background-color: #f8f9fa;*/
    /*color: #343a40*/
}
.select2-container--default .select2-results__option[aria-selected=true]:hover {
    background-color: #556ee6;
    color: #fff
}
.select2-results__option {
    padding: 6px 12px
}
.select2-container[dir=rtl] .select2-selection--single .select2-selection__rendered {
    padding-left: .75rem
}
.select2-dropdown {
    border: 1px solid rgba(0, 0, 0, .15);
    background-color: #fff;
    -webkit-box-shadow: 0 .75rem 1.5rem rgba(18, 38, 63, .03);
    box-shadow: 0 .75rem 1.5rem rgba(18, 38, 63, .03)
}
.select2-search input {
    border: 1px solid #f6f6f6
}
.select2-container .select2-selection--multiple {
    min-height: 38px;
    background-color: #fff;
    border: 1px solid #ced4da!important
}
.select2-container .select2-selection--multiple .select2-selection__rendered {
    padding: 2px .75rem
}
.select2-container .select2-selection--multiple .select2-search__field {
    border: 0;
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field::-webkit-input-placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field::-moz-placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field:-ms-input-placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field::-ms-input-placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-search__field::placeholder {
    color: #495057
}
.select2-container .select2-selection--multiple .select2-selection__choice {
    background-color: #eff2f7;
    border: 1px solid #f6f6f6;
    border-radius: 1px;
    padding: 0 7px
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #ced4da
}
.select2-container--default .select2-results__group {
    font-weight: 600
}
.select2-result-repository__avatar {
    float: left;
    width: 60px;
    margin-right: 10px
}
.select2-result-repository__avatar img {
    width: 100%;
    height: auto;
    border-radius: 2px
}
.select2-result-repository__statistics {
    margin-top: 7px
}
.select2-result-repository__forks, .select2-result-repository__stargazers, .select2-result-repository__watchers {
    display: inline-block;
    font-size: 11px;
    margin-right: 1em;
    color: #adb5bd
}
.select2-result-repository__forks .fa, .select2-result-repository__stargazers .fa, .select2-result-repository__watchers .fa {
    margin-right: 4px
}
.select2-result-repository__forks .fa.fa-flash::before, .select2-result-repository__stargazers .fa.fa-flash::before, .select2-result-repository__watchers .fa.fa-flash::before {
    content: "\f0e7";
    font-family: 'Font Awesome 5 Free'
}
.select2-results__option--highlighted .select2-result-repository__forks, .select2-results__option--highlighted .select2-result-repository__stargazers, .select2-results__option--highlighted .select2-result-repository__watchers {
    color: rgba(255, 255, 255, .8)
}
.select2-result-repository__meta {
    overflow: hidden
}

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page titles -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h2>Edit Dish</h2>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{route('dish.edit',[$dish->id])}}">{{ucwords($dish->name)}}</a>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{route('dish.type',[$dish->id])}}">Dish Types</a>
                          </li>
                          <!-- <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{route('dish.image',[$dish->id])}}">Dish Images</a>
                          </li> -->
                          <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="{{route('dish.recipe',[$dish->id])}}">Dish Recipe</a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show active" role="tabpanel">
                            <form action="{{route('dish.recipe.store',[$dish->id])}}" method="post">
                                    @csrf
                                  <input type="hidden" name="dish_type_recipe_id" value="{{@$dish_type_recipe->id}}"> 
                                  <div class="row mt-4">
                                      <div class="col-md-2">
                                          <label>Dish Type <sup class="text-danger">*</sup></label>
                                      </div>
                                      <div class="col-md-6 form-group">
                                        <select class="form-select form-control-sm select2" name="dish_type_id" required>
                                            <option>Select Dish Type</option>
                                            @foreach($dish_types as $dish_type)
                                                <option value="{{$dish_type->id}}" {{@$dish_type_recipe->dish_type_id == $dish_type->id ? 'selected' : ''}}>{{$dish_type->type}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                  </div>
                                  <div class="row mt-4">
                                      <div class="col-md-2">
                                          <label>Item <sup class="text-danger">*</sup></label>
                                      </div>
                                      <div class="col-md-6 form-group">
                                        <select class="form-select form-control-sm select2" name="item_id" id="item" required>
                                            <option>Select Item</option>
                                            @foreach($kitchen_items as $item)
                                                <option value="{{$item->ItemID}}" {{@$dish_type_recipe->item_id == $item->ItemID ? 'selected' : ''}}>{{$item->ItemName}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                  </div>
                                  <div class="row mt-4">
                                      <div class="col-md-2">
                                          <label>Unit need to cook <sup class="text-danger">*</sup></label>
                                      </div>
                                      <div class="col-md-4 form-group">
                                          <div class="input-group mb-3">
                                              <input type="number" class="form-control" name="base_unit_amount_cooked" aria-label="Amount (to the nearest dollar)" value="{{@$dish_type_recipe->base_unit_amount_cooked}}" step="0.01" id="unit_input" required>
                                              <div class="input-group-append">
                                                <span class="input-group-text" id="unit">{{!empty($item_unit->base_unit)  ? $item_unit->base_unit : '.00'}}</span>
                                              </div>
                                            </div>
                                      </div>
                                      <div class="col-md-2">
                                          <label>Child Unit need to cook <sup class="text-danger">*</sup></label>
                                      </div>
                                      <div class="col-md-4 form-group">
                                          <div class="input-group mb-3">
                                              <input type="number" class="form-control" name="child_unit_amount_cooked" id="child_unit_input" step="0.01" aria-label="Amount (to the nearest dollar)" value="{{@$dish_type_recipe->child_unit_amount_cooked}}" required>
                                              <div class="input-group-append">
                                                <span class="input-group-text" id="childUnit">{{!(empty($item_unit->child_unit)) ? $item_unit->child_unit : '.00'}}</span>
                                              </div>
                                            </div>
                                      </div>
                                  </div>
                                  <div class="row mt-4">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <button type="submit" class="btn btn-success">{{@$dish_type_recipe ? 'Update Item to Recipe' : 'Add Item to Recipe'}}</button>
                                    </div>
                                    
                                  </div>
                              </form>
                          </div>
                    </div>
                    <hr>
                    @foreach($dish_recipes as $dish_type => $dish_recipe)
                        <h2>{{ucwords($dish_type)}}</h2>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Item Name</th>
                              <th scope="col">Unit</th>
                              <th scope="col">Child Unit</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i = 1; ?>
                            @forelse ($dish_recipe as $recipe)
                                  <th scope="row">{{$i}}</th>
                                  <td>{{ucwords($recipe->item->ItemName)}}</td>
                                  <td>{{$recipe->base_unit_amount_cooked}}&nbsp;{{$recipe->item->unit->base_unit}}</td>
                                  <td>{{$recipe->child_unit_amount_cooked}}&nbsp;{{$recipe->item->unit->child_unit}}</td>
                                  <td><a href="{{route('dish.recipe',['dish'=>$dish->id,'dish_recipe_id'=>$recipe->id])}}"><i class="bx bx-pencil align-middle me-1"></i></a>
                                    <a href="javascript:void(0)" onclick="delete_confirm2(`dishRecipeDelete`,'{{$recipe->id}}')"><i class="bx bx-trash  align-middle me-1"></i></a></td>
                                </tr>
                            <?php $i++; ?>
                            @empty
                                <tr>
                                  <td scope="row" colspan="6" align="center">No Dish recipes Available in &nbsp;<b>{{ucwords($dish_type)}}</b></td>
                                </tr>
                            @endforelse
                          </tbody>
                        </table><br>
                    @endforeach                    
                </div>
            </div>
    </div>
</div>


<!-- END: Content-->
<script type="text/javascript">    
    var convert_rate = {!! $item_unit ? $item_unit->unit_value : 0 !!};
    $(document).ready(function () {
        $("#unit_input").on('keyup', function () {
            if (convert_rate != 0) {
                $("#child_unit_input").val($("#unit_input").val() * convert_rate);
            }
        });
        $("#child_unit_input").on('keyup', function () {
            if (convert_rate != 0) {
                $("#unit_input").val($("#child_unit_input").val() / convert_rate);
            }
        });
        $("#item").on('change', function () {
            var item_id = $(this).val();
            $.ajax({
                type: 'GET',
                url: '{{url("get-unit-of-item")}}' +'/'+ item_id,
                success: function(data) {
                    $("#unit").text(data.base_unit);
                    $("#childUnit").text(data.child_unit);
                    convert_rate = data.unit_value;
                }
            });
        });

    });
    
</script>

@endsection