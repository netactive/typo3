<?php

########################################################################
# Extension Manager/Repository config file for ext "rtehtmlarea".
#
# Auto generated 25-11-2009 22:08
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
	'module' => 'mod2,mod3,mod4,mod5,mod6',
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
	'version' => '1.8.12',
	'_md5_values_when_last_written' => 'a:434:{s:9:"ChangeLog";s:4:"e5f3";s:29:"class.tx_rtehtmlarea_base.php";s:4:"8a14";s:27:"class.tx_rtehtmlareaapi.php";s:4:"69b4";s:21:"ext_conf_template.txt";s:4:"afd8";s:12:"ext_icon.gif";s:4:"2f41";s:17:"ext_localconf.php";s:4:"340c";s:14:"ext_tables.php";s:4:"ea2e";s:14:"ext_tables.sql";s:4:"bba8";s:13:"locallang.xml";s:4:"3cca";s:16:"locallang_db.xml";s:4:"c2ed";s:7:"tca.php";s:4:"6b5a";s:14:"doc/manual.sxw";s:4:"e68c";s:59:"extensions/AboutEditor/class.tx_rtehtmlarea_abouteditor.php";s:4:"d8ac";s:40:"extensions/AboutEditor/skin/htmlarea.css";s:4:"eb62";s:44:"extensions/AboutEditor/skin/images/about.gif";s:4:"1690";s:51:"extensions/Acronym/class.tx_rtehtmlarea_acronym.php";s:4:"ee28";s:36:"extensions/Acronym/skin/htmlarea.css";s:4:"c107";s:42:"extensions/Acronym/skin/images/acronym.gif";s:4:"1eaa";s:63:"extensions/BlockElements/class.tx_rtehtmlarea_blockelements.php";s:4:"aeef";s:38:"extensions/BlockElements/locallang.xml";s:4:"479e";s:42:"extensions/BlockElements/skin/htmlarea.css";s:4:"83ce";s:51:"extensions/BlockElements/skin/images/blockquote.gif";s:4:"34dc";s:47:"extensions/BlockElements/skin/images/indent.gif";s:4:"57df";s:58:"extensions/BlockElements/skin/images/insertOrderedList.gif";s:4:"eb1c";s:61:"extensions/BlockElements/skin/images/insertParagraphAfter.gif";s:4:"e335";s:62:"extensions/BlockElements/skin/images/insertParagraphBefore.gif";s:4:"9c42";s:60:"extensions/BlockElements/skin/images/insertUnorderedList.gif";s:4:"5620";s:54:"extensions/BlockElements/skin/images/justifyCenter.gif";s:4:"420d";s:52:"extensions/BlockElements/skin/images/justifyFull.gif";s:4:"b129";s:52:"extensions/BlockElements/skin/images/justifyLeft.gif";s:4:"3799";s:53:"extensions/BlockElements/skin/images/justifyRight.gif";s:4:"0662";s:48:"extensions/BlockElements/skin/images/outdent.gif";s:4:"4786";s:57:"extensions/BlockStyle/class.tx_rtehtmlarea_blockstyle.php";s:4:"3ba0";s:35:"extensions/BlockStyle/locallang.xml";s:4:"26b8";s:61:"extensions/CharacterMap/class.tx_rtehtmlarea_charactermap.php";s:4:"a537";s:41:"extensions/CharacterMap/skin/htmlarea.css";s:4:"06c8";s:55:"extensions/CharacterMap/skin/images/insertCharacter.gif";s:4:"af19";s:59:"extensions/ContextMenu/class.tx_rtehtmlarea_contextmenu.php";s:4:"e4b5";s:55:"extensions/CopyPaste/class.tx_rtehtmlarea_copypaste.php";s:4:"09ad";s:38:"extensions/CopyPaste/skin/htmlarea.css";s:4:"9391";s:41:"extensions/CopyPaste/skin/images/copy.gif";s:4:"98d2";s:40:"extensions/CopyPaste/skin/images/cut.gif";s:4:"1323";s:42:"extensions/CopyPaste/skin/images/paste.gif";s:4:"7df5";s:61:"extensions/DefaultClean/class.tx_rtehtmlarea_defaultclean.php";s:4:"142b";s:61:"extensions/DefaultColor/class.tx_rtehtmlarea_defaultcolor.php";s:4:"fa59";s:37:"extensions/DefaultColor/locallang.xml";s:4:"3fb4";s:41:"extensions/DefaultColor/skin/htmlarea.css";s:4:"6076";s:49:"extensions/DefaultColor/skin/images/forecolor.gif";s:4:"dbc8";s:51:"extensions/DefaultColor/skin/images/hilitecolor.gif";s:4:"d97c";s:59:"extensions/DefaultFont/class.tx_rtehtmlarea_defaultfont.php";s:4:"2172";s:36:"extensions/DefaultFont/locallang.xml";s:4:"8c90";s:61:"extensions/DefaultImage/class.tx_rtehtmlarea_defaultimage.php";s:4:"12cf";s:41:"extensions/DefaultImage/skin/htmlarea.css";s:4:"6cfe";s:45:"extensions/DefaultImage/skin/images/image.gif";s:4:"c0f0";s:63:"extensions/DefaultInline/class.tx_rtehtmlarea_defaultinline.php";s:4:"4e85";s:38:"extensions/DefaultInline/locallang.xml";s:4:"318f";s:42:"extensions/DefaultInline/skin/htmlarea.css";s:4:"6009";s:45:"extensions/DefaultInline/skin/images/bold.gif";s:4:"94f2";s:47:"extensions/DefaultInline/skin/images/italic.gif";s:4:"f60c";s:54:"extensions/DefaultInline/skin/images/strikethrough.gif";s:4:"3fd0";s:50:"extensions/DefaultInline/skin/images/subscript.gif";s:4:"cedd";s:52:"extensions/DefaultInline/skin/images/superscript.gif";s:4:"8aea";s:50:"extensions/DefaultInline/skin/images/underline.gif";s:4:"81e6";s:59:"extensions/DefaultLink/class.tx_rtehtmlarea_defaultlink.php";s:4:"2219";s:40:"extensions/DefaultLink/skin/htmlarea.css";s:4:"680b";s:43:"extensions/DefaultLink/skin/images/link.gif";s:4:"db9a";s:45:"extensions/DefaultLink/skin/images/unlink.gif";s:4:"86c4";s:65:"extensions/DefinitionList/class.tx_rtehtmlarea_definitionlist.php";s:4:"483d";s:43:"extensions/DefinitionList/skin/htmlarea.css";s:4:"a254";s:56:"extensions/DefinitionList/skin/images/definitionItem.gif";s:4:"33ae";s:56:"extensions/DefinitionList/skin/images/definitionList.gif";s:4:"d5d1";s:57:"extensions/EditorMode/class.tx_rtehtmlarea_editormode.php";s:4:"1453";s:39:"extensions/EditorMode/skin/htmlarea.css";s:4:"0793";s:45:"extensions/EditorMode/skin/images/ed_html.gif";s:4:"fa6e";s:59:"extensions/FindReplace/class.tx_rtehtmlarea_findreplace.php";s:4:"a968";s:40:"extensions/FindReplace/skin/htmlarea.css";s:4:"43cc";s:43:"extensions/FindReplace/skin/images/find.gif";s:4:"827f";s:65:"extensions/InlineElements/class.tx_rtehtmlarea_inlineelements.php";s:4:"452a";s:39:"extensions/InlineElements/locallang.xml";s:4:"07c6";s:46:"extensions/InlineElements/res/pageTSConfig.txt";s:4:"088c";s:43:"extensions/InlineElements/skin/htmlarea.css";s:4:"978b";s:54:"extensions/InlineElements/skin/images/bidioverride.gif";s:4:"f38b";s:45:"extensions/InlineElements/skin/images/big.gif";s:4:"779b";s:46:"extensions/InlineElements/skin/images/bold.gif";s:4:"06ac";s:50:"extensions/InlineElements/skin/images/citation.gif";s:4:"b6eb";s:46:"extensions/InlineElements/skin/images/code.gif";s:4:"6057";s:52:"extensions/InlineElements/skin/images/definition.gif";s:4:"692d";s:53:"extensions/InlineElements/skin/images/deletedtext.gif";s:4:"4eec";s:50:"extensions/InlineElements/skin/images/emphasis.gif";s:4:"04c9";s:54:"extensions/InlineElements/skin/images/insertedtext.gif";s:4:"a624";s:48:"extensions/InlineElements/skin/images/italic.gif";s:4:"be83";s:50:"extensions/InlineElements/skin/images/keyboard.gif";s:4:"53ac";s:52:"extensions/InlineElements/skin/images/monospaced.gif";s:4:"78c0";s:51:"extensions/InlineElements/skin/images/quotation.gif";s:4:"7c62";s:48:"extensions/InlineElements/skin/images/sample.gif";s:4:"667c";s:47:"extensions/InlineElements/skin/images/small.gif";s:4:"e013";s:46:"extensions/InlineElements/skin/images/span.gif";s:4:"0dfa";s:55:"extensions/InlineElements/skin/images/strikethrough.gif";s:4:"73b1";s:48:"extensions/InlineElements/skin/images/strong.gif";s:4:"7f50";s:51:"extensions/InlineElements/skin/images/subscript.gif";s:4:"36c0";s:53:"extensions/InlineElements/skin/images/superscript.gif";s:4:"40c4";s:51:"extensions/InlineElements/skin/images/underline.gif";s:4:"dfac";s:50:"extensions/InlineElements/skin/images/variable.gif";s:4:"da61";s:61:"extensions/InsertSmiley/class.tx_rtehtmlarea_insertsmiley.php";s:4:"4d97";s:41:"extensions/InsertSmiley/skin/htmlarea.css";s:4:"fb52";s:46:"extensions/InsertSmiley/skin/images/smiley.gif";s:4:"c331";s:53:"extensions/Language/class.tx_rtehtmlarea_language.php";s:4:"4f0b";s:33:"extensions/Language/locallang.xml";s:4:"ff62";s:37:"extensions/Language/skin/htmlarea.css";s:4:"7034";s:49:"extensions/Language/skin/images/left_to_right.gif";s:4:"1a1f";s:49:"extensions/Language/skin/images/right_to_left.gif";s:4:"2a38";s:55:"extensions/Language/skin/images/show-language-marks.gif";s:4:"0bbb";s:53:"extensions/QuickTag/class.tx_rtehtmlarea_quicktag.php";s:4:"c925";s:37:"extensions/QuickTag/skin/htmlarea.css";s:4:"b006";s:45:"extensions/QuickTag/skin/images/inserttag.gif";s:4:"a463";s:61:"extensions/RemoveFormat/class.tx_rtehtmlarea_removeformat.php";s:4:"f7a1";s:41:"extensions/RemoveFormat/skin/htmlarea.css";s:4:"be33";s:45:"extensions/RemoveFormat/skin/images/clean.gif";s:4:"2a0f";s:57:"extensions/SelectFont/class.tx_rtehtmlarea_selectfont.php";s:4:"281e";s:35:"extensions/SelectFont/locallang.xml";s:4:"cb6e";s:61:"extensions/SpellChecker/class.tx_rtehtmlarea_spellchecker.php";s:4:"9c27";s:41:"extensions/SpellChecker/skin/htmlarea.css";s:4:"cedf";s:51:"extensions/SpellChecker/skin/images/spell-check.gif";s:4:"6e0a";s:55:"extensions/StatusBar/class.tx_rtehtmlarea_statusbar.php";s:4:"7db4";s:57:"extensions/TYPO3Color/class.tx_rtehtmlarea_typo3color.php";s:4:"daad";s:35:"extensions/TYPO3Color/locallang.xml";s:4:"377f";s:39:"extensions/TYPO3Color/skin/htmlarea.css";s:4:"fad4";s:47:"extensions/TYPO3Color/skin/images/forecolor.gif";s:4:"dbc8";s:49:"extensions/TYPO3Color/skin/images/hilitecolor.gif";s:4:"d97c";s:67:"extensions/TYPO3HtmlParser/class.tx_rtehtmlarea_typo3htmlparser.php";s:4:"b885";s:57:"extensions/TYPO3Image/class.tx_rtehtmlarea_typo3image.php";s:4:"55d0";s:39:"extensions/TYPO3Image/skin/htmlarea.css";s:4:"f593";s:43:"extensions/TYPO3Image/skin/images/image.gif";s:4:"c0f0";s:55:"extensions/TYPO3Link/class.tx_rtehtmlarea_typo3link.php";s:4:"50b8";s:38:"extensions/TYPO3Link/skin/htmlarea.css";s:4:"73f9";s:41:"extensions/TYPO3Link/skin/images/link.gif";s:4:"db9a";s:43:"extensions/TYPO3Link/skin/images/unlink.gif";s:4:"86c4";s:67:"extensions/TableOperations/class.tx_rtehtmlarea_tableoperations.php";s:4:"56ba";s:44:"extensions/TableOperations/skin/htmlarea.css";s:4:"b57e";s:54:"extensions/TableOperations/skin/images/cell-delete.gif";s:4:"f371";s:60:"extensions/TableOperations/skin/images/cell-insert-after.gif";s:4:"2dd2";s:61:"extensions/TableOperations/skin/images/cell-insert-before.gif";s:4:"5d13";s:53:"extensions/TableOperations/skin/images/cell-merge.gif";s:4:"cb52";s:52:"extensions/TableOperations/skin/images/cell-prop.gif";s:4:"ca41";s:53:"extensions/TableOperations/skin/images/cell-split.gif";s:4:"0095";s:53:"extensions/TableOperations/skin/images/col-delete.gif";s:4:"da78";s:59:"extensions/TableOperations/skin/images/col-insert-after.gif";s:4:"80d8";s:60:"extensions/TableOperations/skin/images/col-insert-before.gif";s:4:"d47d";s:51:"extensions/TableOperations/skin/images/col-prop.gif";s:4:"b178";s:52:"extensions/TableOperations/skin/images/col-split.gif";s:4:"c168";s:55:"extensions/TableOperations/skin/images/insert_table.gif";s:4:"c01b";s:53:"extensions/TableOperations/skin/images/row-delete.gif";s:4:"a289";s:59:"extensions/TableOperations/skin/images/row-insert-above.gif";s:4:"1ef1";s:59:"extensions/TableOperations/skin/images/row-insert-under.gif";s:4:"9ad6";s:51:"extensions/TableOperations/skin/images/row-prop.gif";s:4:"5344";s:52:"extensions/TableOperations/skin/images/row-split.gif";s:4:"ebfd";s:53:"extensions/TableOperations/skin/images/table-prop.gif";s:4:"0a5c";s:56:"extensions/TableOperations/skin/images/table-restyle.gif";s:4:"9284";s:57:"extensions/TableOperations/skin/images/toggle-borders.gif";s:4:"50cb";s:55:"extensions/TextStyle/class.tx_rtehtmlarea_textstyle.php";s:4:"ed42";s:34:"extensions/TextStyle/locallang.xml";s:4:"23dd";s:53:"extensions/UndoRedo/class.tx_rtehtmlarea_undoredo.php";s:4:"d297";s:37:"extensions/UndoRedo/skin/htmlarea.css";s:4:"de26";s:40:"extensions/UndoRedo/skin/images/redo.gif";s:4:"5fdf";s:40:"extensions/UndoRedo/skin/images/undo.gif";s:4:"8d53";s:61:"extensions/UserElements/class.tx_rtehtmlarea_userelements.php";s:4:"984d";s:41:"extensions/UserElements/skin/htmlarea.css";s:4:"f66d";s:44:"extensions/UserElements/skin/images/user.gif";s:4:"bbb4";s:59:"hooks/clearrtecache/class.tx_rtehtmlarea_clearcachemenu.php";s:4:"b8fe";s:58:"hooks/clearrtecache/class.tx_rtehtmlarea_clearrtecache.php";s:4:"a33e";s:37:"hooks/clearrtecache/clearrtecache.png";s:4:"e03a";s:37:"hooks/clearrtecache/ext_localconf.php";s:4:"3cbb";s:33:"hooks/clearrtecache/locallang.xml";s:4:"3902";s:29:"htmlarea/HTMLAREA_LICENSE.txt";s:4:"a10f";s:26:"htmlarea/htmlarea-gecko.js";s:4:"786d";s:23:"htmlarea/htmlarea-ie.js";s:4:"601e";s:20:"htmlarea/htmlarea.js";s:4:"6dde";s:30:"htmlarea/locallang_dialogs.xml";s:4:"a7aa";s:26:"htmlarea/locallang_msg.xml";s:4:"7b6f";s:31:"htmlarea/locallang_tooltips.xml";s:4:"0152";s:44:"htmlarea/plugins/AboutEditor/about-editor.js";s:4:"8241";s:46:"htmlarea/plugins/AboutEditor/popups/about.html";s:4:"d677";s:35:"htmlarea/plugins/Acronym/acronym.js";s:4:"f9af";s:38:"htmlarea/plugins/Acronym/locallang.xml";s:4:"aea2";s:48:"htmlarea/plugins/BlockElements/block-elements.js";s:4:"4c56";s:44:"htmlarea/plugins/BlockElements/locallang.xml";s:4:"ee21";s:42:"htmlarea/plugins/BlockStyle/block-style.js";s:4:"d9e7";s:41:"htmlarea/plugins/BlockStyle/locallang.xml";s:4:"32ed";s:46:"htmlarea/plugins/CharacterMap/character-map.js";s:4:"3b2b";s:43:"htmlarea/plugins/CharacterMap/locallang.xml";s:4:"7211";s:58:"htmlarea/plugins/CharacterMap/popups/select_character.html";s:4:"c48a";s:44:"htmlarea/plugins/ContextMenu/context-menu.js";s:4:"d88e";s:42:"htmlarea/plugins/ContextMenu/locallang.xml";s:4:"3ead";s:40:"htmlarea/plugins/CopyPaste/copy-paste.js";s:4:"427b";s:40:"htmlarea/plugins/CopyPaste/locallang.xml";s:4:"6703";s:46:"htmlarea/plugins/DefaultClean/default-clean.js";s:4:"409f";s:43:"htmlarea/plugins/DefaultClean/locallang.xml";s:4:"9e62";s:46:"htmlarea/plugins/DefaultColor/default-color.js";s:4:"3c23";s:43:"htmlarea/plugins/DefaultColor/locallang.xml";s:4:"c8d1";s:54:"htmlarea/plugins/DefaultColor/popups/select_color.html";s:4:"8af8";s:44:"htmlarea/plugins/DefaultFont/default-font.js";s:4:"8d1c";s:42:"htmlarea/plugins/DefaultFont/locallang.xml";s:4:"a7f8";s:46:"htmlarea/plugins/DefaultImage/default-image.js";s:4:"9ca0";s:43:"htmlarea/plugins/DefaultImage/locallang.xml";s:4:"1fdd";s:54:"htmlarea/plugins/DefaultImage/popups/insert_image.html";s:4:"6773";s:48:"htmlarea/plugins/DefaultInline/default-inline.js";s:4:"c303";s:44:"htmlarea/plugins/DefaultInline/locallang.xml";s:4:"2b55";s:44:"htmlarea/plugins/DefaultLink/default-link.js";s:4:"3139";s:42:"htmlarea/plugins/DefaultLink/locallang.xml";s:4:"e233";s:45:"htmlarea/plugins/DefaultLink/popups/link.html";s:4:"6157";s:50:"htmlarea/plugins/DefinitionList/definition-list.js";s:4:"581b";s:45:"htmlarea/plugins/DefinitionList/locallang.xml";s:4:"5c85";s:42:"htmlarea/plugins/DynamicCSS/dynamiccss.css";s:4:"85b7";s:41:"htmlarea/plugins/DynamicCSS/locallang.xml";s:4:"b6bf";s:52:"htmlarea/plugins/DynamicCSS/img/red_arrow_bullet.gif";s:4:"82d6";s:42:"htmlarea/plugins/EditorMode/editor-mode.js";s:4:"eaab";s:41:"htmlarea/plugins/EditorMode/locallang.xml";s:4:"5b14";s:44:"htmlarea/plugins/FindReplace/find-replace.js";s:4:"5caf";s:41:"htmlarea/plugins/FindReplace/fr_engine.js";s:4:"4ce4";s:42:"htmlarea/plugins/FindReplace/locallang.xml";s:4:"f836";s:53:"htmlarea/plugins/FindReplace/popups/find_replace.html";s:4:"4ee2";s:40:"htmlarea/plugins/InlineCSS/locallang.xml";s:4:"7840";s:50:"htmlarea/plugins/InlineElements/inline-elements.js";s:4:"d31a";s:45:"htmlarea/plugins/InlineElements/locallang.xml";s:4:"6f8c";s:46:"htmlarea/plugins/InsertSmiley/insert-smiley.js";s:4:"23a1";s:43:"htmlarea/plugins/InsertSmiley/locallang.xml";s:4:"ed64";s:54:"htmlarea/plugins/InsertSmiley/popups/insertsmiley.html";s:4:"6ece";s:46:"htmlarea/plugins/InsertSmiley/smileys/0001.gif";s:4:"4aff";s:46:"htmlarea/plugins/InsertSmiley/smileys/0002.gif";s:4:"02c4";s:46:"htmlarea/plugins/InsertSmiley/smileys/0003.gif";s:4:"834f";s:46:"htmlarea/plugins/InsertSmiley/smileys/0004.gif";s:4:"fb6a";s:46:"htmlarea/plugins/InsertSmiley/smileys/0005.gif";s:4:"2a48";s:46:"htmlarea/plugins/InsertSmiley/smileys/0006.gif";s:4:"f970";s:46:"htmlarea/plugins/InsertSmiley/smileys/0007.gif";s:4:"97ee";s:46:"htmlarea/plugins/InsertSmiley/smileys/0008.gif";s:4:"10a6";s:46:"htmlarea/plugins/InsertSmiley/smileys/0009.gif";s:4:"1907";s:46:"htmlarea/plugins/InsertSmiley/smileys/0010.gif";s:4:"9ee6";s:46:"htmlarea/plugins/InsertSmiley/smileys/0011.gif";s:4:"ae73";s:46:"htmlarea/plugins/InsertSmiley/smileys/0012.gif";s:4:"f058";s:46:"htmlarea/plugins/InsertSmiley/smileys/0013.gif";s:4:"3ed8";s:46:"htmlarea/plugins/InsertSmiley/smileys/0014.gif";s:4:"a948";s:46:"htmlarea/plugins/InsertSmiley/smileys/0015.gif";s:4:"218d";s:46:"htmlarea/plugins/InsertSmiley/smileys/0016.gif";s:4:"3539";s:46:"htmlarea/plugins/InsertSmiley/smileys/0017.gif";s:4:"ee2e";s:46:"htmlarea/plugins/InsertSmiley/smileys/0018.gif";s:4:"8c66";s:46:"htmlarea/plugins/InsertSmiley/smileys/0019.gif";s:4:"ac36";s:46:"htmlarea/plugins/InsertSmiley/smileys/0020.gif";s:4:"71ef";s:37:"htmlarea/plugins/Language/language.js";s:4:"f923";s:39:"htmlarea/plugins/Language/locallang.xml";s:4:"d16c";s:39:"htmlarea/plugins/QuickTag/locallang.xml";s:4:"2f53";s:38:"htmlarea/plugins/QuickTag/quick-tag.js";s:4:"3efd";s:36:"htmlarea/plugins/QuickTag/tag-lib.js";s:4:"ba71";s:46:"htmlarea/plugins/QuickTag/popups/quicktag.html";s:4:"9f4b";s:43:"htmlarea/plugins/RemoveFormat/locallang.xml";s:4:"aa85";s:46:"htmlarea/plugins/RemoveFormat/remove-format.js";s:4:"cbbb";s:54:"htmlarea/plugins/RemoveFormat/popups/removeformat.html";s:4:"061e";s:42:"htmlarea/plugins/SelectColor/locallang.xml";s:4:"9f9e";s:42:"htmlarea/plugins/SelectFont/select-font.js";s:4:"af22";s:43:"htmlarea/plugins/SpellChecker/locallang.xml";s:4:"20d8";s:51:"htmlarea/plugins/SpellChecker/spell-check-style.css";s:4:"82bd";s:47:"htmlarea/plugins/SpellChecker/spell-check-ui.js";s:4:"7831";s:46:"htmlarea/plugins/SpellChecker/spell-checker.js";s:4:"c8a9";s:67:"htmlarea/plugins/SpellChecker/popups/spell-check-ui-iso-8859-1.html";s:4:"8a95";s:56:"htmlarea/plugins/SpellChecker/popups/spell-check-ui.html";s:4:"61dc";s:40:"htmlarea/plugins/StatusBar/status-bar.js";s:4:"c578";s:44:"htmlarea/plugins/TYPO3Browsers/locallang.xml";s:4:"89b8";s:47:"htmlarea/plugins/TYPO3Browsers/img/download.gif";s:4:"f6d9";s:52:"htmlarea/plugins/TYPO3Browsers/img/external_link.gif";s:4:"9e48";s:63:"htmlarea/plugins/TYPO3Browsers/img/external_link_new_window.gif";s:4:"6e8d";s:52:"htmlarea/plugins/TYPO3Browsers/img/internal_link.gif";s:4:"12b9";s:63:"htmlarea/plugins/TYPO3Browsers/img/internal_link_new_window.gif";s:4:"402a";s:43:"htmlarea/plugins/TYPO3Browsers/img/mail.gif";s:4:"d5a2";s:41:"htmlarea/plugins/TYPO3Color/locallang.xml";s:4:"3d3c";s:41:"htmlarea/plugins/TYPO3Color/typo3color.js";s:4:"5afa";s:46:"htmlarea/plugins/TYPO3HtmlParser/locallang.xml";s:4:"8010";s:52:"htmlarea/plugins/TYPO3HtmlParser/typo3html-parser.js";s:4:"99ea";s:41:"htmlarea/plugins/TYPO3Image/locallang.xml";s:4:"ab27";s:41:"htmlarea/plugins/TYPO3Image/typo3image.js";s:4:"ccc3";s:39:"htmlarea/plugins/TYPO3Link/typo3link.js";s:4:"677d";s:46:"htmlarea/plugins/TableOperations/locallang.xml";s:4:"e7ed";s:52:"htmlarea/plugins/TableOperations/table-operations.js";s:4:"1bbc";s:40:"htmlarea/plugins/TextStyle/locallang.xml";s:4:"ff67";s:40:"htmlarea/plugins/TextStyle/text-style.js";s:4:"7356";s:38:"htmlarea/plugins/UndoRedo/undo-redo.js";s:4:"762b";s:43:"htmlarea/plugins/UserElements/locallang.xml";s:4:"33f9";s:46:"htmlarea/plugins/UserElements/user-elements.js";s:4:"52c7";s:26:"htmlarea/popups/blank.html";s:4:"8d8d";s:32:"htmlarea/popups/editor_help.html";s:4:"398a";s:50:"htmlarea/skins/default/htmlarea-edited-content.css";s:4:"6626";s:35:"htmlarea/skins/default/htmlarea.css";s:4:"5112";s:48:"htmlarea/skins/default/images/definitionItem.gif";s:4:"33ae";s:48:"htmlarea/skins/default/images/definitionList.gif";s:4:"d5d1";s:42:"htmlarea/skins/default/images/ed_about.gif";s:4:"2763";s:42:"htmlarea/skins/default/images/ed_blank.gif";s:4:"0208";s:45:"htmlarea/skins/default/images/ed_color_bg.gif";s:4:"c6e2";s:45:"htmlarea/skins/default/images/ed_color_fg.gif";s:4:"5d7f";s:41:"htmlarea/skins/default/images/ed_copy.gif";s:4:"4f55";s:43:"htmlarea/skins/default/images/ed_custom.gif";s:4:"e7b2";s:40:"htmlarea/skins/default/images/ed_cut.gif";s:4:"1b00";s:43:"htmlarea/skins/default/images/ed_delete.gif";s:4:"926b";s:41:"htmlarea/skins/default/images/ed_help.gif";s:4:"e7fc";s:39:"htmlarea/skins/default/images/ed_hr.gif";s:4:"f384";s:41:"htmlarea/skins/default/images/ed_html.gif";s:4:"fa6e";s:42:"htmlarea/skins/default/images/ed_image.gif";s:4:"c0f0";s:50:"htmlarea/skins/default/images/ed_left_to_right.gif";s:4:"1a1f";s:41:"htmlarea/skins/default/images/ed_link.gif";s:4:"db9a";s:48:"htmlarea/skins/default/images/ed_list_bullet.gif";s:4:"5620";s:45:"htmlarea/skins/default/images/ed_list_num.gif";s:4:"eb1c";s:42:"htmlarea/skins/default/images/ed_paste.gif";s:4:"fbd2";s:41:"htmlarea/skins/default/images/ed_redo.gif";s:4:"e9e8";s:50:"htmlarea/skins/default/images/ed_right_to_left.gif";s:4:"2a38";s:41:"htmlarea/skins/default/images/ed_save.gif";s:4:"07ad";s:47:"htmlarea/skins/default/images/ed_splitblock.gif";s:4:"503e";s:45:"htmlarea/skins/default/images/ed_splitcel.gif";s:4:"2c04";s:41:"htmlarea/skins/default/images/ed_undo.gif";s:4:"b9ba";s:43:"htmlarea/skins/default/images/ed_unlink.gif";s:4:"86c4";s:53:"htmlarea/skins/default/images/fullscreen_maximize.gif";s:4:"2118";s:53:"htmlarea/skins/default/images/fullscreen_minimize.gif";s:4:"91d6";s:46:"htmlarea/skins/default/images/insert_table.gif";s:4:"c01b";s:49:"htmlarea/skins/default/images/language-marker.gif";s:4:"7b48";s:53:"htmlarea/skins/default/images/show-language-marks.gif";s:4:"0bbb";s:52:"htmlarea/skins/default/images/Acronym/ed_acronym.gif";s:4:"1eaa";s:58:"htmlarea/skins/default/images/BlockElements/blockquote.gif";s:4:"34dc";s:54:"htmlarea/skins/default/images/BlockElements/indent.gif";s:4:"57df";s:68:"htmlarea/skins/default/images/BlockElements/insertParagraphAfter.gif";s:4:"e335";s:69:"htmlarea/skins/default/images/BlockElements/insertParagraphBefore.gif";s:4:"9c42";s:61:"htmlarea/skins/default/images/BlockElements/justifyCenter.gif";s:4:"420d";s:59:"htmlarea/skins/default/images/BlockElements/justifyFull.gif";s:4:"b129";s:59:"htmlarea/skins/default/images/BlockElements/justifyLeft.gif";s:4:"3799";s:60:"htmlarea/skins/default/images/BlockElements/justifyRight.gif";s:4:"0662";s:55:"htmlarea/skins/default/images/BlockElements/outdent.gif";s:4:"4786";s:57:"htmlarea/skins/default/images/CharacterMap/ed_charmap.gif";s:4:"af19";s:53:"htmlarea/skins/default/images/FindReplace/ed_find.gif";s:4:"827f";s:61:"htmlarea/skins/default/images/InlineElements/bidioverride.gif";s:4:"f38b";s:52:"htmlarea/skins/default/images/InlineElements/big.gif";s:4:"779b";s:53:"htmlarea/skins/default/images/InlineElements/bold.gif";s:4:"06ac";s:57:"htmlarea/skins/default/images/InlineElements/citation.gif";s:4:"b6eb";s:53:"htmlarea/skins/default/images/InlineElements/code.gif";s:4:"6057";s:59:"htmlarea/skins/default/images/InlineElements/definition.gif";s:4:"692d";s:60:"htmlarea/skins/default/images/InlineElements/deletedtext.gif";s:4:"4eec";s:57:"htmlarea/skins/default/images/InlineElements/emphasis.gif";s:4:"04c9";s:61:"htmlarea/skins/default/images/InlineElements/insertedtext.gif";s:4:"a624";s:55:"htmlarea/skins/default/images/InlineElements/italic.gif";s:4:"be83";s:57:"htmlarea/skins/default/images/InlineElements/keyboard.gif";s:4:"53ac";s:59:"htmlarea/skins/default/images/InlineElements/monospaced.gif";s:4:"78c0";s:58:"htmlarea/skins/default/images/InlineElements/quotation.gif";s:4:"7c62";s:55:"htmlarea/skins/default/images/InlineElements/sample.gif";s:4:"667c";s:54:"htmlarea/skins/default/images/InlineElements/small.gif";s:4:"e013";s:53:"htmlarea/skins/default/images/InlineElements/span.gif";s:4:"0dfa";s:62:"htmlarea/skins/default/images/InlineElements/strikethrough.gif";s:4:"73b1";s:55:"htmlarea/skins/default/images/InlineElements/strong.gif";s:4:"7f50";s:58:"htmlarea/skins/default/images/InlineElements/subscript.gif";s:4:"36c0";s:60:"htmlarea/skins/default/images/InlineElements/superscript.gif";s:4:"40c4";s:58:"htmlarea/skins/default/images/InlineElements/underline.gif";s:4:"dfac";s:57:"htmlarea/skins/default/images/InlineElements/variable.gif";s:4:"da61";s:56:"htmlarea/skins/default/images/InsertSmiley/ed_smiley.gif";s:4:"c331";s:54:"htmlarea/skins/default/images/QuickTag/ed_quicktag.gif";s:4:"a463";s:55:"htmlarea/skins/default/images/RemoveFormat/ed_clean.gif";s:4:"2a0f";s:58:"htmlarea/skins/default/images/SpellChecker/spell-check.gif";s:4:"6e0a";s:59:"htmlarea/skins/default/images/TYPO3ViewHelp/module_help.gif";s:4:"a500";s:61:"htmlarea/skins/default/images/TableOperations/cell-delete.gif";s:4:"f371";s:67:"htmlarea/skins/default/images/TableOperations/cell-insert-after.gif";s:4:"2dd2";s:68:"htmlarea/skins/default/images/TableOperations/cell-insert-before.gif";s:4:"5d13";s:60:"htmlarea/skins/default/images/TableOperations/cell-merge.gif";s:4:"a2d2";s:59:"htmlarea/skins/default/images/TableOperations/cell-prop.gif";s:4:"ca41";s:60:"htmlarea/skins/default/images/TableOperations/cell-split.gif";s:4:"d87c";s:60:"htmlarea/skins/default/images/TableOperations/col-delete.gif";s:4:"da78";s:66:"htmlarea/skins/default/images/TableOperations/col-insert-after.gif";s:4:"80d8";s:67:"htmlarea/skins/default/images/TableOperations/col-insert-before.gif";s:4:"d47d";s:58:"htmlarea/skins/default/images/TableOperations/col-prop.gif";s:4:"b178";s:59:"htmlarea/skins/default/images/TableOperations/col-split.gif";s:4:"eacc";s:62:"htmlarea/skins/default/images/TableOperations/insert_table.gif";s:4:"c1db";s:60:"htmlarea/skins/default/images/TableOperations/row-delete.gif";s:4:"a289";s:66:"htmlarea/skins/default/images/TableOperations/row-insert-above.gif";s:4:"1ef1";s:66:"htmlarea/skins/default/images/TableOperations/row-insert-after.gif";s:4:"5e98";s:66:"htmlarea/skins/default/images/TableOperations/row-insert-under.gif";s:4:"9ad6";s:58:"htmlarea/skins/default/images/TableOperations/row-prop.gif";s:4:"5344";s:59:"htmlarea/skins/default/images/TableOperations/row-split.gif";s:4:"a712";s:60:"htmlarea/skins/default/images/TableOperations/table-prop.gif";s:4:"0a5c";s:63:"htmlarea/skins/default/images/TableOperations/table-restyle.gif";s:4:"9284";s:64:"htmlarea/skins/default/images/TableOperations/toggle-borders.gif";s:4:"50cb";s:54:"htmlarea/skins/default/images/UserElements/ed_user.gif";s:4:"bbb4";s:16:"mod2/acronym.php";s:4:"6dce";s:41:"mod2/class.tx_rtehtmlarea_acronym_mod.php";s:4:"9dce";s:14:"mod2/clear.gif";s:4:"cc11";s:13:"mod2/conf.php";s:4:"1ec2";s:18:"mod2/locallang.xml";s:4:"0cd8";s:21:"mod3/browse_links.php";s:4:"8d69";s:42:"mod3/class.tx_rtehtmlarea_browse_links.php";s:4:"f98e";s:46:"mod3/class.tx_rtehtmlarea_dam_browse_links.php";s:4:"e306";s:14:"mod3/clear.gif";s:4:"cc11";s:13:"mod3/conf.php";s:4:"b2fb";s:18:"mod3/locallang.xml";s:4:"2d51";s:46:"mod4/class.tx_rtehtmlarea_dam_browse_media.php";s:4:"a1e8";s:42:"mod4/class.tx_rtehtmlarea_select_image.php";s:4:"a55f";s:14:"mod4/clear.gif";s:4:"cc11";s:13:"mod4/conf.php";s:4:"8598";s:18:"mod4/locallang.xml";s:4:"8995";s:21:"mod4/select_image.php";s:4:"c6b9";s:34:"mod5/class.tx_rtehtmlarea_user.php";s:4:"f5fc";s:14:"mod5/clear.gif";s:4:"cc11";s:13:"mod5/conf.php";s:4:"7149";s:18:"mod5/locallang.xml";s:4:"7a78";s:13:"mod5/user.php";s:4:"f5b5";s:40:"mod6/class.tx_rtehtmlarea_parse_html.php";s:4:"33c4";s:13:"mod6/conf.php";s:4:"0cab";s:19:"mod6/parse_html.php";s:4:"e04e";s:32:"pi1/class.tx_rtehtmlarea_pi1.php";s:4:"54b2";s:17:"pi1/locallang.xml";s:4:"2e58";s:32:"pi2/class.tx_rtehtmlarea_pi2.php";s:4:"91ea";s:17:"pi2/locallang.xml";s:4:"a0a7";s:32:"pi3/class.tx_rtehtmlarea_pi3.php";s:4:"b2b7";s:36:"res/accessibilityicons/locallang.xml";s:4:"8211";s:39:"res/accessibilityicons/pageTSConfig.txt";s:4:"7e1a";s:39:"res/accessibilityicons/img/download.gif";s:4:"f6d9";s:44:"res/accessibilityicons/img/external_link.gif";s:4:"9e48";s:55:"res/accessibilityicons/img/external_link_new_window.gif";s:4:"6e8d";s:44:"res/accessibilityicons/img/internal_link.gif";s:4:"12b9";s:55:"res/accessibilityicons/img/internal_link_new_window.gif";s:4:"402a";s:35:"res/accessibilityicons/img/mail.gif";s:4:"d5a2";s:29:"res/advanced/pageTSConfig.txt";s:4:"414e";s:29:"res/advanced/userTSConfig.txt";s:4:"8e7a";s:26:"res/contentcss/default.css";s:4:"429f";s:28:"res/contentcss/locallang.xml";s:4:"ec0e";s:39:"res/contentcss/img/red_arrow_bullet.gif";s:4:"82d6";s:25:"res/demo/pageTSConfig.txt";s:4:"146c";s:25:"res/demo/userTSConfig.txt";s:4:"9b82";s:26:"res/image/pageTSConfig.txt";s:4:"9b6f";s:32:"res/indentalign/pageTSConfig.txt";s:4:"14d5";s:25:"res/proc/pageTSConfig.txt";s:4:"d4f8";s:26:"res/style/pageTSConfig.txt";s:4:"e8e7";s:28:"res/typical/pageTSConfig.txt";s:4:"d33d";s:28:"res/typical/userTSConfig.txt";s:4:"9fa6";s:29:"static/clickenlarge/setup.txt";s:4:"5681";}',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.1-0.0.0',
			'typo3' => '4.3.0-4.3.99',
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