<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xsl:stylesheet [
<!ENTITY copy   "&#169;">
<!ENTITY nbsp   "&#160;">
<!ENTITY uuml   "&#252;">
<!ENTITY ouml   "&#246;">
<!ENTITY auml   "&#228;">
<!ENTITY Uuml   "&#220;">
<!ENTITY Ouml   "&#214;">
<!ENTITY Auml   "&#196;">
<!ENTITY szlig  "&#223;">
<!ENTITY laquo  "&#171;">
<!ENTITY raquo  "&#187;">
]>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
        <xsl:import href="portal.xsl"/>

        <xsl:variable name="login" select="/model/SESSION/_user/login" />
        <xsl:template name="content-view-pre">
        <!-- xsl:call-template name="logonUsers" / -->
		</xsl:template>
        <xsl:template name="content-view-post">
		<FORM name="members" action="" method="post">
        	<xsl:if test="/model/SESSION/_user/role != '*'">
        	<xsl:value-of select="$reference/portal/members/loged"/> [
			<a href="?_logout=y"><xsl:value-of select="$reference/common/logout"/></a> ]
			<hr size="1" noshadow="yes" color="orange" />
         	<a href="?pdf_doc=doc_eng"><xsl:value-of select="$reference/portal/members/en_instr"/></a>
			<br />
			<a href="?pdf_doc=doc_ger"><xsl:value-of select="$reference/portal/members/de_instr"/></a>
        	<br/>
			<a href="?pdf_doc=doc_pol"><xsl:value-of select="$reference/portal/members/pl_instr"/></a>
			</xsl:if>
        <hr size="1" noshadow="yes" color="orange" />
		<xsl:for-each select="/model/protected_content/item">

        <!-- a href="#" onclick="javascript:window.open('load_protected_file.php?doc_name={.}','Document','width=800 height=600');"><xsl:value-of select="." /></a -->
		<b><xsl:value-of select="/model/pdf_doc" /></b> -> <a href="load_protected_file.php?doc_name={.}" target="_blank"><xsl:value-of select="." /></a>
        <br /> <br />
		</xsl:for-each>
		<xsl:if test="/model/SESSION/_user/role = '*' or /model/SESSION/_user/role = ''">
        <xsl:call-template name="logonUsers" />
        </xsl:if>
        </FORM>
        </xsl:template>

        <xsl:template name="logonUsers">
        <table width="40%" border="0" cellpadding="1" cellspacing="1">
            <tr>
             <td colspan="3">
             <xsl:value-of select="$reference/portal/members/login_text"/>
             </td>
            </tr>
            <tr>
             <td height="22" colspan="3">

             </td>
            </tr>
            <tr>
	         <td><xsl:value-of select="$reference/common/name"/></td>
	         <td><xsl:value-of select="$reference/common/passwd"/></td>
	         <td></td>
	        </tr>
	        <tr>
	         <td><input type="text" name="_login" value=""/></td>
	         <td><input type="password" name="_password" value=""/></td>
	         <td><input type="submit" name="Submit" value="{$reference/common/submit}" /></td>
	        </tr>
        </table>
        <hr size="1" noshadow="yes" color="orange" />
		</xsl:template>
</xsl:stylesheet>
