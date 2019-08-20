<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<scrpit src="{{asset('assets/frontend/js/app.js')}}"></scrpit>
@stack('js')
<script>

        setTimeout(function(){
            $('.flashAlert').slideUp(500);
        },3000);
</script>
