// D'aquesta funci� no has de tocar res.
function getXMLHttp()
{
    var xmlHttp
    try
    {
        //Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    }
    catch(e)
    {
        //Internet Explorer
        try
        {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e)
        {
            try
            {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e)
            {
                alert("Your browser does not support AJAX!")
                return false;
            }
        }
    }
    return xmlHttp;
}

//Aqui posa-li el nom que vulguis a la funci� que �s la que has de posar a l'onchange, onclick etc.. dintre la funci� et poso la part que es pot modificar.
function vesA(page)
{
    if($("#container-emp").length!=0)
        {
           $('#container-emp').load('http://localhost/uf2DWS/PracticaZend3/public/info/generatelist/emp/'+$("#enviar").val()+'/page/'+page);
        }
        else
        {
            $('#container-proj').load('http://localhost/uf2DWS/PracticaZend3/public/info/generatelist/proj/'+$("#enviar").val()+'/page/'+page);
        }
}

function consultarDescp()
{
    var xmlHttp = getXMLHttp();
 
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4)
        {
            HandleResponse(xmlHttp.responseText);
        }
    }
	
	/*** MODIFICABLE****/
	//Jo aqui el que faig am tot aix� �s comprovar si ja hi ha l'alerta aquella amb la descripcio i si hi �s esborro el div. 
	//Tamb� creo un element ('img') per posar el .gif loading i els agrego. Javascript vaja
    var id_tasca=document.getElementById("form_tasca-tasca").value;
    if(document.getElementById('resultatCerca')){
        document.getElementById("form_tasca-element").removeChild(document.getElementById('resultatCerca'));
    }    
    var carregant = document.createElement('img');
    carregant.setAttribute('src','http://localhost/zend_practica/application/img/loading.gif');
    carregant.setAttribute('height','24px');
    carregant.setAttribute('width','24px');
    carregant.setAttribute('id','carregant');
    carregant.setAttribute('style','position:absolute;margin-top:-80px;margin-left:250px;');
    
    document.getElementById("form_tasca-element").appendChild(carregant); 
    
	/*************************************/
	
    xmlHttp.open("GET", 'http://localhost/zend_practica/public/info/generatelist/tasca/'+id_tasca, true); //aqui canviar URL + el que li passes per get.
    xmlHttp.send(null);
    
}

function HandleResponse(response)
{
	//Aqu� amb aquesta linia tens suficient:
	//document.getElementById('resultatCerca').innerHTML = response; resultatCerca es el id del div que vols omplir.
	// i el response es el que printes al .php que crides amb el get. Els echo que hem fet i l'exit.
	
	//la resta que he fet es el mateix que ha dalt.. eliminar si ja existex.. crear un element div i stils i omplir.
    document.getElementById("form_tasca-element").removeChild(document.getElementById('carregant'));
    
    var element = document.createElement('div');
    element.setAttribute('id','resultatCerca');
    document.getElementById("form_tasca-element").appendChild(element);
        
    document.getElementById('resultatCerca').setAttribute('style','-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;max-width:300px;position:absolute;margin-top:-90px;margin-left:250px;background-color:#E0DFDF;border:1px solid grey;padding:5px;');
    document.getElementById('resultatCerca').innerHTML = response;
    
}