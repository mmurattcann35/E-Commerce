@extends('layouts.backend.master')

@section('title','Ürün Ekle')

@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px !important;
        }
    </style>
@endpush

@section('content')
    @include('layouts.backend.partial.validationerrors')
    <form action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <div class="form-group">
                <label for="categories">Kategori Seçimi</label>
               <select name="categories[]" id="categories" class="form-control" multiple="multiple">
                   @foreach($categories as $category)
                       @if($category->ust_id == 0 || $category->ust_id == null)
                           <option value="{{$category->id}}">{{$category->name}}&nbsp;<small>(Üst Kategori)</small></option>
                       @else
                           <option value="{{$category->id}}">{{$category->name}}&nbsp;<small>(Alt Kategori)</small></option>
                       @endif
                   @endforeach
               </select>
            </div>
            <div class="form-group">
                <label for="image">Ürün Resmi</label>
                <input type="file" class="form-control hidden" id="image" value="{{old('image')}}" name="image"    >
                <label for="image" id="file_label" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp;&nbsp; Resim Yükle</label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tam Adı</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('name')}}" name="name" placeholder="Başlık">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Fiyat</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="{{old('price')}}"  name="price" placeholder="Fiyat">
            </div>
            <div class="form-group">
                <label for="description">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="7">{{old('description')}}</textarea>
            </div>
            <div class="checkbox">
                <label>

                    {{--
                           Eğer güncelleme ve kaydetme aynı formda olacaksa

                        <input type="hidden" name="is_active" value="0">
                    --}}
                    <input type="checkbox" name="show_in_slider"> Sliderda Göster
                </label>
                <label>
                    <input type="checkbox" name="show_product_of_day"> Günün Ürünü
                </label>
                <label>
                    <input type="checkbox" name="show_ahead"> Öne Çıkar
                </label>
                <label>
                    <input type="checkbox" name="show_discounted"> İndirimli Ürünlerde Göster
                </label>
                <label>
                    <input type="checkbox" name="show_best_seller"> Çok Satanlarda Göster
                </label>
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
        });

        $("#file").change(function(){
            $("#file_label").html($(this).val().split("\\").splice(-1,1)[0] || "Select file");
        });
    </script>

    <script>
        var options = {
            uiColor: '#f4645f',
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
        ClassicEditor.create(document.querySelector('#description'),options);
    </script>
@endpush

