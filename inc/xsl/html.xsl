<?xml version="1.0" encoding="windows-1251"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output encoding="UTF-8" method="html" indent="yes" omit-xml-declaration="yes" media-type="text/html"/>

	<xsl:template match="/">
		<html>
		<head>
			<style>
			body, p, td, div, span { font-family: verdana, sans-serif; }
			span.off { display: none; font-weight: normal; }
			span.on  { display: inline; font-weight: normal; }
			div.off	{ margin: 0px; margin-left: 20px; display: none;  }
			div.on	{ margin: 0px; margin-left: 20px; display: block; }
			div.tag 	{ font-weight: bold; font-size: 10pt; }
			span.tagEx 	{ font-weight: normal; color: #660000; cursor: pointer; }
			span.tag 	{ font-weight: normal; color: #660000; }
			span.attribute	{ font-weight: normal; color: #000066; }
			span.attribute_name { font-weight: normal; color: #006600; }
			div.closed { margin: 0px; display: none; border: 1px solid #708090; }
			div.opened { margin: 0px; display: block; border: 1px solid #708090; }
			</style>
			<script type="text/javascript"> 
			<xsl:comment><xsl:text>
                        function turn(e, o_id){
				obj = document.getElementById(o_id);
                        	if (obj.className == 'off') {
                        		obj.className = 'on';
                        	} else if (obj.className == 'on') {
                        		obj.className = 'off';
                        	} else if (obj.className == 'closed') {
                        		obj.className = 'opened';
                        	} else if (obj.className == 'opened') {
                        		obj.className = 'closed';
                        	}
                        	return false;
                        }
			</xsl:text></xsl:comment>
			</script>
		</head>
		<body>
		<xsl:apply-templates/>
		</body>
		</html>
	</xsl:template>

	<xsl:template match="*">
	<div class="tag">
		<xsl:choose>
		<xsl:when test="*">
		<span class="tagEx" id="Tag{generate-id()}" onclick="turn(event,'dotsTag{generate-id()}'); return turn(event,'divTag{generate-id()}');">&lt;<xsl:value-of select="name()"/></span><span class="tag"><xsl:apply-templates select="@*"/>&gt;</span>
		<span class="off" id="dotsTag{generate-id()}">...</span>
		<div class="on" id="divTag{generate-id()}">
			<xsl:apply-templates/>
		</div>
		<span class="tagEx" onclick="turn(event,'dotsTag{generate-id()}'); return turn(event,'divTag{generate-id()}');">&lt;/<xsl:value-of select="name()"/>&gt;</span>
		</xsl:when>
		<xsl:when test="not(*) and text()">
		<span class="tag">&lt;<xsl:value-of select="name()"/><xsl:apply-templates select="@*"/>&gt;</span>
			<xsl:apply-templates/>
		<span class="tag">&lt;/<xsl:value-of select="name()"/>&gt;</span>
		</xsl:when>
		<xsl:otherwise>
		<span class="tag">&lt;<xsl:value-of select="name()"/><xsl:apply-templates select="@*"/>/&gt;</span>
		</xsl:otherwise>
		</xsl:choose>
	</div>
	</xsl:template>

	<xsl:template match="@*">
		<span class="attribute">&#160;<span class="attribute_name"><xsl:value-of select="name()"/></span>="<xsl:value-of select="."/>"</span>
	</xsl:template>

	<xsl:template match="text()"><xsl:value-of select="."/></xsl:template>

</xsl:stylesheet>