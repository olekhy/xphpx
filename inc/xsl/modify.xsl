<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="xml" encoding="UTF-8" indent="no" media-type="text/xml" cdata-section-elements="content"/>
	
	<xsl:param name="date"/>
	<xsl:param name="defaultlang"/>
	<xsl:param name="created"/>

	<xsl:param name="lang"/>
	<xsl:param name="uid"/>
	<xsl:param name="user"/>
	<xsl:param name="role" select="'*'"/>

	<xsl:param name="sid"/>
	<xsl:param name="andsid"/>
	<xsl:param name="qsid"/>

	<xsl:param name="action"/>

	<xsl:param name="url"/>
	<xsl:param name="path"/>
	<xsl:param name="script"/>

	<xsl:param name="title" select="null"/>
	<xsl:param name="defaulttitle" select="null"/>
	<xsl:param name="annotation" select="null"/>
	<xsl:param name="defaultannotation" select="null"/>
	<xsl:param name="content" select="null"/>
	<xsl:param name="defaultcontent" select="null"/>
	<xsl:param name="directorystructure" select="null"/>

	<xsl:template match="@* | processing-instruction()">
		<xsl:copy/>
	</xsl:template>

	<xsl:template match="/|*">
		<xsl:copy>
			<xsl:apply-templates select="@*"/>
			<xsl:apply-templates/>
		</xsl:copy>
	</xsl:template>

	<xsl:template match="/document">
		<xsl:copy>
			<xsl:apply-templates select="@*"/>
			<xsl:choose>
			<xsl:when test="$created and $created != ''">
				<xsl:attribute name="author"><xsl:value-of select="$user"/></xsl:attribute>
				<xsl:attribute name="created"><xsl:value-of select="$created"/></xsl:attribute>
			</xsl:when>
			<xsl:otherwise>
				<xsl:if test="not(@editor)">
				<xsl:attribute name="editor"><xsl:value-of select="$user"/></xsl:attribute>
				</xsl:if>
				<xsl:if test="not(@modified)">
				<xsl:attribute name="modified"><xsl:value-of select="$date"/></xsl:attribute>
				</xsl:if>
			</xsl:otherwise>
			</xsl:choose>
			<xsl:if test="not(@edit) and $user and $user != ''">
				<xsl:attribute name="edit">u:<xsl:value-of select="$user"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="$title and ((not($defaulttitle = 1) and not(title[lang($lang)])) or ($defaulttitle = 1 and not(title[lang($defaultlang)]) and not(title[not(@xml:lang)])))">
				<title>
					<xsl:attribute name="xml:lang">
						<xsl:if test="$defaulttitle = 1"><xsl:value-of select="$defaultlang"/></xsl:if>
						<xsl:if test="not($defaulttitle = 1)"><xsl:value-of select="$lang"/></xsl:if>
					</xsl:attribute>
					<xsl:value-of select="$title"/>
				</title>
			</xsl:if>
			<xsl:if test="$annotation and ((not($defaultannotation = 1) and not(annotation[lang($lang)])) or ($defaultannotation = 1 and not(annotation[lang($defaultlang)]) and not(annotation[not(@xml:lang)])))">
				<annotation>
					<xsl:attribute name="xml:lang">
						<xsl:if test="$defaultannotation = 1"><xsl:value-of select="$defaultlang"/></xsl:if>
						<xsl:if test="not($defaultannotation = 1)"><xsl:value-of select="$lang"/></xsl:if>
					</xsl:attribute>
					<xsl:value-of select="$annotation"/>
				</annotation>
			</xsl:if>
			<xsl:if test="$directorystructure and $directorystructure = 1 and not(x-directory-structure) and not(directory-structure)">
				<directory-structure/>
			</xsl:if>
			<xsl:apply-templates/>
			<xsl:if test="$content and ((not($defaultcontent = 1) and not(content[lang($lang)])) or ($defaultcontent = 1 and not(content[lang($defaultlang)]) and not(content[not(@xml:lang)])))">
				<content>
					<xsl:attribute name="editor"><xsl:value-of select="$user"/></xsl:attribute>
					<xsl:attribute name="modified"><xsl:value-of select="$date"/></xsl:attribute>
					<xsl:attribute name="xml:lang">
						<xsl:if test="$defaultcontent = 1"><xsl:value-of select="$defaultlang"/></xsl:if>
						<xsl:if test="not($defaultcontent = 1)"><xsl:value-of select="$lang"/></xsl:if>
					</xsl:attribute>
					<xsl:value-of select="$content"/>
				</content>
			</xsl:if>
			
		</xsl:copy>
	</xsl:template>

	<xsl:template match="/document/@edit">
		<xsl:if test="text() = ''">
			<xsl:if test="$user and $user != ''">
				<xsl:attribute name="edit">u:<xsl:value-of select="$user"/></xsl:attribute>
			</xsl:if>
		</xsl:if>
		<xsl:if test="text() != ''">
			<xsl:copy/>
		</xsl:if>
	</xsl:template>

	<xsl:template match="/document/@editor">
		<xsl:choose>
		<xsl:when test="(not($created) or $created = '') and $user and $user != ''">
			<xsl:attribute name="editor"><xsl:value-of select="$user"/></xsl:attribute>
		</xsl:when>
		<xsl:otherwise>
			<xsl:copy/>
		</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="/document/@modified">
		<xsl:choose>
		<xsl:when test="(not($created) or $created = '') and $date and $date != ''">
			<xsl:attribute name="modified"><xsl:value-of select="$date"/></xsl:attribute>
		</xsl:when>
		<xsl:otherwise>
			<xsl:copy/>
		</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="/document/title">
		<xsl:choose>
		<xsl:when test="$title and $defaulttitle = 1 and lang($lang)">
		</xsl:when>
		<xsl:when test="$title and $defaulttitle = 1 and not(@xml:lang) and ../title[lang($defaultlang)]">
		</xsl:when>
		<xsl:when test="$title and not($defaulttitle = 1) and lang($lang)">
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:value-of select="$title"/>
			</xsl:copy>
		</xsl:when>
		<xsl:when test="$title and $defaulttitle = 1 and lang($defaultlang)">
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:value-of select="$title"/>
			</xsl:copy>
		</xsl:when>
		<xsl:when test="$title and $defaulttitle = 1 and not(@xml:lang) and not(../title[lang($defaultlang)])">
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:value-of select="$title"/>
			</xsl:copy>
		</xsl:when>
		<xsl:otherwise>
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:apply-templates/>
			</xsl:copy>
		</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="/document/annotation">
		<xsl:choose>
		<xsl:when test="$annotation and $defaultannotation = 1 and lang($lang)">
		</xsl:when>
		<xsl:when test="$annotation and $defaultannotation = 1 and not(@xml:lang) and ../annotation[lang($defaultlang)]">
		</xsl:when>
		<xsl:when test="$annotation and not($defaultannotation = 1) and lang($lang)">
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:value-of select="$annotation"/>
			</xsl:copy>
		</xsl:when>
		<xsl:when test="$annotation and $defaultannotation = 1 and lang($defaultlang)">
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:value-of select="$annotation"/>
			</xsl:copy>
		</xsl:when>
		<xsl:when test="$annotation and $defaultannotation = 1 and not(@xml:lang) and not(../annotation[lang($defaultlang)])">
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:value-of select="$annotation"/>
			</xsl:copy>
		</xsl:when>
		<xsl:otherwise>
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:apply-templates/>
			</xsl:copy>
		</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="/document/content">
		<xsl:choose>
		<xsl:when test="$content and $defaultcontent = 1 and lang($lang)">
		</xsl:when>
		<xsl:when test="$content and $defaultcontent = 1 and not(@xml:lang) and ../content[lang($defaultlang)]">
		</xsl:when>
		<xsl:when test="$content and not($defaultcontent = 1) and lang($lang)">
			<xsl:copy>
				<xsl:apply-templates select="@*[name() != 'editor' and name() != 'modified']"/>
				<xsl:attribute name="editor"><xsl:value-of select="$user"/></xsl:attribute>
				<xsl:attribute name="modified"><xsl:value-of select="$date"/></xsl:attribute>
				<xsl:value-of select="$content"/>
			</xsl:copy>
		</xsl:when>
		<xsl:when test="$content and $defaultcontent = 1 and lang($defaultlang)">
			<xsl:copy>
				<xsl:apply-templates select="@*[name() != 'editor' and name() != 'modified']"/>
				<xsl:attribute name="editor"><xsl:value-of select="$user"/></xsl:attribute>
				<xsl:attribute name="modified"><xsl:value-of select="$date"/></xsl:attribute>
				<xsl:value-of select="$content"/>
			</xsl:copy>
		</xsl:when>
		<xsl:when test="$content and $defaultcontent = 1 and not(@xml:lang) and not(../content[lang($defaultlang)])">
			<xsl:copy>
				<xsl:apply-templates select="@*[name() != 'editor' and name() != 'modified']"/>
				<xsl:attribute name="editor"><xsl:value-of select="$user"/></xsl:attribute>
				<xsl:attribute name="modified"><xsl:value-of select="$date"/></xsl:attribute>
				<xsl:value-of select="$content"/>
			</xsl:copy>
		</xsl:when>
		<xsl:otherwise>
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:apply-templates/>
			</xsl:copy>
		</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="/document/directory-structure">
		<xsl:choose>
		<xsl:when test="$directorystructure = 1">
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:apply-templates/>
			</xsl:copy>
		</xsl:when>
		<xsl:otherwise>
			<xsl:element name="x-directory-structure">
				<xsl:apply-templates select="@*"/>
				<xsl:apply-templates/>
			</xsl:element>
		</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="/document/x-directory-structure">
		<xsl:choose>
		<xsl:when test="$directorystructure = 1">
			<xsl:element name="directory-structure">
				<xsl:apply-templates select="@*"/>
				<xsl:apply-templates/>
			</xsl:element>
		</xsl:when>
		<xsl:otherwise>
			<xsl:copy>
				<xsl:apply-templates select="@*"/>
				<xsl:apply-templates/>
			</xsl:copy>
		</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>