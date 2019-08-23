@extends('layouts.backend.master')

@section('title','Ürün Düzenle')

@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px !important;
        }
    </style>
@endpush

@section('content')
    @include('layouts.backend.partial.validationerrors')
    <form action="{{route('admin.product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="form-group">
                <label for="categories">Kategori Seçimi</label>
                <select name="categories[]" id="categories" class="form-control" multiple="multiple">
                    @foreach($categories as $category)
                        @if($category->ust_id == 0 || $category->ust_id == null)
                            <option value="{{$category->id}}"
                                    {{collect(old('categories', $product_categories))->contains($category->id) ? "selected":""}} >
                                {{$category->name}}&nbsp;<small>(Üst Kategori)</small>
                            </option>
                        @else
                            <option value="{{$category->id}}"
                                    {{collect(old('categories', $product_categories))->contains($category->id) ? "selected":""}}>
                                {{$category->name}}&nbsp;<small>(Alt Kategori)</small>
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            @if($product->detail->image != null)
                <div class="form-group">
                    <label for="img">Mevcut Resim</label><br>
                    <img id="img" src="{{'/uploads/products/'.$product->detail->image}}" alt="{{$product->name}}" style="width: 250px; height: 180px;">
                </div>
            @endif

            <div class="form-group">
                <label for="image">Ürün Resmi</label>
                <input type="file" class="form-control hidden" id="image"  name="image">
                <label for="image" id="file_label" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp;&nbsp; Resim Yükle</label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tam Adı</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('name',$product->name)}}" name="name" placeholder="Başlık">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Fiyat</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('price',$product->price)}}"  name="price" placeholder="Fiyat">
            </div>
            <div class="form-group">
                <label for="description">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="7">{{old('description',$product->description)}}</textarea>
            </div>
            <div class="checkbox">
                <label  style="margin-left:10px">

                    {{--
                           * Eğer güncelleme ve kaydetme aynı formda olacaksa
                           * Checkbox alanları doldurulmazsa default olarak 0 alıyor.
                        <input type="hidden" name="is_active" value="0">
                    --}}
                    <input type="checkbox"
                        name="show_in_slider"
                        value="1"
                        {{old('show_in_slider',$product->detail->show_in_slider) ? "checked":""}}
                       > Sliderda Göster
                </label>
                <label  style="margin-left:10px">
                    <input type="checkbox"
                           name="show_product_of_day"
                           value="1"
                        {{old('show_product_of_day',$product->detail->show_product_of_day) ? "checked":""}}> Günün Ürünü
                </label>
                <label style="margin-left:10px">
                    <input type="checkbox"
                           name="show_ahead"
                           value="1"
                        {{old('show_ahead',$product->detail->show_ahead) ? "checked":""}}> Öne Çıkar
                </label>
                <label style="margin-left:10px">
                    <input type="checkbox"
                           name="show_discounted"
                           value="1"
                        {{old('show_discounted',$product->detail->show_discounted) ? "checked":""}} > İndirimli Ürünlerde Göster
                </label>
                <label style="margin-left:10px" >
                    <input type="checkbox"
                           name="show_best_seller"
                           value="1"
                        {{old('show_best_seller',$product->detail->show_best_seller) ? "checked":""}}> Çok Satanlarda Göster
                </label>
            </div>


        </div>

        <div class="form-group col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-primary form-control col-md-4">Kaydet</button>
            </div>

        </div>

    </form>
@endsection

@push('js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>

    <script>
        $(function(){
            $('#categories').select2({
                placeholder:"Lütfen Kategori Seçiniz..."
            });


            $("#file").change(function(){
                $("#file_label").html($(this).val().split("\\").splice(-1,1)[0] || "Select file");
            });

        });
    </script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#description' ));
    </script>
@endpush

