</body>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">

$(document).ready(function(){
  $(".dropdown").hover(
      function() {
          $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideDown("fast");
          $(this).toggleClass('open');
      },
      function() {
          $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideUp("fast");
          $(this).toggleClass('open');
      }
  );
});
</script>
</html>
