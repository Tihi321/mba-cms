{* login.tpl *}
<!DOCTYPE html  
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>          
 <head>         
  <title>Login</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
  <link href="stil.css" type="text/css" rel="stylesheet" />
 </head>        
 <body>         
   Login
<br /><br />
Tipkajte svoje korisničko ime i zaporku ili se vratite na  
   <a href="index.php">početnu stranicu</a>
<br /> 
   {$admin_login->mLoginPoruka}
<br />        
  <form method="post" 
         action="login.php?ZelimOvuStranicu={$admin_login->mZelimOvuStranicu}">
   <table cellpadding="3" cellspacing="1" border="0">
    <tr>        
      <td>Korisničko ime:</td>
      <td>      
       <input type="text" name="korisnickoime" value="{$admin_login->mKorisnickoIme}" />
      </td>     
    </tr>       
    <tr>        
      <td>Zaporka:</td>
      <td>      
       <input type="password" value="" name="password" />
      </td>     
    </tr>       
    <tr>        
      <td colspan="2">
       <br />   
       <input class="button" type="submit" value="Login" name="Submit" />
      </td>                                                      
    </tr>                                                        
   </table>                                                      
  </form>                                                        
 </body>                                                         
</html>   