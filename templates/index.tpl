{* smarty *}
{config_load file="web_site.conf"}
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hr" lang="hr">
	<head>
		<title>{#naslov_title#}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="reset.css" type="text/css" />
		<link rel="stylesheet" href="stil.css" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="container">

				<div class="grid6">
				{include file="zaglavlje.tpl"}
				</div>
				<div class="grid6 zadnji right">
				{include file="trazilica_forma.tpl"}
				</div>
				<div class="grid12 zadnji izbornik">
				{include file="podrucje.tpl"}
				</div>
				<div class="grid12 zadnji">
				<img src="slike_ms/velika.jpg"
				</div>
				<div class="grid4">
				<img src="slike_ms/1.png">
				</div>
				<div class="grid4">
				<img src="slike_ms/2.png">
				</div>
				<div class="grid4 zadnji">
				<img src="slike_ms/3.png">
				</div>
				<div class="grid3 cjeline">
				{include file="$cjelinaDioStranice"}
				</div>
				<div class="koma2 grid9 zadnji">
				{include file="$stoCeBitiNaHomePage"}
				</div>
				<div class="grid12 zadnji izbornik">
				{include file="dno_stranice.tpl"}
				</div>

		</div>
	</body>
</html>