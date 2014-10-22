<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0" 

xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
xmlns:content="http://purl.org/rss/1.0/modules/content/"
xmlns:wfw="http://wellformedweb.org/CommentAPI/"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:wp="http://wordpress.org/export/1.2/"

>

<xsl:output method="text"/>

<xsl:template match="/">
   <xsl:apply-templates select="//item"/>  
</xsl:template>

<xsl:template match="item">
	<xsl:apply-templates select="title"/>|<xsl:apply-templates select="wp:postmeta[wp:meta_key='title_en']"/>|<xsl:apply-templates select="wp:postmeta[wp:meta_key='title_es']"/>|<xsl:apply-templates select="wp:postmeta[wp:meta_key='title_pt']"/>|<xsl:apply-templates select="wp:postmeta[wp:meta_key='vhl_instance']"/>
	<xsl:text>
	</xsl:text>
</xsl:template>

<xsl:template match="wp:postmeta[wp:meta_key='title_en' or wp:meta_key='title_pt' or wp:meta_key='title_es' or wp:meta_key='vhl_instance']">
	<xsl:value-of select="wp:meta_value"/>
</xsl:template>

<xsl:template match="wp:postmeta"/>


</xsl:stylesheet>
