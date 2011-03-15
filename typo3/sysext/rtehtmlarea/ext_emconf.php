<?php

########################################################################
# Extension Manager/Repository config file for ext "rtehtmlarea".
#
# Auto generated 22-06-2010 12:44
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'htmlArea RTE',
	'description' => 'Rich Text Editor based on the open source htmlArea editor.',
	'category' => 'be',
	'shy' => 0,
	'dependencies' => 'cms',
	'conflicts' => 'rte_conf',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'mod3,mod4,mod5,mod6',
	'state' => 'stable',
	'internal' => 0,
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author' => 'Stanislas Rolland',
	'author_email' => 'typo3(arobas)sjbr.ca',
	'author_company' => 'SJBR',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '2.0.8',
	'_md5_values_when_last_written' => 'a:429:{s:9:"ChangeLog";s:4:"2782";s:29:"class.tx_rtehtmlarea_base.php";s:4:"a598";s:27:"class.tx_rtehtmlareaapi.php";s:4:"2205";s:21:"ext_conf_template.txt";s:4:"afd8";s:12:"ext_icon.gif";s:4:"2f41";s:17:"ext_localconf.php";s:4:"bcfc";s:14:"ext_tables.php";s:4:"57bd";s:14:"ext_tables.sql";s:4:"bba8";s:13:"locallang.xml";s:4:"3cca";s:16:"locallang_db.xml";s:4:"c2ed";s:7:"tca.php";s:4:"6b5a";s:14:"doc/manual.sxw";s:4:"a737";s:59:"extensions/AboutEditor/class.tx_rtehtmlarea_abouteditor.php";s:4:"45e2";s:40:"extensions/AboutEditor/skin/htmlarea.css";s:4:"eb62";s:44:"extensions/AboutEditor/skin/images/about.gif";s:4:"1690";s:51:"extensions/Acronym/class.tx_rtehtmlarea_acronym.php";s:4:"4d3d";s:36:"extensions/Acronym/skin/htmlarea.css";s:4:"c107";s:42:"extensions/Acronym/skin/images/acronym.gif";s:4:"1eaa";s:63:"extensions/BlockElements/class.tx_rtehtmlarea_blockelements.php";s:4:"5fbf";s:38:"extensions/BlockElements/locallang.xml";s:4:"479e";s:42:"extensions/BlockElements/skin/htmlarea.css";s:4:"fbb7";s:51:"extensions/BlockElements/skin/images/blockquote.gif";s:4:"34dc";s:47:"extensions/BlockElements/skin/images/indent.gif";s:4:"57df";s:61:"extensions/BlockElements/skin/images/insertHorizontalRule.gif";s:4:"f384";s:58:"extensions/BlockElements/skin/images/insertOrderedList.gif";s:4:"eb1c";s:61:"extensions/BlockElements/skin/images/insertParagraphAfter.gif";s:4:"e335";s:62:"extensions/BlockElements/skin/images/insertParagraphBefore.gif";s:4:"9c42";s:60:"extensions/BlockElements/skin/images/insertUnorderedList.gif";s:4:"5620";s:54:"extensions/BlockElements/skin/images/justifyCenter.gif";s:4:"420d";s:52:"extensions/BlockElements/skin/images/justifyFull.gif";s:4:"b129";s:52:"extensions/BlockElements/skin/images/justifyLeft.gif";s:4:"3799";s:53:"extensions/BlockElements/skin/images/justifyRight.gif";s:4:"0662";s:48:"extensions/BlockElements/skin/images/outdent.gif";s:4:"4786";s:57:"extensions/BlockStyle/class.tx_rtehtmlarea_blockstyle.php";s:4:"c86b";s:35:"extensions/BlockStyle/locallang.xml";s:4:"26b8";s:61:"extensions/CharacterMap/class.tx_rtehtmlarea_charactermap.php";s:4:"71aa";s:41:"extensions/CharacterMap/skin/htmlarea.css";s:4:"06c8";s:55:"extensions/CharacterMap/skin/images/insertCharacter.gif";s:4:"af19";s:59:"extensions/ContextMenu/class.tx_rtehtmlarea_contextmenu.php";s:4:"c579";s:55:"extensions/CopyPaste/class.tx_rtehtmlarea_copypaste.php";s:4:"1a57";s:38:"extensions/CopyPaste/skin/htmlarea.css";s:4:"9391";s:41:"extensions/CopyPaste/skin/images/copy.gif";s:4:"98d2";s:40:"extensions/CopyPaste/skin/images/cut.gif";s:4:"1323";s:42:"extensions/CopyPaste/skin/images/paste.gif";s:4:"7df5";s:61:"extensions/DefaultClean/class.tx_rtehtmlarea_defaultclean.php";s:4:"279f";s:37:"extensions/DefaultColor/locallang.xml";s:4:"3fb4";s:41:"extensions/DefaultColor/skin/htmlarea.css";s:4:"6076";s:49:"extensions/DefaultColor/skin/images/forecolor.gif";s:4:"dbc8";s:51:"extensions/DefaultColor/skin/images/hilitecolor.gif";s:4:"d97c";s:36:"extensions/DefaultFont/locallang.xml";s:4:"8c90";s:61:"extensions/DefaultImage/class.tx_rtehtmlarea_defaultimage.php";s:4:"6532";s:41:"extensions/DefaultImage/skin/htmlarea.css";s:4:"6cfe";s:45:"extensions/DefaultImage/skin/images/image.gif";s:4:"c0f0";s:63:"extensions/DefaultInline/class.tx_rtehtmlarea_defaultinline.php";s:4:"4de1";s:38:"extensions/DefaultInline/locallang.xml";s:4:"318f";s:42:"extensions/DefaultInline/skin/htmlarea.css";s:4:"6009";s:45:"extensions/DefaultInline/skin/images/bold.gif";s:4:"94f2";s:47:"extensions/DefaultInline/skin/images/italic.gif";s:4:"f60c";s:54:"extensions/DefaultInline/skin/images/strikethrough.gif";s:4:"3fd0";s:50:"extensions/DefaultInline/skin/images/subscript.gif";s:4:"cedd";s:52:"extensions/DefaultInline/skin/images/superscript.gif";s:4:"8aea";s:50:"extensions/DefaultInline/skin/images/underline.gif";s:4:"81e6";s:59:"extensions/DefaultLink/class.tx_rtehtmlarea_defaultlink.php";s:4:"da03";s:40:"extensions/DefaultLink/skin/htmlarea.css";s:4:"680b";s:43:"extensions/DefaultLink/skin/images/link.gif";s:4:"db9a";s:45:"extensions/DefaultLink/skin/images/unlink.gif";s:4:"86c4";s:65:"extensions/DefinitionList/class.tx_rtehtmlarea_definitionlist.php";s:4:"55ee";s:43:"extensions/DefinitionList/skin/htmlarea.css";s:4:"a254";s:56:"extensions/DefinitionList/skin/images/definitionItem.gif";s:4:"33ae";s:56:"extensions/DefinitionList/skin/images/definitionList.gif";s:4:"d5d1";s:57:"extensions/EditorMode/class.tx_rtehtmlarea_editormode.php";s:4:"fa89";s:39:"extensions/EditorMode/skin/htmlarea.css";s:4:"0793";s:45:"extensions/EditorMode/skin/images/ed_html.gif";s:4:"fa6e";s:59:"extensions/FindReplace/class.tx_rtehtmlarea_findreplace.php";s:4:"d822";s:40:"extensions/FindReplace/skin/htmlarea.css";s:4:"43cc";s:43:"extensions/FindReplace/skin/images/find.gif";s:4:"827f";s:65:"extensions/InlineElements/class.tx_rtehtmlarea_inlineelements.php";s:4:"e6b6";s:39:"extensions/InlineElements/locallang.xml";s:4:"07c6";s:46:"extensions/InlineElements/res/pageTSConfig.txt";s:4:"088c";s:43:"extensions/InlineElements/skin/htmlarea.css";s:4:"978b";s:54:"extensions/InlineElements/skin/images/bidioverride.gif";s:4:"f38b";s:45:"extensions/InlineElements/skin/images/big.gif";s:4:"779b";s:46:"extensions/InlineElements/skin/images/bold.gif";s:4:"06ac";s:50:"extensions/InlineElements/skin/images/citation.gif";s:4:"b6eb";s:46:"extensions/InlineElements/skin/images/code.gif";s:4:"6057";s:52:"extensions/InlineElements/skin/images/definition.gif";s:4:"692d";s:53:"extensions/InlineElements/skin/images/deletedtext.gif";s:4:"4eec";s:50:"extensions/InlineElements/skin/images/emphasis.gif";s:4:"04c9";s:54:"extensions/InlineElements/skin/images/insertedtext.gif";s:4:"a624";s:48:"extensions/InlineElements/skin/images/italic.gif";s:4:"be83";s:50:"extensions/InlineElements/skin/images/keyboard.gif";s:4:"53ac";s:52:"extensions/InlineElements/skin/images/monospaced.gif";s:4:"78c0";s:51:"extensions/InlineElements/skin/images/quotation.gif";s:4:"7c62";s:48:"extensions/InlineElements/skin/images/sample.gif";s:4:"667c";s:47:"extensions/InlineElements/skin/images/small.gif";s:4:"e013";s:46:"extensions/InlineElements/skin/images/span.gif";s:4:"0dfa";s:55:"extensions/InlineElements/skin/images/strikethrough.gif";s:4:"73b1";s:48:"extensions/InlineElements/skin/images/strong.gif";s:4:"7f50";s:51:"extensions/InlineElements/skin/images/subscript.gif";s:4:"36c0";s:53:"extensions/InlineElements/skin/images/superscript.gif";s:4:"40c4";s:51:"extensions/InlineElements/skin/images/underline.gif";s:4:"dfac";s:50:"extensions/InlineElements/skin/images/variable.gif";s:4:"da61";s:61:"extensions/InsertSmiley/class.tx_rtehtmlarea_insertsmiley.php";s:4:"4474";s:41:"extensions/InsertSmiley/skin/htmlarea.css";s:4:"fb52";s:46:"extensions/InsertSmiley/skin/images/smiley.gif";s:4:"c331";s:53:"extensions/Language/class.tx_rtehtmlarea_language.php";s:4:"969b";s:33:"extensions/Language/locallang.xml";s:4:"ff62";s:37:"extensions/Language/skin/htmlarea.css";s:4:"7034";s:49:"extensions/Language/skin/images/left_to_right.gif";s:4:"1a1f";s:49:"extensions/Language/skin/images/right_to_left.gif";s:4:"2a38";s:55:"extensions/Language/skin/images/show-language-marks.gif";s:4:"0bbb";s:53:"extensions/QuickTag/class.tx_rtehtmlarea_quicktag.php";s:4:"2eee";s:37:"extensions/QuickTag/skin/htmlarea.css";s:4:"b006";s:45:"extensions/QuickTag/skin/images/inserttag.gif";s:4:"a463";s:61:"extensions/RemoveFormat/class.tx_rtehtmlarea_removeformat.php";s:4:"af58";s:41:"extensions/RemoveFormat/skin/htmlarea.css";s:4:"be33";s:45:"extensions/RemoveFormat/skin/images/clean.gif";s:4:"2a0f";s:57:"extensions/SelectFont/class.tx_rtehtmlarea_selectfont.php";s:4:"0aed";s:35:"extensions/SelectFont/locallang.xml";s:4:"a705";s:61:"extensions/SpellChecker/class.tx_rtehtmlarea_spellchecker.php";s:4:"97fa";s:41:"extensions/SpellChecker/skin/htmlarea.css";s:4:"cedf";s:51:"extensions/SpellChecker/skin/images/spell-check.gif";s:4:"6e0a";s:57:"extensions/TYPO3Color/class.tx_rtehtmlarea_typo3color.php";s:4:"25aa";s:35:"extensions/TYPO3Color/locallang.xml";s:4:"377f";s:39:"extensions/TYPO3Color/skin/htmlarea.css";s:4:"fad4";s:47:"extensions/TYPO3Color/skin/images/forecolor.gif";s:4:"dbc8";s:49:"extensions/TYPO3Color/skin/images/hilitecolor.gif";s:4:"d97c";s:67:"extensions/TYPO3HtmlParser/class.tx_rtehtmlarea_typo3htmlparser.php";s:4:"6829";s:57:"extensions/TYPO3Image/class.tx_rtehtmlarea_typo3image.php";s:4:"d451";s:39:"extensions/TYPO3Image/skin/htmlarea.css";s:4:"f593";s:43:"extensions/TYPO3Image/skin/images/image.gif";s:4:"c0f0";s:55:"extensions/TYPO3Link/class.tx_rtehtmlarea_typo3link.php";s:4:"423e";s:38:"extensions/TYPO3Link/skin/htmlarea.css";s:4:"73f9";s:41:"extensions/TYPO3Link/skin/images/link.gif";s:4:"db9a";s:43:"extensions/TYPO3Link/skin/images/unlink.gif";s:4:"86c4";s:67:"extensions/TableOperations/class.tx_rtehtmlarea_tableoperations.php";s:4:"cbe1";s:44:"extensions/TableOperations/skin/htmlarea.css";s:4:"b57e";s:54:"extensions/TableOperations/skin/images/cell-delete.gif";s:4:"f371";s:60:"extensions/TableOperations/skin/images/cell-insert-after.gif";s:4:"2dd2";s:61:"extensions/TableOperations/skin/images/cell-insert-before.gif";s:4:"5d13";s:53:"extensions/TableOperations/skin/images/cell-merge.gif";s:4:"cb52";s:52:"extensions/TableOperations/skin/images/cell-prop.gif";s:4:"ca41";s:53:"extensions/TableOperations/skin/images/cell-split.gif";s:4:"0095";s:53:"extensions/TableOperations/skin/images/col-delete.gif";s:4:"da78";s:59:"extensions/TableOperations/skin/images/col-insert-after.gif";s:4:"80d8";s:60:"extensions/TableOperations/skin/images/col-insert-before.gif";s:4:"d47d";s:51:"extensions/TableOperations/skin/images/col-prop.gif";s:4:"b178";s:52:"extensions/TableOperations/skin/images/col-split.gif";s:4:"c168";s:55:"extensions/TableOperations/skin/images/insert_table.gif";s:4:"c01b";s:53:"extensions/TableOperations/skin/images/row-delete.gif";s:4:"a289";s:59:"extensions/TableOperations/skin/images/row-insert-above.gif";s:4:"1ef1";s:59:"extensions/TableOperations/skin/images/row-insert-under.gif";s:4:"9ad6";s:51:"extensions/TableOperations/skin/images/row-prop.gif";s:4:"5344";s:52:"extensions/TableOperations/skin/images/row-split.gif";s:4:"ebfd";s:53:"extensions/TableOperations/skin/images/table-prop.gif";s:4:"0a5c";s:56:"extensions/TableOperations/skin/images/table-restyle.gif";s:4:"9284";s:57:"extensions/TableOperations/skin/images/toggle-borders.gif";s:4:"50cb";s:63:"extensions/TextIndicator/class.tx_rtehtmlarea_textindicator.php";s:4:"9eff";s:42:"extensions/TextIndicator/skin/htmlarea.css";s:4:"bad2";s:55:"extensions/TextStyle/class.tx_rtehtmlarea_textstyle.php";s:4:"6b3e";s:34:"extensions/TextStyle/locallang.xml";s:4:"23dd";s:53:"extensions/UndoRedo/class.tx_rtehtmlarea_undoredo.php";s:4:"8b07";s:37:"extensions/UndoRedo/skin/htmlarea.css";s:4:"de26";s:40:"extensions/UndoRedo/skin/images/redo.gif";s:4:"5fdf";s:40:"extensions/UndoRedo/skin/images/undo.gif";s:4:"8d53";s:61:"extensions/UserElements/class.tx_rtehtmlarea_userelements.php";s:4:"37b8";s:41:"extensions/UserElements/skin/htmlarea.css";s:4:"f66d";s:44:"extensions/UserElements/skin/images/user.gif";s:4:"bbb4";s:59:"hooks/clearrtecache/class.tx_rtehtmlarea_clearcachemenu.php";s:4:"31cd";s:58:"hooks/clearrtecache/class.tx_rtehtmlarea_clearrtecache.php";s:4:"b985";s:37:"hooks/clearrtecache/clearrtecache.png";s:4:"0fc0";s:37:"hooks/clearrtecache/ext_localconf.php";s:4:"3cbb";s:33:"hooks/clearrtecache/locallang.xml";s:4:"3902";s:29:"htmlarea/HTMLAREA_LICENSE.txt";s:4:"a10f";s:26:"htmlarea/htmlarea-gecko.js";s:4:"6e92";s:23:"htmlarea/htmlarea-ie.js";s:4:"817d";s:20:"htmlarea/htmlarea.js";s:4:"f99d";s:30:"htmlarea/locallang_dialogs.xml";s:4:"db44";s:26:"htmlarea/locallang_msg.xml";s:4:"7b6f";s:31:"htmlarea/locallang_tooltips.xml";s:4:"0152";s:44:"htmlarea/plugins/AboutEditor/about-editor.js";s:4:"c18c";s:35:"htmlarea/plugins/Acronym/acronym.js";s:4:"4a08";s:38:"htmlarea/plugins/Acronym/locallang.xml";s:4:"d32a";s:48:"htmlarea/plugins/BlockElements/block-elements.js";s:4:"b489";s:44:"htmlarea/plugins/BlockElements/locallang.xml";s:4:"6d5e";s:42:"htmlarea/plugins/BlockStyle/block-style.js";s:4:"ce3b";s:41:"htmlarea/plugins/BlockStyle/locallang.xml";s:4:"32ed";s:46:"htmlarea/plugins/CharacterMap/character-map.js";s:4:"bc62";s:43:"htmlarea/plugins/CharacterMap/locallang.xml";s:4:"589c";s:44:"htmlarea/plugins/ContextMenu/context-menu.js";s:4:"3b56";s:42:"htmlarea/plugins/ContextMenu/locallang.xml";s:4:"5708";s:40:"htmlarea/plugins/CopyPaste/copy-paste.js";s:4:"5921";s:40:"htmlarea/plugins/CopyPaste/locallang.xml";s:4:"6703";s:46:"htmlarea/plugins/DefaultClean/default-clean.js";s:4:"5108";s:43:"htmlarea/plugins/DefaultClean/locallang.xml";s:4:"9e62";s:43:"htmlarea/plugins/DefaultColor/locallang.xml";s:4:"c8d1";s:42:"htmlarea/plugins/DefaultFont/locallang.xml";s:4:"a7f8";s:46:"htmlarea/plugins/DefaultImage/default-image.js";s:4:"6a13";s:43:"htmlarea/plugins/DefaultImage/locallang.xml";s:4:"cccc";s:48:"htmlarea/plugins/DefaultInline/default-inline.js";s:4:"8cf4";s:44:"htmlarea/plugins/DefaultInline/locallang.xml";s:4:"2b55";s:44:"htmlarea/plugins/DefaultLink/default-link.js";s:4:"583d";s:42:"htmlarea/plugins/DefaultLink/locallang.xml";s:4:"f2b5";s:50:"htmlarea/plugins/DefinitionList/definition-list.js";s:4:"e35d";s:45:"htmlarea/plugins/DefinitionList/locallang.xml";s:4:"5c85";s:42:"htmlarea/plugins/DynamicCSS/dynamiccss.css";s:4:"85b7";s:41:"htmlarea/plugins/DynamicCSS/locallang.xml";s:4:"b6bf";s:52:"htmlarea/plugins/DynamicCSS/img/red_arrow_bullet.gif";s:4:"82d6";s:42:"htmlarea/plugins/EditorMode/editor-mode.js";s:4:"5964";s:41:"htmlarea/plugins/EditorMode/locallang.xml";s:4:"5b14";s:44:"htmlarea/plugins/FindReplace/find-replace.js";s:4:"4932";s:42:"htmlarea/plugins/FindReplace/locallang.xml";s:4:"7eec";s:40:"htmlarea/plugins/InlineCSS/locallang.xml";s:4:"7840";s:50:"htmlarea/plugins/InlineElements/inline-elements.js";s:4:"939e";s:45:"htmlarea/plugins/InlineElements/locallang.xml";s:4:"6f8c";s:46:"htmlarea/plugins/InsertSmiley/insert-smiley.js";s:4:"dda5";s:43:"htmlarea/plugins/InsertSmiley/locallang.xml";s:4:"ff09";s:46:"htmlarea/plugins/InsertSmiley/smileys/0001.gif";s:4:"4aff";s:46:"htmlarea/plugins/InsertSmiley/smileys/0002.gif";s:4:"02c4";s:46:"htmlarea/plugins/InsertSmiley/smileys/0003.gif";s:4:"834f";s:46:"htmlarea/plugins/InsertSmiley/smileys/0004.gif";s:4:"fb6a";s:46:"htmlarea/plugins/InsertSmiley/smileys/0005.gif";s:4:"2a48";s:46:"htmlarea/plugins/InsertSmiley/smileys/0006.gif";s:4:"f970";s:46:"htmlarea/plugins/InsertSmiley/smileys/0007.gif";s:4:"97ee";s:46:"htmlarea/plugins/InsertSmiley/smileys/0008.gif";s:4:"10a6";s:46:"htmlarea/plugins/InsertSmiley/smileys/0009.gif";s:4:"1907";s:46:"htmlarea/plugins/InsertSmiley/smileys/0010.gif";s:4:"9ee6";s:46:"htmlarea/plugins/InsertSmiley/smileys/0011.gif";s:4:"ae73";s:46:"htmlarea/plugins/InsertSmiley/smileys/0012.gif";s:4:"f058";s:46:"htmlarea/plugins/InsertSmiley/smileys/0013.gif";s:4:"3ed8";s:46:"htmlarea/plugins/InsertSmiley/smileys/0014.gif";s:4:"a948";s:46:"htmlarea/plugins/InsertSmiley/smileys/0015.gif";s:4:"218d";s:46:"htmlarea/plugins/InsertSmiley/smileys/0016.gif";s:4:"3539";s:46:"htmlarea/plugins/InsertSmiley/smileys/0017.gif";s:4:"ee2e";s:46:"htmlarea/plugins/InsertSmiley/smileys/0018.gif";s:4:"8c66";s:46:"htmlarea/plugins/InsertSmiley/smileys/0019.gif";s:4:"ac36";s:46:"htmlarea/plugins/InsertSmiley/smileys/0020.gif";s:4:"71ef";s:54:"htmlarea/plugins/InsertSmiley/smileys/mozilla_cool.png";s:4:"0295";s:53:"htmlarea/plugins/InsertSmiley/smileys/mozilla_cry.png";s:4:"cdfa";s:60:"htmlarea/plugins/InsertSmiley/smileys/mozilla_embarassed.png";s:4:"77ef";s:61:"htmlarea/plugins/InsertSmiley/smileys/mozilla_footinmouth.png";s:4:"c74a";s:55:"htmlarea/plugins/InsertSmiley/smileys/mozilla_frown.png";s:4:"5e44";s:58:"htmlarea/plugins/InsertSmiley/smileys/mozilla_innocent.png";s:4:"544f";s:54:"htmlarea/plugins/InsertSmiley/smileys/mozilla_kiss.png";s:4:"4eb6";s:58:"htmlarea/plugins/InsertSmiley/smileys/mozilla_laughing.png";s:4:"39e0";s:62:"htmlarea/plugins/InsertSmiley/smileys/mozilla_moneyinmouth.png";s:4:"a7d8";s:64:"htmlarea/plugins/InsertSmiley/smileys/mozilla_public_license.txt";s:4:"a773";s:56:"htmlarea/plugins/InsertSmiley/smileys/mozilla_sealed.png";s:4:"79d8";s:55:"htmlarea/plugins/InsertSmiley/smileys/mozilla_smile.png";s:4:"eec2";s:59:"htmlarea/plugins/InsertSmiley/smileys/mozilla_surprised.png";s:4:"6932";s:59:"htmlarea/plugins/InsertSmiley/smileys/mozilla_tongueout.png";s:4:"4714";s:59:"htmlarea/plugins/InsertSmiley/smileys/mozilla_undecided.png";s:4:"1099";s:54:"htmlarea/plugins/InsertSmiley/smileys/mozilla_wink.png";s:4:"47e7";s:54:"htmlarea/plugins/InsertSmiley/smileys/mozilla_yell.png";s:4:"30b1";s:37:"htmlarea/plugins/Language/language.js";s:4:"6897";s:39:"htmlarea/plugins/Language/locallang.xml";s:4:"d16c";s:39:"htmlarea/plugins/QuickTag/locallang.xml";s:4:"4992";s:38:"htmlarea/plugins/QuickTag/quick-tag.js";s:4:"a8f1";s:43:"htmlarea/plugins/RemoveFormat/locallang.xml";s:4:"7eed";s:46:"htmlarea/plugins/RemoveFormat/remove-format.js";s:4:"fc26";s:42:"htmlarea/plugins/SelectColor/locallang.xml";s:4:"9f9e";s:42:"htmlarea/plugins/SelectFont/select-font.js";s:4:"d1a5";s:43:"htmlarea/plugins/SpellChecker/locallang.xml";s:4:"ddbe";s:51:"htmlarea/plugins/SpellChecker/spell-check-style.css";s:4:"3c70";s:46:"htmlarea/plugins/SpellChecker/spell-checker.js";s:4:"4a50";s:44:"htmlarea/plugins/TYPO3Browsers/locallang.xml";s:4:"89b8";s:47:"htmlarea/plugins/TYPO3Browsers/img/download.gif";s:4:"f6d9";s:52:"htmlarea/plugins/TYPO3Browsers/img/external_link.gif";s:4:"9e48";s:63:"htmlarea/plugins/TYPO3Browsers/img/external_link_new_window.gif";s:4:"6e8d";s:52:"htmlarea/plugins/TYPO3Browsers/img/internal_link.gif";s:4:"12b9";s:63:"htmlarea/plugins/TYPO3Browsers/img/internal_link_new_window.gif";s:4:"402a";s:43:"htmlarea/plugins/TYPO3Browsers/img/mail.gif";s:4:"d5a2";s:41:"htmlarea/plugins/TYPO3Color/locallang.xml";s:4:"3d3c";s:41:"htmlarea/plugins/TYPO3Color/typo3color.js";s:4:"9c08";s:46:"htmlarea/plugins/TYPO3HtmlParser/locallang.xml";s:4:"8010";s:52:"htmlarea/plugins/TYPO3HtmlParser/typo3html-parser.js";s:4:"6640";s:41:"htmlarea/plugins/TYPO3Image/locallang.xml";s:4:"ab27";s:41:"htmlarea/plugins/TYPO3Image/typo3image.js";s:4:"a56b";s:39:"htmlarea/plugins/TYPO3Link/typo3link.js";s:4:"8ff5";s:46:"htmlarea/plugins/TableOperations/locallang.xml";s:4:"dec1";s:52:"htmlarea/plugins/TableOperations/table-operations.js";s:4:"37d6";s:48:"htmlarea/plugins/TextIndicator/text-indicator.js";s:4:"26ea";s:40:"htmlarea/plugins/TextStyle/locallang.xml";s:4:"ff67";s:40:"htmlarea/plugins/TextStyle/text-style.js";s:4:"ef03";s:38:"htmlarea/plugins/UndoRedo/undo-redo.js";s:4:"3f2c";s:43:"htmlarea/plugins/UserElements/locallang.xml";s:4:"33f9";s:46:"htmlarea/plugins/UserElements/user-elements.js";s:4:"fabd";s:26:"htmlarea/popups/blank.html";s:4:"8d8d";s:32:"htmlarea/popups/editor_help.html";s:4:"398a";s:50:"htmlarea/skins/default/htmlarea-edited-content.css";s:4:"4741";s:35:"htmlarea/skins/default/htmlarea.css";s:4:"ad97";s:54:"htmlarea/skins/default/images/alt_menu_mainitem_bg.gif";s:4:"91c4";s:49:"htmlarea/skins/default/images/language-marker.gif";s:4:"7b48";s:44:"htmlarea/skins/default/images/row-header.png";s:4:"d4ba";s:50:"htmlarea/skins/default/images/system-help-open.png";s:4:"c6fd";s:59:"htmlarea/skins/default/images/actions/abbreviation-edit.gif";s:4:"1eaa";s:55:"htmlarea/skins/default/images/actions/bidi-override.gif";s:4:"f38b";s:45:"htmlarea/skins/default/images/actions/big.gif";s:4:"779b";s:52:"htmlarea/skins/default/images/actions/blockquote.gif";s:4:"34dc";s:46:"htmlarea/skins/default/images/actions/bold.gif";s:4:"06ac";s:53:"htmlarea/skins/default/images/actions/cell-delete.gif";s:4:"f371";s:62:"htmlarea/skins/default/images/actions/cell-edit-properties.gif";s:4:"ca41";s:59:"htmlarea/skins/default/images/actions/cell-insert-after.gif";s:4:"2dd2";s:60:"htmlarea/skins/default/images/actions/cell-insert-before.gif";s:4:"5d13";s:52:"htmlarea/skins/default/images/actions/cell-merge.gif";s:4:"cb52";s:52:"htmlarea/skins/default/images/actions/cell-split.gif";s:4:"0095";s:67:"htmlarea/skins/default/images/actions/character-insert-from-map.gif";s:4:"af19";s:50:"htmlarea/skins/default/images/actions/citation.gif";s:4:"b6eb";s:46:"htmlarea/skins/default/images/actions/code.gif";s:4:"6057";s:58:"htmlarea/skins/default/images/actions/color-background.gif";s:4:"d97c";s:58:"htmlarea/skins/default/images/actions/color-foreground.gif";s:4:"dbc8";s:55:"htmlarea/skins/default/images/actions/column-delete.gif";s:4:"da78";s:64:"htmlarea/skins/default/images/actions/column-edit-properties.gif";s:4:"b178";s:61:"htmlarea/skins/default/images/actions/column-insert-after.gif";s:4:"80d8";s:62:"htmlarea/skins/default/images/actions/column-insert-before.gif";s:4:"d47d";s:54:"htmlarea/skins/default/images/actions/column-split.gif";s:4:"c168";s:46:"htmlarea/skins/default/images/actions/copy.gif";s:4:"98d2";s:45:"htmlarea/skins/default/images/actions/cut.gif";s:4:"1323";s:62:"htmlarea/skins/default/images/actions/definition-list-item.gif";s:4:"33ae";s:57:"htmlarea/skins/default/images/actions/definition-list.gif";s:4:"d5d1";s:52:"htmlarea/skins/default/images/actions/definition.gif";s:4:"692d";s:53:"htmlarea/skins/default/images/actions/delete-item.gif";s:4:"926b";s:54:"htmlarea/skins/default/images/actions/deleted-text.gif";s:4:"4eec";s:59:"htmlarea/skins/default/images/actions/editor-show-about.gif";s:4:"1690";s:60:"htmlarea/skins/default/images/actions/editor-toggle-mode.gif";s:4:"fa6e";s:50:"htmlarea/skins/default/images/actions/emphasis.gif";s:4:"04c9";s:54:"htmlarea/skins/default/images/actions/find-replace.gif";s:4:"827f";s:64:"htmlarea/skins/default/images/actions/horizontal-rule-insert.gif";s:4:"f384";s:52:"htmlarea/skins/default/images/actions/image-edit.gif";s:4:"c0f0";s:48:"htmlarea/skins/default/images/actions/indent.gif";s:4:"57df";s:55:"htmlarea/skins/default/images/actions/inserted-text.gif";s:4:"a624";s:48:"htmlarea/skins/default/images/actions/italic.gif";s:4:"be83";s:56:"htmlarea/skins/default/images/actions/justify-center.gif";s:4:"420d";s:54:"htmlarea/skins/default/images/actions/justify-full.gif";s:4:"b129";s:54:"htmlarea/skins/default/images/actions/justify-left.gif";s:4:"3799";s:55:"htmlarea/skins/default/images/actions/justify-right.gif";s:4:"0662";s:50:"htmlarea/skins/default/images/actions/keyboard.gif";s:4:"53ac";s:61:"htmlarea/skins/default/images/actions/language-marks-show.gif";s:4:"0bbb";s:51:"htmlarea/skins/default/images/actions/link-edit.gif";s:4:"db9a";s:53:"htmlarea/skins/default/images/actions/mono-spaced.gif";s:4:"78c0";s:54:"htmlarea/skins/default/images/actions/ordered-list.gif";s:4:"eb1c";s:49:"htmlarea/skins/default/images/actions/outdent.gif";s:4:"4786";s:64:"htmlarea/skins/default/images/actions/paragraph-insert-after.gif";s:4:"e335";s:65:"htmlarea/skins/default/images/actions/paragraph-insert-before.gif";s:4:"9c42";s:47:"htmlarea/skins/default/images/actions/paste.gif";s:4:"7df5";s:51:"htmlarea/skins/default/images/actions/quotation.gif";s:4:"7c62";s:46:"htmlarea/skins/default/images/actions/redo.gif";s:4:"5fdf";s:55:"htmlarea/skins/default/images/actions/remove-format.gif";s:4:"2a0f";s:52:"htmlarea/skins/default/images/actions/row-delete.gif";s:4:"a289";s:61:"htmlarea/skins/default/images/actions/row-edit-properties.gif";s:4:"5344";s:58:"htmlarea/skins/default/images/actions/row-insert-above.gif";s:4:"1ef1";s:58:"htmlarea/skins/default/images/actions/row-insert-under.gif";s:4:"9ad6";s:51:"htmlarea/skins/default/images/actions/row-split.gif";s:4:"ebfd";s:48:"htmlarea/skins/default/images/actions/sample.gif";s:4:"667c";s:47:"htmlarea/skins/default/images/actions/small.gif";s:4:"e013";s:55:"htmlarea/skins/default/images/actions/smiley-insert.gif";s:4:"c331";s:46:"htmlarea/skins/default/images/actions/span.gif";s:4:"0dfa";s:53:"htmlarea/skins/default/images/actions/spell-check.gif";s:4:"6e0a";s:56:"htmlarea/skins/default/images/actions/strike-through.gif";s:4:"73b1";s:48:"htmlarea/skins/default/images/actions/strong.gif";s:4:"7f50";s:51:"htmlarea/skins/default/images/actions/subscript.gif";s:4:"36c0";s:53:"htmlarea/skins/default/images/actions/superscript.gif";s:4:"40c4";s:63:"htmlarea/skins/default/images/actions/table-edit-properties.gif";s:4:"0a5c";s:54:"htmlarea/skins/default/images/actions/table-insert.gif";s:4:"c01b";s:55:"htmlarea/skins/default/images/actions/table-restyle.gif";s:4:"9284";s:60:"htmlarea/skins/default/images/actions/table-show-borders.gif";s:4:"50cb";s:52:"htmlarea/skins/default/images/actions/tag-insert.gif";s:4:"a463";s:70:"htmlarea/skins/default/images/actions/text-direction-left-to-right.gif";s:4:"1a1f";s:70:"htmlarea/skins/default/images/actions/text-direction-right-to-left.gif";s:4:"2a38";s:51:"htmlarea/skins/default/images/actions/underline.gif";s:4:"dfac";s:46:"htmlarea/skins/default/images/actions/undo.gif";s:4:"8d53";s:48:"htmlarea/skins/default/images/actions/unlink.gif";s:4:"86c4";s:56:"htmlarea/skins/default/images/actions/unordered-list.gif";s:4:"5620";s:59:"htmlarea/skins/default/images/actions/user-element-edit.gif";s:4:"bbb4";s:50:"htmlarea/skins/default/images/actions/variable.gif";s:4:"da61";s:49:"htmlarea/skins/default/images/sprites/actions.png";s:4:"1070";s:59:"htmlarea/skins/default/images/status/dialog-information.png";s:4:"6856";s:50:"htmlarea/skins/default/images/status/dialog-ok.png";s:4:"4f05";s:54:"htmlarea/skins/default/images/status/loading-balls.gif";s:4:"821a";s:48:"htmlarea/skins/default/images/status/loading.gif";s:4:"82bc";s:50:"htmlarea/skins/default/images/status/resizable.gif";s:4:"83cf";s:18:"mod2/locallang.xml";s:4:"0cd8";s:21:"mod3/browse_links.php";s:4:"0e24";s:42:"mod3/class.tx_rtehtmlarea_browse_links.php";s:4:"7920";s:46:"mod3/class.tx_rtehtmlarea_dam_browse_links.php";s:4:"d4bd";s:14:"mod3/clear.gif";s:4:"cc11";s:13:"mod3/conf.php";s:4:"b2fb";s:18:"mod3/locallang.xml";s:4:"c052";s:46:"mod4/class.tx_rtehtmlarea_dam_browse_media.php";s:4:"3c83";s:42:"mod4/class.tx_rtehtmlarea_select_image.php";s:4:"93e9";s:14:"mod4/clear.gif";s:4:"cc11";s:13:"mod4/conf.php";s:4:"8598";s:18:"mod4/locallang.xml";s:4:"8995";s:21:"mod4/select_image.php";s:4:"fc8b";s:34:"mod5/class.tx_rtehtmlarea_user.php";s:4:"a71b";s:14:"mod5/clear.gif";s:4:"cc11";s:13:"mod5/conf.php";s:4:"7149";s:18:"mod5/locallang.xml";s:4:"7a78";s:13:"mod5/user.php";s:4:"f3c8";s:40:"mod6/class.tx_rtehtmlarea_parse_html.php";s:4:"63de";s:13:"mod6/conf.php";s:4:"0cab";s:19:"mod6/parse_html.php";s:4:"f4d8";s:32:"pi1/class.tx_rtehtmlarea_pi1.php";s:4:"aeef";s:17:"pi1/locallang.xml";s:4:"2e58";s:32:"pi2/class.tx_rtehtmlarea_pi2.php";s:4:"aceb";s:17:"pi2/locallang.xml";s:4:"a0a7";s:32:"pi3/class.tx_rtehtmlarea_pi3.php";s:4:"acb8";s:36:"res/accessibilityicons/locallang.xml";s:4:"8211";s:39:"res/accessibilityicons/pageTSConfig.txt";s:4:"7e1a";s:39:"res/accessibilityicons/img/download.gif";s:4:"f6d9";s:44:"res/accessibilityicons/img/external_link.gif";s:4:"9e48";s:55:"res/accessibilityicons/img/external_link_new_window.gif";s:4:"6e8d";s:44:"res/accessibilityicons/img/internal_link.gif";s:4:"12b9";s:55:"res/accessibilityicons/img/internal_link_new_window.gif";s:4:"402a";s:35:"res/accessibilityicons/img/mail.gif";s:4:"d5a2";s:29:"res/advanced/pageTSConfig.txt";s:4:"414e";s:29:"res/advanced/userTSConfig.txt";s:4:"8e7a";s:26:"res/contentcss/default.css";s:4:"429f";s:28:"res/contentcss/locallang.xml";s:4:"ec0e";s:39:"res/contentcss/img/red_arrow_bullet.gif";s:4:"82d6";s:25:"res/demo/pageTSConfig.txt";s:4:"34ad";s:25:"res/demo/userTSConfig.txt";s:4:"9b82";s:26:"res/image/pageTSConfig.txt";s:4:"9b6f";s:32:"res/indentalign/pageTSConfig.txt";s:4:"14d5";s:25:"res/proc/pageTSConfig.txt";s:4:"d4f8";s:26:"res/style/pageTSConfig.txt";s:4:"e8e7";s:28:"res/typical/pageTSConfig.txt";s:4:"d33d";s:28:"res/typical/userTSConfig.txt";s:4:"9fa6";s:29:"static/clickenlarge/setup.txt";s:4:"5681";}',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.2-0.0.0',
			'typo3' => '4.4.0-0.0.0',
		),
		'conflicts' => array(
			'rte_conf' => '',
		),
		'suggests' => array(
			'rtehtmlarea_api_manual' => '',
		),
	),
	'suggests' => array(
		'rtehtmlarea_api_manual' => '',
	),
);

?>