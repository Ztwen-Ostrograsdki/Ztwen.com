<!-- Bootstrap core JavaScript -->
{{-- <script src="{{ asset('myvendor/jquery/jquery.min.js') }}" defer></script> --}}
{{-- <script src="{{ asset('myvendor/jquery/jquery.min.js') }}" defer></script> --}}
<script src="{{ asset('myvendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>


<!-- Additional Scripts -->
<script src="{{ asset('myassets/js/custom.js') }}" defer></script>
<script src="{{ asset('myassets/js/owl.js') }}" defer></script>
<script src="{{ asset('myassets/js/slick.js') }}" defer></script>
<script src="{{ asset('myassets/js/isotope.js') }}" defer></script>
<script src="{{ asset('myassets/js/accordions.js') }}" defer></script>


<script src="{{asset('registrationVendor/jquery/jquery.js')}}"></script>
<script src="{{asset('myassets/js/registration/global.js')}}"></script>
<script src="{{asset('myassets/js/registration/ztw.js')}}"></script>
<script language = "text/Javascript"> 
  cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
  function clearField(t){                   //declaring the array outside of the
  if(! cleared[t.id]){                      // function makes it static and global
      cleared[t.id] = 1;  // you could use true and false, but that's more typing
      t.value='';         // with more chance of typos
      t.style.color='#fff';
      }
  }


</script>


    @stack('modals')

    @livewireScripts
