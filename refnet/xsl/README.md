# Instructions for using XSL files

## Objective
Create CSV file from the transformation between XSL and WordPress (WP) XML files.

## Context
The WP XML file has all core and custom fields of post and strategies custom post type.
The XSL files transform this WP XML in CSV file using the character '|' as delimiter.

## XSL File features
### export-strategies.xsl
This XSL file produces the following CSV file (using custom field names):

> title|title_en|title_es|title_pt|vhl_instance

### export-strategies-aot.xsl
This XSL file produces the following CSV file (using custom field names):

> post_id|title_en|title_es|title_pt|vhl_instance|main_subject_of_the_search|lilacs_iahx_search_expression|lilacs_iah_search_expression

## How to get the WP XML file?
First of all, the user should have administration role.
To export the XML file with all Search Strategies records, go to Tools > Export on the main menu. Choose the option 'Search Strategies' and click on 'Download Export File' button. The XML file will be downloaded immediately with the name structure refnet.wordpress.YYYY-MM-DD.xml.

## How to get the CSV file?
Open the XML file recently downloaded in a text/xml editor (like Notepad++). In the second line, after the instruction

> <?xml version="1.0" encoding="UTF-8" ?>

Include the following line

> <?xml-stylesheet type="text/xsl" href="export-strategies.xsl"?> 

And save it.

To work properly, both XML and XSL files should be in the same directory. Otherwise, change the href attribute to include the directory where the XSL file is located.

Open the XML file in a web browser in order to generate the CSV file. The result displayed is the transformation of XML file using the XSL. Select the content from the web browser page and copy it in a text/xml editor. Save it with .csv extension to be opened on MS Excel.
