<?xml version="1.0" encoding="UTF-8"?>
<!-- edited with XMLSPY v2004 rel. 3 U (http://www.xmlspy.com) by tyr (odin) -->
<!DOCTYPE xsl:stylesheet [
	<!ENTITY copy "&#169;">
	<!ENTITY nbsp "&#160;">
	<!ENTITY uuml "&#252;">
	<!ENTITY ouml "&#246;">
	<!ENTITY auml "&#228;">
	<!ENTITY Uuml "&#220;">
	<!ENTITY Ouml "&#214;">
	<!ENTITY Auml "&#196;">
	<!ENTITY szlig "&#223;">
	<!ENTITY laquo "&#171;">
	<!ENTITY raquo "&#187;">
]>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="UTF-8" indent="no" media-type="text/html"/>
	<xsl:strip-space elements="*"/>
	<xsl:param name="lang"/>
	<xsl:param name="uid"/>
	<xsl:param name="user"/>
	<xsl:param name="role" select="'*'"/>
	<xsl:param name="ip"/>
	<xsl:param name="ua"/>
	<xsl:param name="sid"/>
	<xsl:param name="andsid"/>
	<xsl:param name="qsid"/>
	<xsl:param name="action"/>
	<xsl:param name="subaction"/>
	<xsl:param name="url"/>
	<xsl:param name="path"/>
	<xsl:param name="pathinfo"/>
	<xsl:param name="script"/>
	<xsl:param name="debug" select="0"/>
	<xsl:variable name="reference" select="/model/reference"/>
	<xsl:template match="@*" mode="copy">
		<xsl:copy/>
	</xsl:template>
	<xsl:template match="*" mode="copy">
		<xsl:copy>
			<xsl:apply-templates select="@*" mode="copy"/>
			<xsl:apply-templates mode="copy"/>
		</xsl:copy>
	</xsl:template>
	<xsl:template match="*"/>
	<xsl:template match="/">

		<html>

<!--  <xsl:text disable-output-escaping="yes"><![CDATA[<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">]]></xsl:text> -->
			<head>
				<title>
                                :: <xsl:value-of select="/model/document/@title"/> Diagprog :: DTS  &#160;Gr&#246;&#223;ter Serviceanbieter im Bereich Pixelfehlerreparatur und Tachoreparatur weltweit.
                                <!--xsl:for-each select="/model/path/document">
                                        <xsl:sort select="count(following-sibling::*)"/>
                                        &laquo; <xsl:value-of select="@title"/>
                                </xsl:for-each -->
				</title>
				<meta name="keywords" content="Pixelausfall, Pixelreparatur, Klimabedienteil, MID, LCD, Anzeige, Instrumentenkombi, Digitaltacho, 7er, 5er, W140, W202, Bedeinteil, Reparatur, Instandsetzung, Einheit, Kombi, Tacho, Cockpit, Tachoinstrumente, Tachometer, Kombiinstrument, Tachoeinstellung, Tachokorrektur, Diga-Consult, Kilometerstand, Pixelreparatur, Pixel, Service, BMW, Mercedes, Opel, Audi, VW, Professionelle, Tachoservice, digital, Tachos, Programmierung, E38, E39, X5, Cleaner, funktionierend, einstellen, D&#252;sseldorf, K&#246;ln, Neuss, Kaarst, Hannover"/>
				<meta name="description" content="Wir sind spezialisiert auf die Reparatur von Anzeigen in Tachometern, Klimabedienteilen und Bordcomputern bei BMW, Mercedes-Benz, Audi, Opel, Saab und VW."/>
				<meta name="author" content="Denal Pastuh"/>
				<link rev="made" href="info@tacho.biz"/>
				<meta name="copyright" content="Digital Tuning Service"/>
				<meta name="distribution" content="global"/>
				<!-- <meta name="robots" content="all" /> -->
				<LINK REL="SHORTCUT ICON" HREF="{/model/PORTAL/base}/favicon.ico"/>
				<link rel="stylesheet" href="{/model/PORTAL/base}/style/style.css" type="text/css"/>
				<script type="text/javascript">
                                portalbase = "<xsl:value-of select="/model/PORTAL/base"/>/";
                        </script>
				<script type="text/javascript" src="{/model/PORTAL/base}/style/common.js" language="javascript">
					<xsl:comment>
						<xsl:text>
                        </xsl:text>
					</xsl:comment>
				</script>
				<xsl:if test="$action='edit'">
					<script type="text/javascript">
                                          _editor_url = "<xsl:value-of select="/model/PORTAL/base"/>/htmlarea/";
                                          _editor_lang = "en";
                                </script>
					<script type="text/javascript" src="{/model/PORTAL/base}/htmlarea/htmlarea.js"/>
					<script type="text/javascript">
                                        var editor = null;
                                        HTMLArea.loadPlugin("ImageManager");
                                        HTMLArea.loadPlugin("TableOperations");
                                        function initEditors() {
                                                editor = new HTMLArea("content");
                                                editor.generate();
                                                return false;

                                        }
                                </script>
				</xsl:if>
			</head>
			<body onload="self.focus(); document.forms[0].name.focus();">
                <xsl:if test="/model/document/@name = 'process.xml'">
					<xsl:attribute name="onload">alert('HINWEIS: Sollte kein Fenster mit dem Auftragsformular erscheinen, klicken Sie bitte auf das Druckersymbol. Drucken Sie das Formular bitte in jedem Fall aus und legen Sie es dem Paket bei.'); window.open('./_print.php',''); </xsl:attribute>
				</xsl:if>
				<xsl:if test="$action='edit'">
					<xsl:attribute name="onload">initEditors();</xsl:attribute>
				</xsl:if>
				<xsl:apply-templates select="*"/>
				<xsl:call-template name="debug"/>
				<a hame="top"></a>
			</body>
		</html>
	</xsl:template>



	<xsl:template match="html | HTML">
		<xsl:apply-templates select="body/text() | BODY/text() | body/* | BODY/*" mode="copy"/>
	</xsl:template>




	<xsl:template name="debug">
		<xsl:param name="debug" select="$debug"/>
		<xsl:if test="$debug = 1">
			<xsl:comment> +DEBUG </xsl:comment>
			<div style="color: #CCCCCC; margin: 10px;">
				<small>
                lang = "<xsl:value-of select="$lang"/>"<br/>
                uid = "<xsl:value-of select="$uid"/>"<br/>
                user = "<xsl:value-of select="$user"/>"<br/>
                role = "<xsl:value-of select="$role"/>"<br/>
                sid = "<xsl:value-of select="$sid"/>"<br/>
                andsid = "<xsl:value-of select="$andsid"/>"<br/>
                qsid = "<xsl:value-of select="$qsid"/>"<br/>
                action = "<xsl:value-of select="$action"/>"<br/>
                url = "<a href="{$url}">
						<xsl:value-of select="$url"/>
					</a>"<br/>
                path = "<xsl:value-of select="$path"/>"<br/>
                pathinfo = "<xsl:value-of select="$pathinfo"/>"<br/>
                script = "<xsl:value-of select="$script"/>"<br/>
				</small>
			</div>
			<xsl:comment> -DEBUG </xsl:comment>
		</xsl:if>
	</xsl:template>



	<xsl:template name="sid">
		<xsl:if test="$sid">
			<input type="hidden" name="{substring-before($sid,'=')}" value="{substring-after($sid,'=')}"/>
		</xsl:if>
	</xsl:template>



	<xsl:template match="model">
		<xsl:apply-templates/>
	</xsl:template>




	<xsl:template match="/model/document">
		<table width="100%" cellspacing="1" cellpadding="0" border="0" class="rootTable">
			<tr>
				<td>
					<xsl:call-template name="header"/>
					<xsl:call-template name="main"/>
					<xsl:call-template name="footer"/>
				</td>
			</tr>
		</table>
	</xsl:template>


    <!-- Hier wird Kopf-Code fur jedes Seite erstellt -->

	<xsl:template name="header">
		<table width="100%" border="0" cellspacing="3" cellpadding="0" class="header">
			<tr valign="middle">
				<td class="header" colspan="1">
					<a href="{/model/PORTAL/base}/index.xml?!" title="Home">
						<img src="{/model/PORTAL/base}/style/logo.jpg" height="85" width="482" border="0"/>
					</a>
				</td>
			</tr>
			<tr valign="middle">
				<!-- td width="40" class="header"><img src="{/model/PORTAL/base}/style/t.gif" height="21" width="40"/></td -->
				<nobr>

            <!-- Aufruf von Navigationsmenu passierte hier -->

					<td class="doctitle">&nbsp;&nbsp;<xsl:call-template name="navi"/>
						<xsl:apply-templates select="directory-structure"/>
					</td>
				</nobr>
				<!-- td width="40" class="header"><img src="{/model/PORTAL/base}/style/t.gif" height="21" width="45"/></td -->
			</tr>
			<tr valign="middle">
				<td class="header">
					<img src="{/model/PORTAL/base}/style/t.gif" height="1" width="1"/>
				</td>
			</tr>
		</table>
	</xsl:template>




	<xsl:template name="langs">
		<nobr>
			<xsl:for-each select="$reference/lang/*[name() != 'item']">
				<xsl:sort select="name()"/>
				<xsl:if test="$lang != name()">
					<a href="{$pathinfo}?!&amp;_lang={name()}" title="{title}">
						<img src="{/model/PORTAL/base}/style/{name()}_light.gif" border="0" alt="{title}" title="{title}"/>
					</a>
				</xsl:if>
				<xsl:if test="$lang = name()">
					<img src="{/model/PORTAL/base}/style/{name()}.gif" border="0" alt="{title}" title="{title}"/>
				</xsl:if>
			</xsl:for-each>
		</nobr>
	</xsl:template>



	<xsl:template name="toolbar">
		<nobr>
			<xsl:if test="$user!=''">
				<a href="#" onclick="return turn(event, 'divAccount');">
					<img src="{/model/PORTAL/base}/style/account.gif" alt="{$reference/common/profile}" title="{$reference/common/profile}" border="0" hspace="4" vspace="0"/>
				</a>
				<div id="divAccount" class="account" style="display: none;">
					<xsl:value-of select="$user"/>
					<br/>
					<xsl:value-of select="$ip"/>
					<br/>
					<xsl:value-of select="$ua"/>
				</div>
			</xsl:if>
			<xsl:if test="$user=''">
				<a href="{/model/PORTAL/base}/admin.php">
					<img src="{/model/PORTAL/base}/style/lock.gif" alt="{$reference/common/authorization}" title="{$reference/common/authorization}" border="0" hspace="4" vspace="0"/>
				</a>
			</xsl:if>
			<xsl:if test="$action!='edit' and ($role = 'admin' or contains(concat(/model/document/@edit,','),concat('r:',$role,',')))">
				<a href="{$pathinfo}?action=edit">
					<img src="{/model/PORTAL/base}/style/edit.gif" alt="{$reference/common/edit}" title="{$reference/common/edit}" border="0" hspace="4" vspace="0"/>
				</a>
			</xsl:if>
			<xsl:if test="$action='edit'">
				<a href="{$pathinfo}?!&amp;action=view">
					<img src="{/model/PORTAL/base}/style/cancel.gif" alt="{$reference/common/cancel}" title="{$reference/common/cancel}" border="0" hspace="4" vspace="0"/>
				</a>
				<a href="#" onclick="if (document.forms['docform'].onsubmit()) document.forms['docform'].submit(); return false;">
					<img src="{/model/PORTAL/base}/style/save.gif" alt="{$reference/common/save}" title="{$reference/common/save}" border="0" hspace="4" vspace="0"/>
				</a>
			</xsl:if>
		</nobr>
	</xsl:template>




	<xsl:template name="sidebar">
		<xsl:if test="$action = 'edit'">
			<xsl:call-template name="properties"/>
		</xsl:if>
		<xsl:apply-templates select="/model/navigation-tree" mode="sidebar"/>
		<xsl:apply-templates select="/model/editing" mode="sidebar"/>
	</xsl:template>




	<xsl:template name="properties">
		<div class="sideblock">
			<table width="100%" class="sidecaption" border="0" cellspacing="0" cellpadding="0">
				<tr valign="middle">
					<td class="sidecaption">
						<a href="#" onclick="return turn(event,'props{generate-id()}')">
							<img src="{/model/PORTAL/base}/style/up.gif" width="8" height="8" alt="" align="baseline" border="0" hspace="2"/>
						</a>
                        &nbsp;<xsl:value-of select="$reference/portal/properties"/>
					</td>
				</tr>
			</table>
			<div id="props{generate-id()}" class="opened">
				<form name="propsform">
					<table border="0" cellspacing="0" cellpadding="0" class="properties">
						<xsl:if test="/model/document/@type = 'file' or /model/PORTAL/path != ''">
							<tr valign="top">
								<th class="propname">
									<xsl:choose>
										<xsl:when test="/model/document/@type = 'dir'">
											<xsl:value-of select="$reference/portal/dirname"/>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="$reference/portal/filename"/>
										</xsl:otherwise>
									</xsl:choose>
								</th>
								<td class="propvalue">
									<xsl:choose>
										<xsl:when test="/model/document/@type = 'dir' and /model/editing/item[@index = /model/document/@href]/error/invalidfoldername">
											<input class="propertyerror" name="dirname" type="text" size="16" value="{/model/PORTAL/folder}"/>
											<span title="{$reference/common/error/invalidfoldername}" class="errornote">*</span>
										</xsl:when>
										<xsl:when test="/model/document/@type = 'dir'">
											<input class="property" name="dirname" type="text" size="16" value="{/model/PORTAL/folder}"/>
										</xsl:when>
										<xsl:when test="/model/editing/item[@index = /model/document/@href]/error/invalidfilename">
											<nobr>
												<input class="propertyerror" name="filename" type="text" size="16" value="{substring-before(/model/PORTAL/doc,concat('.',/model/PORTAL/ext))}"/>
												<xsl:value-of select="concat('.',/model/PORTAL/ext)"/>
												<span title="{$reference/common/error/invalidfilename}" class="errornote">*</span>
											</nobr>
										</xsl:when>
										<xsl:otherwise>
											<nobr>
												<input class="property" name="filename" type="text" size="16" value="{substring-before(/model/PORTAL/doc,concat('.',/model/PORTAL/ext))}"/>
												<xsl:value-of select="concat('.',/model/PORTAL/ext)"/>
											</nobr>
										</xsl:otherwise>
									</xsl:choose>
								</td>
							</tr>
						</xsl:if>
						<tr valign="top">
							<th class="propname">
								<xsl:value-of select="$reference/portal/title"/>
							</th>
							<td class="propvalue">
								<xsl:call-template name="localized">
									<xsl:with-param name="nodeset" select="/model/document/title"/>
									<xsl:with-param name="name" select="'title'"/>
									<xsl:with-param name="mode" select="'edit'"/>
								</xsl:call-template>
							</td>
						</tr>
						<tr valign="top">
							<th class="propname">
								<xsl:value-of select="$reference/portal/annotation"/>
							</th>
							<td class="propvalue">
								<xsl:call-template name="localized">
									<xsl:with-param name="nodeset" select="/model/document/annotation"/>
									<xsl:with-param name="name" select="'annotation'"/>
									<xsl:with-param name="mode" select="'edit'"/>
								</xsl:call-template>
							</td>
						</tr>
						<tr valign="top">
							<th class="propname">
								<xsl:value-of select="$reference/portal/options/directory-structure"/>
							</th>
							<td class="propvalue">
								<input class="checkproperty" type="checkbox" name="directorystructure" value="1">
									<xsl:if test="/model/document/directory-structure">
										<xsl:attribute name="checked">checked</xsl:attribute>
									</xsl:if>
								</input>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</xsl:template>




	<xsl:template name="main">
		<xsl:variable name="sb">
			<xsl:choose>
				<xsl:when test="$action = 'edit' and $subaction = 'new'">1</xsl:when>
				<xsl:when test="/model/COOKIE/sb = 1">1</xsl:when>
				<xsl:when test="/model/COOKIE/sb = 0 or not(/model/COOKIE/sb)">0</xsl:when>
				<xsl:otherwise>0</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<xsl:variable name="sbon">
			<xsl:if test="$sb = 1">on</xsl:if>
			<xsl:if test="$sb = 0">off</xsl:if>
		</xsl:variable>
		<xsl:variable name="sboff">
			<xsl:if test="$sb = 1">off</xsl:if>
			<xsl:if test="$sb = 0">on</xsl:if>
		</xsl:variable>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr valign="bottom">
				<td align="left" width="4" height="20" style="background-image: url('{/model/PORTAL/base}/style/h_edge.gif'); background-repeat: repeat-x; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="20"/>
				</td>
				<td align="left" width="16%" class="tb">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr valign="middle">
							<td align="left" width="1">
								<img src="{/model/PORTAL/base}/style/t.gif" width="1" height="18"/>
							</td>
							<td align="left">
								<a href="#" onclick="return turnSidebar(event);">
									<img width="85" height="16" alt="*" border="0">
										<xsl:attribute name="src"><xsl:value-of select="/model/PORTAL/base"/>/style/tb_<xsl:if test="$sb = 1">up</xsl:if><xsl:if test="$sb = 0">down</xsl:if>.gif</xsl:attribute>
									</img>
								</a>
							</td>
							<td align="right" style="font-size: 8pt;" width="1">
								<xsl:call-template name="toolbar"/>
							</td>
						</tr>
					</table>
				</td>
				<td align="left" width="4" style="background-image: url('{/model/PORTAL/base}/style/h_edge.gif'); background-repeat: repeat-x; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/tb_r.gif" width="4" height="20"/>
				</td>
				<td class="{$sbon}" name="sbon" colspan="3" align="left" width="1" style="background-image: url('{/model/PORTAL/base}/style/h_edge.gif'); background-repeat: repeat-x; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/t.gif" width="1" height="20"/>
				</td>
				<td align="left" style="background-image: url('{/model/PORTAL/base}/style/h_edge.gif'); background-repeat: repeat-x; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/t.gif" width="1" height="20"/>
				</td>
				<td align="right" style="background-image: url('{/model/PORTAL/base}/style/h_edge.gif'); background-repeat: repeat-x; background-position: top left;">
					<xsl:call-template name="langs"/>
				</td>
				<td align="left" width="4" style="background-image: url('{/model/PORTAL/base}/style/h_edge.gif'); background-repeat: repeat-x; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="20"/>
				</td>
			</tr>
			<tr valign="top">
				<td align="left" width="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="1"/>
				</td>
				<td class="{$sbon}" name="sbon" align="left" style="background-color: #DDDDDD;">
					<img src="{/model/PORTAL/base}/style/t.gif" width="1" height="5"/>
				</td>
				<td class="{$sbon}" name="sbon" align="left" width="4" style="background-image: url('{/model/PORTAL/base}/style/tb_r2.gif'); background-repeat: repeate-y; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="5"/>
				</td>
				<td class="{$sbon}" name="sbon" colspan="3" align="left" width="1">
					<img src="{/model/PORTAL/base}/style/t.gif" width="1" height="5"/>
				</td>
				<td class="{$sboff}" name="sboff" align="left" style="background-image: url('{/model/PORTAL/base}/style/tb_b.gif'); background-repeat: repeat-x; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/tb_bl.gif" width="4" height="5"/>
				</td>
				<td class="{$sboff}" name="sboff" align="left" width="4">
					<img src="{/model/PORTAL/base}/style/tb_br.gif" width="4" height="5"/>
				</td>
				<td align="left" colspan="2">
					<img src="{/model/PORTAL/base}/style/t.gif" width="1" height="5"/>
				</td>
				<td align="left" width="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="5"/>
				</td>
			</tr>
			<tr valign="top">
				<td align="left" width="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="1"/>
				</td>
				<td class="{$sbon}" name="sbon" align="left" style="background-color: #DDDDDD;">
					<xsl:call-template name="sidebar"/>
				</td>
				<td class="{$sbon}" name="sbon" align="left" width="4" style="background-image: url('{/model/PORTAL/base}/style/tb_r2.gif'); background-repeat: repeate-y; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="5"/>
				</td>
				<td class="{$sbon}" name="sbon" align="left" width="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="1"/>
				</td>
				<td align="left" colspan="4" class="content">
					<!-- xsl:apply-templates select="directory-structure"/ -->
					<xsl:call-template name="localized">
						<xsl:with-param name="nodeset" select="content"/>
						<xsl:with-param name="name" select="'content'"/>
					</xsl:call-template>
				</td>
				<td align="left" width="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="5"/>
				</td>
			</tr>
			<tr valign="top">
				<td align="left" width="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="1"/>
				</td>
				<td class="{$sbon}" name="sbon" align="left" style="background-image: url('{/model/PORTAL/base}/style/tb_b.gif'); background-repeat: repeat-x; background-position: top left;">
					<img src="{/model/PORTAL/base}/style/tb_bl.gif" width="4" height="5"/>
				</td>
				<td class="{$sbon}" name="sbon" align="left" width="4">
					<img src="{/model/PORTAL/base}/style/tb_br.gif" width="4" height="5"/>
				</td>
				<td class="{$sbon}" name="sbon" align="left" width="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="1"/>
				</td>
				<td align="left" colspan="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="5"/>
				</td>
				<td align="left" width="4">
					<img src="{/model/PORTAL/base}/style/t.gif" width="4" height="5"/>
				</td>
			</tr>
		</table>
	</xsl:template>



	<xsl:template name="navi">
		<a href="{/model/PORTAL/base}/index.xml?!" class="doctitle" title="/">
			<xsl:value-of select="/model/navigation-tree/dir/document/title"/>
		</a>
	</xsl:template>



	<xsl:template name="document-title">
		<xsl:for-each select="/model/path/document">
			<span class="path">
				<a href="{@href}?!" class="doctitle">
					<xsl:value-of select="@title"/>
				</a>
			</span>
		</xsl:for-each>
		<a href="{$pathinfo}?!" class="doctitle">
			<xsl:value-of select="@title"/>
		</a>
	</xsl:template>
	<xsl:template match="content/text()">
		<xsl:choose>
			<xsl:when test="$action='edit'">
				<xsl:value-of select="."/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of disable-output-escaping="yes" select="."/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>



	<xsl:template match="content/*">
		<xsl:apply-templates select="." mode="copy"/>
	</xsl:template>



	<xsl:template match="content">
		<xsl:param name="mode"/>
		<xsl:call-template name="content">
			<xsl:with-param name="mode" select="$mode"/>
		</xsl:call-template>
	</xsl:template>




	<xsl:template name="content">
		<xsl:param name="mode"/>
		<xsl:variable name="cnode" select="name() = 'content'"/>
		<div class="content">
			<xsl:choose>
				<xsl:when test="$action='edit'">
					<xsl:call-template name="content-edit-pre"/>
					<form name="docform" action="{$pathinfo}" method="post" enctype="multipart/form-data" onsubmit="return checkDocumentForm();">
						<input type="hidden" name="action" value="save"/>
						<input type="hidden" name="filename" value="[null]"/>
						<input type="hidden" name="dirname" value="[null]"/>
						<input type="hidden" name="title" value="[null]"/>
						<input type="hidden" name="defaulttitle" value="[null]"/>
						<input type="hidden" name="annotation" value="[null]"/>
						<input type="hidden" name="defaultannotation" value="[null]"/>
						<input type="hidden" name="directorystructure" value="[null]"/>
						<xsl:if test="$cnode and not(@xml:lang)">
							<input type="hidden" name="defaultcontent" value="1"/>
						</xsl:if>
						<textarea name="content" id="content" style="width: 100%;" rows="30" cols="80">
							<xsl:if test="$cnode">
								<xsl:apply-templates/>
							</xsl:if>
						</textarea>
						<br/>
						<div style="width: 100%;">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr valign="middle">
									<td width="35%" align="left">
                                        &nbsp;
                                </td>
									<td width="30%" align="center">
                                        &nbsp;
                                </td>
									<td width="35%" align="right">
										<input type="submit" class="save" value="{$reference/common/save}"/>
									</td>
								</tr>
							</table>
						</div>
					</form>
					<xsl:call-template name="content-edit-post"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:if test="$cnode">
						<xsl:call-template name="content-view-pre"/>
						<xsl:apply-templates/>
						<xsl:call-template name="content-view-post"/>
						<div class="signature">
							<xsl:if test="@editor != '' and @modified != ''">
								<xsl:value-of select="$reference/portal/modified"/>: <xsl:if test="$user!=''">
									<xsl:apply-templates select="@editor"/>
									<br/>
								</xsl:if>
								<xsl:apply-templates select="@modified"/>
							</xsl:if>
						</div>
					</xsl:if>
				</xsl:otherwise>
			</xsl:choose>
		</div>
	</xsl:template>



	<xsl:template match="title">
		<xsl:param name="mode"/>
		<xsl:call-template name="title">
			<xsl:with-param name="mode" select="$mode"/>
		</xsl:call-template>
	</xsl:template>



	<xsl:template name="title">
		<xsl:param name="mode"/>
		<xsl:choose>
			<xsl:when test="$mode = 'edit'">
				<input type="text" name="title" class="property">
					<xsl:attribute name="value"><xsl:if test="name() = 'title'"><xsl:value-of select="text()"/></xsl:if></xsl:attribute>
				</input>
				<xsl:if test="name() = 'title' and not(@xml:lang)">
					<input type="hidden" name="checkproperty" value="1"/>
				</xsl:if>
			</xsl:when>
			<xsl:otherwise>
				<xsl:if test="name() = 'title'">
					<div class="title">
						<xsl:value-of select="text()"/>
					</div>
				</xsl:if>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="annotation">
		<xsl:param name="mode"/>
		<xsl:call-template name="annotation">
			<xsl:with-param name="mode" select="$mode"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template name="annotation">
		<xsl:param name="mode"/>
		<xsl:choose>
			<xsl:when test="$mode = 'edit'">
				<input type="text" name="annotation" class="property">
					<xsl:attribute name="value"><xsl:if test="name() = 'annotation'"><xsl:value-of select="text()"/></xsl:if></xsl:attribute>
				</input>
				<br/>
				<xsl:if test="name() = 'annotation' and not(@xml:lang)">
					<input type="hidden" name="checkproperty" value="1"/>
				</xsl:if>
			</xsl:when>
			<xsl:otherwise>
				<xsl:if test="name() = 'annotation'">
					<xsl:value-of select="."/>
				</xsl:if>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

    <!-- hier wird ein Navigationslink erstellt -->

	<xsl:template match="dir | file | link" mode="directory-structure">
		<nobr>&nbsp;&nbsp;<img src="{/model/PORTAL/base}/style/delim.gif" alt="" align="baseline" width="11" height="11"/>&nbsp;&nbsp;

                <!--
                <xsl:value-of select="name()" />
                -->
				<a href="{document/@href}?!">
				<xsl:attribute name="class">doctitle<xsl:if test="document/@href = /model/document/@href">Selected</xsl:if></xsl:attribute>
				<xsl:attribute name="title"><xsl:call-template name="localized"><xsl:with-param name="nodeset" select="document/annotation"/></xsl:call-template></xsl:attribute>
				<xsl:value-of select="document/@title"/>
				<xsl:if test="document/@href = /model/document/@href">
					<span title="{$reference/portal/current-document}" class="note"/>
				</xsl:if>
			</a>
			<xsl:if test="name()= 'dir'">
                <!-- + -->
                </xsl:if>
		</nobr>
	</xsl:template>

    <!-- hier wird eine Navigationsmenu erstellt -->

	<xsl:template match="directory-structure">

		<xsl:if test="dir[document] or file[document] or link[document] or ($action = 'edit' and /model/document/@type = 'dir')">
			<span class="directory">
				<xsl:if test="dir[document]">
					<xsl:apply-templates select="dir" mode="directory-structure">
						<xsl:sort select="document/@href"/>
					</xsl:apply-templates>
				</xsl:if>
				<xsl:if test="file[document]">
					<xsl:apply-templates select="file" mode="directory-structure">
						<xsl:sort select="document/@href"/>
					</xsl:apply-templates>
				</xsl:if>
				<xsl:if test="link[document]">
					<xsl:apply-templates select="link" mode="directory-structure">
						<xsl:sort select="document/@title"/>
					</xsl:apply-templates>
				</xsl:if>
				<xsl:if test="$action = 'edit' and /model/document/@type = 'dir'">
					<br/>
					<form name="create" action="{/model/document/@href}" method="post">
						<input type="hidden" name="action" value="new"/>
						<input type="radio" name="type" value="dir" class="newdir"/>
						<img src="{/model/PORTAL/base}/style/dir.gif" alt="" align="middle"/>
						<input type="radio" name="type" value="file" class="newfile" checked="checked"/>
						<img src="{/model/PORTAL/base}/style/file.gif" alt="" align="middle"/>
						<xsl:text> </xsl:text>
						<input type="text" name="basename" size="10" class="basename"/>
						<xsl:text> </xsl:text>
						<input type="submit" class="create" value="{$reference/common/create}"/>
					</form>
				</xsl:if>
			</span>
		</xsl:if>
	</xsl:template>



	<xsl:template name="footer">
		<div class="footer">
			<table width="100%" class="footer" border="0" cellspacing="0" cellpadding="4">
				<tr valign="top">
					<td align="left" width="35%" class="footer">
                                &nbsp;
                        </td>
					<td align="center" width="30%" class="footer">
                        &copy;&nbsp;2004&nbsp;digital-tuning-service.de
                        </td>
					<td align="right" width="35%">
						<xsl:if test="@author != '' and @created != ''">
							<div class="signature">
								<xsl:value-of select="$reference/portal/created"/>: <xsl:if test="$user!=''">
									<xsl:apply-templates select="@author"/>
									<br/>
								</xsl:if>
								<xsl:apply-templates select="@created"/>
							</div>
						</xsl:if>
					</td>
				</tr>
			</table>
		</div>
	</xsl:template>



	<xsl:template match="/model/navigation-tree" mode="sidebar">
		<div class="sideblock">
			<table width="100%" class="sidecaption" border="0" cellspacing="0" cellpadding="0">
				<tr valign="middle">
					<td class="sidecaption">
						<a href="#" onclick="return turnAndStore(event,'div{generate-id()}','n')">
							<img width="8" height="8" alt="" align="baseline" border="0" hspace="2">
								<xsl:attribute name="src"><xsl:value-of select="/model/PORTAL/base"/>/style/<xsl:if test="/model/COOKIE/n = 1 or not(/model/COOKIE/n)">up</xsl:if><xsl:if test="/model/COOKIE/n = 0">down</xsl:if>.gif</xsl:attribute>
							</img>
						</a>
                        &nbsp;<xsl:value-of select="$reference/portal/navigation-tree"/>
					</td>
				</tr>
			</table>
			<div id="div{generate-id()}">
				<xsl:attribute name="class"><xsl:if test="/model/COOKIE/n = 1 or not(/model/COOKIE/n)">opened</xsl:if><xsl:if test="/model/COOKIE/n = 0">closed</xsl:if></xsl:attribute>
				<div class="navtree">
					<xsl:apply-templates select="dir | file" mode="navigation-tree">
						<xsl:sort select="name()"/>
					</xsl:apply-templates>
				</div>
			</div>
		</div>
	</xsl:template>



	<xsl:template match="editing" mode="sidebar">
		<xsl:if test="count(item) &gt; 1 or item[@index != /model/document/@href]">
			<div class="sideblock">
				<table width="100%" class="sidecaption" border="0" cellspacing="0" cellpadding="0">
					<tr valign="middle">
						<td class="sidecaption">
							<a href="#" onclick="return turn(event,'div{generate-id()}')">
								<img src="{/model/PORTAL/base}/style/up.gif" width="8" height="8" alt="" align="baseline" border="0" hspace="2"/>
							</a>
                        &nbsp;<xsl:value-of select="$reference/portal/editing"/>
						</td>
					</tr>
				</table>
				<div id="div{generate-id()}" class="opened">
					<table width="100%" cellspacing="2" cellpadding="2" border="0">
						<xsl:for-each select="item[title]">
							<xsl:sort select="title"/>
							<tr valign="top">
								<td class="sidebar" align="left" width="1">
									<xsl:value-of select="position()"/>.</td>
								<td class="sidebar" align="left">
									<a href="{@index}?!">
										<xsl:value-of select="title"/>
									</a>
									<xsl:if test="@index = /model/document/@href">
										<span title="{$reference/portal/current-document}" class="note">*</span>
									</xsl:if>
								</td>
								<td class="sidebar" align="right">
									<a href="{@index}?!&amp;action=view">
										<img src="{/model/PORTAL/base}/style/cancel8.gif" alt="{$reference/common/cancel}" title="{$reference/common/cancel}" border="0" align="bottom"/>
									</a>
								</td>
							</tr>
						</xsl:for-each>
					</table>
				</div>
			</div>
		</xsl:if>
	</xsl:template>

   <!-- Ausklappbare menu links -->

	<xsl:template match="dir | file" mode="navigation-tree">
		<div class="tree{name()}">
			<xsl:apply-templates select="document" mode="navigation-tree-item"/>
			<xsl:if test="name() = 'dir' and (dir or file)">

				<xsl:apply-templates select="dir | file" mode="navigation-tree">
					<xsl:sort select="name()"/>
					<xsl:sort select="document/@href"/>
				</xsl:apply-templates>

			</xsl:if>
		</div>
	</xsl:template>

    <!-- Ausklappbare Menu links -->

	<xsl:template match="document" mode="navigation-tree-item">
		<xsl:variable name="lName" select="title[lang($lang)]"/>
		<img src="{/model/PORTAL/base}/style/{name(..)}.gif" alt="" align="baseline"/>&nbsp;<a href="{@href}?!">
			<xsl:attribute name="class">dir<xsl:if test="@href = /model/document/@href">Selected</xsl:if></xsl:attribute>
			<xsl:if test="@title=/model/navigation-tree/dir/document/title">
				<xsl:value-of select="@title"/>
			</xsl:if>
			<xsl:if test="not(@title=/model/navigation-tree/dir/document/title)">
				<xsl:value-of select="@title"/>
			</xsl:if>
		</a>
	</xsl:template>



	<xsl:template name="localized">
		<xsl:param name="nodeset" select="."/>
		<xsl:param name="name" select="''"/>
		<xsl:param name="mode"/>
		<xsl:choose>
			<xsl:when test="$nodeset[lang($lang)]">
				<xsl:apply-templates select="$nodeset[lang($lang)]">
					<xsl:with-param name="mode" select="$mode"/>

				</xsl:apply-templates>
			</xsl:when>
			<xsl:when test="$nodeset[lang($reference/lang/@default)]">
				<xsl:apply-templates select="$nodeset[lang($reference/lang/@default)]">
					<xsl:with-param name="mode" select="$mode"/>
				</xsl:apply-templates>
			</xsl:when>
			<xsl:when test="$nodeset[not(@xml:lang)]">
				<xsl:apply-templates select="$nodeset[not(@xml:lang)]">
					<xsl:with-param name="mode" select="$mode"/>
				</xsl:apply-templates>
			</xsl:when>
			<xsl:when test="$name = 'title'">
				<xsl:call-template name="title">
					<xsl:with-param name="mode" select="$mode"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:when test="$name = 'annotation'">
				<xsl:call-template name="annotation">
					<xsl:with-param name="mode" select="$mode"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:when test="$name = 'content'">
				<xsl:call-template name="content">
					<xsl:with-param name="mode" select="$mode"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
                </xsl:otherwise>
		</xsl:choose>
	</xsl:template>



	<xsl:template match="@modified | @created">
		<xsl:if test=". != '' and string-length(.) = 14">
			<xsl:value-of select="substring(.,1,4)"/>-<xsl:value-of select="substring(.,5,2)"/>-<xsl:value-of select="substring(.,7,2)"/>
			<xsl:text> </xsl:text>
			<xsl:value-of select="substring(.,9,2)"/>:<xsl:value-of select="substring(.,11,2)"/>:<xsl:value-of select="substring(.,13,2)"/>
		</xsl:if>
	</xsl:template>



	<xsl:template name="content-edit-pre"/>
	<xsl:template name="content-edit-post"/>
	<xsl:template name="content-view-pre"/>
	<xsl:template name="content-view-post"/>
</xsl:stylesheet>