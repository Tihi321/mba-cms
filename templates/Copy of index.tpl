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
	</head>
	<body>
		<div id="glavni">
			<div id="zaglavlje">
				<div class="clear"></div>
				<div id="logo">
					{include file="zaglavlje.tpl"}
				</div><!-- logo kraj-->
				<div id="trazilica">
					{include file="trazilica_forma.tpl"}
				</div><!-- trazilica kraj-->
				<div class="clear"></div>
			</div>
			<!-- zaglavlje kraj-->
			<div id="navigacija">
				{include file="podrucje.tpl"}
			</div>
			<!-- navigacija kraj-->
			<div id="tijelo">
				{include file="$cjelinaDioStranice"}
				{include file="$stoCeBitiNaHomePage"}
			</div>
			<!-- tijelo kraj-->
			<div id="podnozje">
				{include file="dno_stranice.tpl"}
				<p>
					<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
				</p>
			</div>
			<!-- podnozje kraj-->

		</div>
	</body>
</html>