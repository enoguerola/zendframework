// <![CDATA[
window.onload=function()
{

    $("#username").blur(function(){
       
        if($(this).val().length==0) 
        {
            $("#username").val("Username");
            $("#username").css("color","gray");
        }
        else
        {
            $("#username").css("color","black");
        }
    });
}
function habilitar()
{
    window.history.back();
}

// Cufon

//Cufon.replace('h1', { color: '-linear-gradient(#fff, #ffaf02)'});
//Cufon.replace('h1 small', { color: '#8a98a5'});

// ]]>