<!DOCTYPE HTML>
<html>
<body>
<head>
<meta charset = "UTF-8">
</head>

<script>
    
   
 
  
     
   function getSelected(){
       // Get the selected score (assuming one was selected)
     var selected = document.querySelector('input[name="dummy_text3"]:checked').value;
       
        
       alert(selected + ' was selected!');
   }
</script>
<form method = "POST" >
 
   <fieldset>
        
        <legend> TELEFONNUMMER STIMMT</legend>
        <label for="dummy_text3"> JA<input type="radio" name="dummy_text3" value="1" id="TS"></label>
        <label for="dummy_text3"> NEIN<input type="radio" name="dummy_text3" value="0" id="TF"></label>
        <input type="submit" value="SUBMIT" onclick="getSelected();">
    </fieldset> 

</form>

</body>
</html>