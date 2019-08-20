@extends('layouts.frontend.master')

@section('title','Ödeme Yap ')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="bg-content">

            <form action="{{route('payment')}}" method="POST">
                @csrf
            <h2>Ödeme</h2>
            <div class="row">
                <div class="col-md-5">
                    <h3>Ödeme Bilgileri</h3>
                    <div class="form-group">
                        <label for="kartno">Kredi Kartı Numarası</label>
                        <input type="text" class="form-control kredikarti" id="kartno" name="cardnumber" style="font-size:20px;" required>
                    </div>
                    <div class="form-group">
                        <label for="cardexpiredatemonth">Son Kullanma Tarihi</label>
                        <div class="row">
                            <div class="col-md-6">
                                Ay
                                <select name="cardexpiredatemonth" id="cardexpiredatemonth" class="form-control" required>
                                    @for($i = 1; $i<=12; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                Yıl
                                <select name="cardexpiredateyear" class="form-control" required>
                                    @php
                                            $date = date('Y')+15;
                                    @endphp
                                    @for($i=$date; $i >= 1950 ; $i--)
                                        <option value="{{$i}}" {{ $i == date('Y') ? "selected":""}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cardcvv2">CVV (Güvenlik Numarası)</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control kredikarti_cvv" name="cardcvv2" id="cardcvv2" required>
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" checked> Ön bilgilendirme formunu okudum ve kabul ediyorum.</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" checked> Mesafeli satış sözleşmesini okudum ve kabul ediyorum.</label>
                            </div>
                        </div>

                    <button type="submit" class="btn btn-success btn-lg">Ödeme Yap</button>
                </div>
                <div class="col-md-7 ">,
                    <div class="text-center ">
                        <h4>Ödenecek Tutar</h4>
                        <span class="price">{{\Gloudemans\Shoppingcart\Facades\Cart::total()}}<small>TL</small></span><hr>
                        <h4>İletişim ve Fatura Bilgileri</h4>
                        <div class="row">
                        <div class="col-md-4 form-group">
                            <label> Ad Soyad</label>
                            <input type="text" id="name" class="form-control" name="user_name" value="{{auth()->user()->name}}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label> Telefon</label>
                            <input type="text" id="phone" class="form-control" name="phone" value="{{$userDetail->phone}}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label> Cep Telefonu</label>
                            <input type="text" id="gsm_phone" class="form-control" name="gsm_phone" value="{{$userDetail->gsm_phone}}">
                        </div>
                        <div class="col-md-5 form-group">
                            <label> Adres</label>
                            <textarea id="address" class="form-control" name="address"  rows="6"> {{$userDetail->address}}</textarea>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script>
        $('.kredikarti').mask('0000-0000-0000-0000', { placeholder: "____-____-____-____" });
        $('.kredikarti_cvv').mask('000', { placeholder: "___" });
        $('.telefon').mask('(000) 000-00-00', { placeholder: "(___) ___-__-__" });
    </script>
@endpush

