Pirate clothes
- WordPress Theme for the pirate party websites
=================================================

Version 2.14 von Wolfgang Wiese (xwolf), 16. Oktober 2012


DOWNLOADS

    From the GIT repo (last working version and betas)
        https://github.com/xwolfde/Piratenkleider
        https://github.com/zwitschi/Piratenkleider (Austria)
    
    Project website (Release)
        http://piratenkleider.xwolf.de
    
    
CREDITS & COPYRIGHT

 CC-BY-SA 3.0, http://creativecommons.org/licenses/by-sa/3.0/de/deed.de


AUTHORS / DEVELOPER

   Wolfgang Wiese (xwolf) http://www.xwolf.de

   With the help of
     Andre Sendowski, http://www.iphone-notes.de/
     Heiko Philippski, http://www.phindie.de/
     Kerstin Probiesch, http://www.barrierefreie-informationskultur.de
     Fabian Müller, http://www.feals.de
     George http://zwitschi.net sense,

   Sources for default images and materials, CI (CC-BY 3.0)
      Default images for slider / side images: Tobias M. Eckrich
      More pictures: Wiki with different authors
      Image processing for pirate clothes 2.x: Wolfgang Wiese

   For more content using:
      Social Media Icons: Paul Robert Lloyd, http://paulrobertlloyd.com/2009/06/social_media_icons
      YAML CSS Framework (Licensed under the Creative Commons Attribution 2.0 License).
      JavaScript framework jQuery (GNU General Public License (GPL) version 2)
      Flex Slider jQuery (MIT License)
      Font Bebas of Dharmatype (SIL Open Font License 1.1)
      Droid Sans font from Ascender (http://www.droidfonts.com/), Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0

PRE-

This theme is based on the WordPress template based on Korbinian Polk.
Korbinian can be found from the old original on github:
 https://github.com/korbinian/Piratenkleider



MENUS
   The page consists of three different menus.

    - Main navigation
        This lists all the static pages of the website, in the main navigation at the top of the page, but below the logo
        . appear
        It should be noted that in addition to the pages of the website, the home must be added. Under the option Menuüs we find the home when the box "register" on "show all" button.
    - Linkmenu
        Here are links to tools, or portals, such as the wiki or the forum.
        If this menu is not defined, it is filled with the standard links: Wiki, Liquid Feedback, Forum, Message in a Bottle
    - Technical navigation
        In the technsiche Menu (static) pages that say something about the website, such as the Contacts, Contact, credits.
        The technical menu is available in the sidebar "foot: Right column by other content will be overwritten.

   The menus themselves have to be created under Design-> menus and the respective sides of the menus are assigned.
   These self-created menus are then assigned under "arrangement in the theme" the three areas mentioned.
   In the menu, which is the main navigation is associated with the site's homepage should be included. This is then converted using CSS in a little house icon. If no menu is created and assigned to the main navigation, alternatively, a menu based on the existing site built.



CONTENT

First All pages and articles should items / page images, since these can be displayed as a teaser.
Second Which items are presented in the slider, is defined in the Slider class setting.
Third Specific items may appear on the home page in the slider.
   This is a varied picture of their own articles with links to an article.
   In order to do this for an article, the article must be enabled for the slider category. (See point "slider" "Set rigging" in the options) If an item does not have a defined image feature article, the default slider images used.


AREAS / WIDGETS

First "Sidebar (right column)"
    This area is located right of the content. It is suitable for advertising posters, notices and the like. If empty, as an alternative some of the general standard posters are shown.
Second Sidebar 2 (Right to billboards)
    This area is located right of the content. It is positioned on the billboards, which the options can be enabled or disabled.
Third "Home: Slider range"
    Here, by default the items shown pictures of three items that are classified as "Slider" is assigned.
    If the widget is filled with a different function, then drop the slider.
4th "Home: Right Action link area"
    This area is right next to the slider. On the Pirate main site there are 3 links to donors / Get Involved and become a member.
    This 3 teaser links may put the theme option rigging are changed. If the widget used, the content will not display these changes and overwrite the widget content.
5th "Home: Links below"
    This is on the home field of the right of the list of additional items.
    It is recommended to fill the widget with the keyword list.
6th "Top: Bottom right"
    Area right below the three press articles.
    If empty, here's a key word list is shown.
7th "Footer: Left Side"
   Area in the footer below the main text area. This area is particularly suitable for external links to other pirate sites at the regional level or überegionaler. These are then defined as a menu of external links, and then assigned to this sidebar as a widget. If empty, nothing is displayed.
8th "Foot: Right column"
 Right column in the foot. If empty, this seems the technical menu (see menu). Although this is not defined, the blog address and the RSS feed address shown


THEME OPTION "set rig"
 
  Under the option "Set rigging" are the fundamental
  Options for the Theme set:
    - Turn off Newsletter Box /
    - Social Media buttons on / off
    - Set the number of messages on the home and its location
    - Slider control
    - Teaser links set or change
    - Sticker set or change
    - Web addresses for newsletters, membership applications and donations adaptable
    - Change meta-data
    - Optional display control for page images
    - Menutyp control for the display of pages and sub pages in the sidebar.
   And many more ...
 

THEME OPTION "set sail"
   
   This option allows to set the replacement images that are displayed when articles or pages have no "product image".
   Be made no provisions for the slider, by default the first category ("General") used and displayed images at random.

   Furthermore, can the promotional poster for slider in the right sidebar and selected additional URL information can be defined.
   No images are pre-selected, all the posters advertising the slider defined.

   The default images in the right sidebar appear as billboards are located in the folder / images /.
   In another size, the image will be rescaled by the browser. This may be associated with loss of quality.

   A complete list of promotional posters, which is used by the Pirate Party can http://wiki.piratenpartei.de/Plakate the wiki at the site will be found.

   Furthermore, the icons for the Metaseiten search, tags, categories, authors, archive and template pages by entering your own image URL changed.

THEME OPTION "Captn & Crew"

   This option allows you to record contact information for the template pages for the imprint, the privacy statements and optional form pages.
     

THEME OPTION "bowsprit"

   This option allows you to change specific CSS statements in the header of the page, and you can include your own CSS.
   Furthermore, can the color codes of other countries known to be activated.
   So it is possible to select, for example, instead of the waves and the ship to its own skyline as a background graphic.
   This option page should be changed before experienced web administrators who know exactly what they are doing.
   
   
THEME OPTION "header"

   This option is used to change the logo and upload your own logo.
   Important Note:
   The logo is currently set to a size of 300x130 pixels.
   The background should be in RGB # eeeeee.
   Unfortunately, all images will be uploaded in JPG converted if they are not already. The quality of the conversion is not as good.
   For this reason it is advisable to prepare the logo in the right size and the background on a separate graphics program.


PLUGINS SUPPORT
  - If the plugin "Related Posts by Category" is to be installed and activated, when viewing an article link more articles that could possibly be relevant.
 - The plugin "ICS Calendar" can be used to display dates in widgets.
   Under "Settings ->" ICS Calendar "this should be configured as follows:

    General Settings:
        URL to ICS file (s):
         For example, in Bavaria:
         1. http://events.piratenpartei-bayern.de/events/ical?gid=&gid[]=10&cid=&subgroups=1&start=&end=
         2. http://events.piratenpartei-bayern.de/index.php/events/ical?gid=&gid[]=13&cid=


    Formatting:
        Date Format:  "j.m."
        Time Format:  "G:i"
        Custom Event Format: (Yes)
             %date-time%, %start-date%, %start-time%, %end-date%, %end-time%, %event-title%, %description%, %location%   

   The time zone should be set to UTC time.

 Advanced Custom Fields
  With the help of the plugin Advanced Custom Fields to sites and articles about
  additional fields are added.
  In this theme is for pages (not articles), supported by the
  optional parameters "right_column". This allows for additional
  Information in the right column (the sidebar) to complete.

  Advanced Configuration of Custom Fields. See online documentation.

 - The Events Calendar
   The plugin "The Events Calendar" is often used to allow a calendar view. To this perfectly fitted into the theme, its own template files in the directory / events have been deposited /.



RECOMMENDATIONS FOR WIDGETS
 
First Diary with "ICS Calendar":
   In the Widget "sidebar (right column)" should ICS calendar for dates to be entered.
   Including another text widget with the following contents:
   <a href="http:// .. link-zur-eventseite ..."> View Other dates </ a>

   (Unfortunately, the ICS has plugin in the current version still does not respect the setting of links to the calendar Sparche system or individual appointments. Therefore, it is currently better from a usability reasons to make this a text widget for it.)
   

    

Administrative instructions for Wordpress Theme Editors:

First Default images
   The selection of the default-theme-options.php images is in the file stored in arrays. The images are in / images /
Second Default The default images are billboards appear in the right sidebar as advertising posters in the folder / images /.
Third Images in the content area, under the menu items in the respective thumbnail images of the items displayed.
   This is the default size for the article which is defined images in the blog is used. For newly created blogs, the average image size is used, according to the U.S. in the x and y define a maximum of 300 pixels and then.
   Settings library should, therefore, the average size of the images to 740 pixels wide and 240 pixels height are fixed.
   For product images, but works bedürften on the width of a higher scale this is not so great. The Y-axis but is then made large.
   Therefore, you should make sure that only those images will be chosen according to the actually are wide.
   The best way to edit images before the slider.
   With the visual presentation of the slider images which are greater than 240 pixels down are cut off.

4th It can be placed up to three stickers in the head section of the website.
   Under the theme options "rigging set" you can enter the content of the sticker sund the destination address.
   Content can be entered as HTML to display images directly.
   But it can only be entered as a text COntent.
   This can be determined using CSS classes and colors, and a 5 degree rotation for the text.
   See here for the FAQ section of the documentation for examples.

    Existing CSS classes to text:
     cicolor = sets the color of each of which is defined as the basic color of the design. (Default: orange)
     turned the whole text = Turn around 5 degrees
     = Can animate the text with a hover scale, rotate and
     shadow = Specifies the text a shadow (a shadow When rotated text will be set automatically)

5th The teaser links to the right of the image slider on the home page can be individually "set rig" on the theme options are set. Again, to be entered to three such links.
    Symbol, destination address, titles and subtitles can be entered. Title and subtitle, however, should not be longer than 40 characters.
    The icon can be selected from a predefined list.
    
    The teaser links can also be disabled as a whole as an option by Text-/Link-Widget in the "Top: Right Action link area" wuird positioned.
    

6th Link icons for certain documents are controlled by CSS.
   To this "abszuschalten" must be in the CSS file style.css only the stylesheet @ import url (css / basemod_linkicons.css) are commented out.
   In particular, the links should not be equipped with an icon, can the class. Nolinkicon be set.
   Link icons are set only for the content.

7th Color codes and language of texts
   Specific countries are color-coded in the files
       /css/colors_pt.css (for Portugal)
       /css/colors_tk.css (for Turkey)
       /css/colors_lu.css (for Luxembourg)
       /css/colors_at.css (for Austria)
       /css/colors_de.css (for Germany, but not necessarily as default) is stored.
   This fall partly on their own images.
   These files should be in / images / if they are general and in / images / int / when it comes to images that are country specific.

   With regard to language translation of texts can create your own language files in a directory / laguages ​​/ are stored. The theme this into account when such language files are present.
   For the use and creation of voice files, see http://www.catswhocode.com/blog/how-to-make-a-translatable-wordpress-theme

   The language files are stored in the form and Sprachcode_Landescode.mo Sprachcode_Landescode.po. For example, en_UK.po, en_UK.mo
   
   To switch to another language is the language settings in the backend and switched to the respective language, if the space-dependent version of the WordPress installation is not already.
   Starting with version 2.7 is already a British English language translation is included.
   For your own translation file can be edited default.po poedit using the editor.