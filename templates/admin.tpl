{* admin.tpl *}                                                       
<!DOCTYPE html                                                                
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"                               
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">                    
<html>                                                                        
 <head>                                                                       
  <title>Administratorska stranica</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />      
  <link href="stil.css" type="text/css" rel="stylesheet" />              
 </head>                                                                      
 <body>                                                                       
  <table cellpadding="0" cellspacing="0" border="0" width="100%">             
    <tr>                                                                      
       <td>                                                                   
         <span class="NaslovAdmin">Administracija</span>                  
         <span class="AdminTekst">                                         
           (nazad na <a href="index.php">početnu stranicu</a> ili              
           <a href="admin.php?Stranica=Odjava">izlaz iz administracije</a>)                
         </span>                                                              
       </td>                                                                  
    </tr>                                                                     
  </table>                                                                    
  <br />                                                                      
  {include file="$sadrzajStranice"}                                               
 </body>                                                                      
</html>    