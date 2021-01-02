<script>
    function sendContact() {
        var valid;
        valid = validateContact();
        if(valid) {
            jQuery.ajax({
                url: "contact_mail.php",
                data:'&userName='+$("#userName").val()+'&userEmail='+$("#userEmail").val()+'&userMob='+$("#userMob").val()+'&subject='+$("#subject").val()+'&content='+$(content).val(),
                type: "POST",
                success:function(data){
                    $("#mail-status").html(data);
                },
                error:function (){}
            });
        }
    }

    function validateContact() {
        var valid = true;
        $(".form-control").css('background-color','');
        $(".info").html('');
        return valid;
    }
</script>
<?php
$toEmail = "info@demo.crispypicture.com";
$mailHeaders = "From: ". $_POST["userName"] . "<". $_POST["userEmail"] .">\r\n";
$content ="Mobile No:" .$_POST["userMob"] ."\r\n Message:" .$_POST["content"];
if(mail($toEmail, $_POST["subject"], $content , $mailHeaders)) {
    print "<p class='success'>Contact Mail Sent.</p>";
} else {
    print "<p class='Error'>Problem in Sending Mail.</p>";
}
?>