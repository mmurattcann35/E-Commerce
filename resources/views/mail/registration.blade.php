<div style="text-align: center; horiz-align: center">
    <h1>{{config('app.name')}}</h1>
    <p> Merhaba {{$user->name}}, kaydınız başarılı bir şekilde gerçekleşti.</p>
    <p> Kaydınızı aktifleştirmek için lütfen aşağıdaki bağlantıya tıklayın.</p>
    <br>
    <a href="{{config('app.url')}}/user/activation/{{$user->activation_key}}"
       style="border:1px solid dodgerblue ; color:dodgerblue; padding: 5px 10px; text-decoration: none;">Aktifleştir</a>
</div>
