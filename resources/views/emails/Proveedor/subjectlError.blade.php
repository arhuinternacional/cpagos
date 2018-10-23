<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  * {
    box-sizing: border-box;
  }
  #world{
    background: rgb(230,230,230) url("http://assets.cabify.com/emails/bg-grey.png");
  }
  .container{
    width: 50%;
    margin: auto;
  }
  .header{
    background-color:#2a86f5;
    color: #fff;
    padding: 10px;
  }
  #logo{
    position: relative;
    padding: 10px;
    width: 90px;
  }
  .image{
    padding: 0;
    background-color: #fff;
  }
  .main {
    background-color: #fff;
    color: #000;
    padding: 10px;
    text-align: justify;
  }
  .city{
    background-color: #2a86f5;
    padding: 10px;
    color: #FFF;
    text-align: center;
  }
  .btn{
    text-align: center;
  }
  .button{
    background-color: #555555;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
     border-radius: 10px;
  }
  .terms{
    font-size: 10px;
    color: #a0a0a0;
    line-height: 1.5em;
  }
  .column {
      float: left;
      width: 50%;
      background-color: #353454;
  }
  .footr:after {
      content: "";
      display: table;
      clear: both;
  }
  .redes{
    height: 25px;
  }
  .right{
    text-align: right;
    padding: 21px;
  }
  .left{
    padding: 31px;
  }
  .links{
    text-decoration: none;
    color: #fff;
  }
  #term:visited{
    color: blue;
  }

  @media only screen and (max-width:620px) {
    /* For mobile phones: */
    * {
      width:100%;
      font-size: 4vw;
    }
    .container{
      width: 80%;
    }
    h1{
          font-size: 5vw;
          width: 100%;
      }
    #term{
      font-size: 3vw;
    }
    #footr{
    background-color: #353454;
    }

    .column{
      float: none;
      width: 100%;
      text-align: left;
    }
    #logob{
      display: none;
    }
    .right .redes{
      width: 5vw;
    }
    #hearth{
      width: 5vw;
    }
    #world{
		background: rgb(230,230,230) url("http://assets.cabify.com/emails/bg-grey.png");
	}
  }
</style>
</head>
<body style="font-family:Verdana;color:#aaaaaa;background-color: rgb(230,230,230);">

  <div id="world">
    <div class="container">
    <div class="header">
      <img src="http://assets.cabify.com/brand/cabify_logo_full_360px--white.png" alt="" id="logo">
      <h1>Notificacion.</h1>
    </div>
    
    <div class="image">
      <img src="http://assets.cabify.com/brand/cabify_logo_full_360px--white.png" alt="" style="max-width:100%;">
    </div>

    <div class="main">
      <p>
          Hola socio/a.
          <br><br><br>

          {{ $message }}
          <br><br>
  
          Para corregir dicho error le invitamos a darle clic al siguiente enlace.
          <br><br>
        </p>
		
        <div class="btn">
        </div>
        <br></br>
        <p>*El usuario tiene 24 horas para procesar esta solicitud.</p>
        <br></br><br></br>
        <p class="terms"><a href="https://cabifyperu.pe/terminos.html" id="term">Términos y condiciones</a>  Estos datos serán usados para la  autorización de la tercerización de la factura electrónica al proveedor de servicios electrónicos Close2u. Estos datos no serán usados con otros fines distintos al párrafo anterior. Close2u Es un PSE , Prestador de servicios electrónicos, autorizado por la SUNAT. Los términos de la facturación electrónica los podrás visualizar en el contrato que deberá firmar  en el momento de su activación.</p>
    </div>

    
    <div class="city">
      <p><strong>La ciudad es tuya.</strong> El equipo Cabify.</p>
    </div>

    <div class="fol" style="height: 200px;">
      <div class="column left">
        <img src="http://assets.cabify.com/brand/cabify_logo_full_360px--white.png" alt="" id="logob" height="25px">
        <br/><br/>
        <a href="#" class="links">Centro de Ayuda</a>
        <br/><br/>
        <a href="#" class="links">Darse de Baja</a>
      </div>
      <div class="column right">
        
        <br/><br/><br/>
        Enviado con <img src="http://assets.cabify.com/emails/cabify-heart.png" alt="" height="26px" id="hearth">
        <br/><br/>
        ©2018 Cabify
      </div>
    </div>
  </div>
  
</body>
</html>