/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Stefan Galinski <stefan.galinski@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

Ext.ns('TYPO3');

/**
 * The backend viewport configuration
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */
TYPO3.Viewport.configuration = {
	layout: 'border',
	id: 'typo3-viewport',
	renderTo: Ext.getBody(),
	border: false,
	items: [{
		layout: 'absolute',
		region: 'north',
		id: 'typo3-topbar',
		height: 42,
		contentEl: 'typo3-top-container',
		border: false
	}, {
		layout: 'fit',
		region: 'west',
		id: 'typo3-module-menu',
		collapsible: true,
		collapseMode: 'mini',
		floatable: true,
		hideCollapseTool: true,
		split: true,
		border: false,
		autoScroll: true
	}, {
		region: 'center',
		layout: 'border',
		border: false,
		items: [{
			region: 'west',
			layout: 'fit',
			id: 'typo3-navigationContainer',
			width: 300,
			minWidth: 20,
			floatable: true,
			animCollapse: false,
			split: true,
			collapsible: true,
			collapseMode: 'mini',
			hideCollapseTool: true,
			autoScroll: true,
			hidden: true,
			border: false,
			xtype: 'iframePanel',
			name: 'navigation'
		}, {
			region: 'center',
			layout: 'fit',
			id: 'typo3-contentContainer',
			anchor: '100% 100%',
			border: false,
			xtype: 'iframePanel',
			name: 'content'
		}]
	}, {
		region: 'south',
		xtype: 'typo3DebugPanel',
		collapsible: true,
		collapseMode: 'mini',
		collapsed: true,
		hideCollapseTool: true,
		animCollapse: false,
		split: true,
		autoScroll: true,
		hidden: true,
		height: 200,
		id: 'typo3-debug-console',
		border: false
	}]
};