<?php 
include "session.php";
include "header.php";
$getContent = getGameRuleContent();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.26.0/ui/trumbowyg.min.css"/>
<form method="post" action="./controllers/game-rule-controller.php">
    <textarea name="gameRules" id="gameRules" required><?php echo $getContent['ruleContent'];?></textarea>
    <button type="button" name="pathAction" value="Update-Game-Rules" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-10" onclick="updateGameRules();">Update</button>
</form>

<!-- Import jQuery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
<!-- Import Trumbowyg -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.26.0/trumbowyg.min.js"></script>
<script>
    $('#gameRules').trumbowyg();

    function updateGameRules(){
        var formdata = new FormData();
        var gameRuleContent = $('#gameRules').trumbowyg('html');
        formdata.append("gameRuleContent", gameRuleContent);
        formdata.append("pathAction", 'Update-Game-Rules');
        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", completeHandler, false)
        ajax.open("POST", "./controllers/game-rule-controller.php");
        ajax.send(formdata);
    }
     
    function completeHandler(event){
        alert(event.target.responseText);
    }
</script>
<?php include "footer.php";?>