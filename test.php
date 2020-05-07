<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".p").click(function(e){
        alert($(e.currentTarget).attr("value"));//button text on which you clicked
    });
});
</script>
</head>
<body>

<input type='button' class="p" value='test'/>
<input type='button' class="p" value='test1'/>


</body>
</html>
