/* Copyright (c) 2006-2008 MetaCarta, Inc., published under the Clear BSD
 * license.  See http://svn.openlayers.org/trunk/openlayers/license.txt for the
 * full text of the license. */

/**
 * @requires OpenLayers/Popup/Framed.js
 * @requires OpenLayers/Util.js
 */

/**
 * Class: OpenLayers.Popup.Tooltip
 * 
 * Inherits from: 
 *  - <OpenLayers.Popup.Framed>
 */
OpenLayers.Popup.Tooltip = 
  OpenLayers.Class(OpenLayers.Popup.Framed, {

    /** 
     * Property: contentDisplayClass
     * {String} The CSS class of the popup content div.
     */
    contentDisplayClass: "olTooltipCloudPopupContent",

    /**
     * APIProperty: autoSize
     * {Boolean} Framed Cloud is autosizing by default.
     */
    autoSize: true,

    /**
     * APIProperty: panMapIfOutOfView
     * {Boolean} Framed Cloud does pan into view by default.
     */
    panMapIfOutOfView: true,

    /**
     * APIProperty: imageSize
     * {<OpenLayers.Size>}
     */
    imageSize: new OpenLayers.Size(676, 705),

    /**
     * APIProperty: isAlphaImage
     * {Boolean} The Tooltip does not use an alpha image (in honor of the 
     *     good ie6 folk out there)
     */
    isAlphaImage: false,

    /** 
     * APIProperty: fixedRelativePosition
     * {Boolean} The Framed Cloud popup works in just one fixed position.
     */
    fixedRelativePosition: false,

    /**
     * Property: positionBlocks
     * {Object} Hash of differen position blocks, keyed by relativePosition
     *     two-character code string (ie "tl", "tr", "bl", "br")
     */

	positionBlocks: {
        "tl": {
            'offset': new OpenLayers.Pixel(44, -10),
            'padding': new OpenLayers.Bounds(8, 20, 8, 9),
            'blocks': [
                { // top-left
                    size: new OpenLayers.Size('auto', 'auto'),
                    anchor: new OpenLayers.Bounds(0, 21, 22, 0),
                    position: new OpenLayers.Pixel(0, 0)
                },
                { //top-right
                    size: new OpenLayers.Size(22, 'auto'),
                    anchor: new OpenLayers.Bounds(null, 20, 0, 0),
                    position: new OpenLayers.Pixel(-638, 0)
                },
                { //bottom-left
                    size: new OpenLayers.Size('auto', 22),
                    anchor: new OpenLayers.Bounds(null, 7, 22, null),
                    position: new OpenLayers.Pixel(0, -605)
                },
                { //bottom-right
                    size: new OpenLayers.Size(22, 22),
                    anchor: new OpenLayers.Bounds(null, 7, 0, null),
                    position: new OpenLayers.Pixel(-638, -605)
                },
                { // stem
                    size: new OpenLayers.Size(81, 14),
                    anchor: new OpenLayers.Bounds(null, 1, 0, null),
                    position: new OpenLayers.Pixel(0, -659)
                }
            ]
        },
        "tr": {
            'offset': new OpenLayers.Pixel(-45, -10),
            'padding': new OpenLayers.Bounds(8, 20, 8, 9),
            'blocks': [
                { // top-left
                    size: new OpenLayers.Size('auto', 'auto'),
                    anchor: new OpenLayers.Bounds(0, 21, 22, 0),
                    position: new OpenLayers.Pixel(0, 0)
                },
                { //top-right
                    size: new OpenLayers.Size(22, 'auto'),
                    anchor: new OpenLayers.Bounds(null, 20, 0, 0),
                    position: new OpenLayers.Pixel(-638, 0)
                },
                { //bottom-left
                    size: new OpenLayers.Size('auto', 22),
                    anchor: new OpenLayers.Bounds(0, 7, 22, null),
                    position: new OpenLayers.Pixel(0, -605)
                },
                { //bottom-right
                    size: new OpenLayers.Size(22, 22),
                    anchor: new OpenLayers.Bounds(null, 7, 0, null),
                    position: new OpenLayers.Pixel(-638, -605)
                },
                { // stem
                    size: new OpenLayers.Size(81, 15),
                    anchor: new OpenLayers.Bounds(0, 0, null, null),
                    position: new OpenLayers.Pixel(-215, -659)
                }
            ]
        },
        "bl": {
            'offset': new OpenLayers.Pixel(45, 12),
            'padding': new OpenLayers.Bounds(8, 9, 8, 20),
            'blocks': [
                { // top-left
                    size: new OpenLayers.Size('auto', 'auto'),
                    anchor: new OpenLayers.Bounds(0, 21, 22, 12),
                    position: new OpenLayers.Pixel(0, 0)
                },
                { //top-right
                    size: new OpenLayers.Size(22, 'auto'),
                    anchor: new OpenLayers.Bounds(null, 21, 0, 12),
                    position: new OpenLayers.Pixel(-638, 0)
                },
                { //bottom-left
                    size: new OpenLayers.Size('auto', 21),
                    anchor: new OpenLayers.Bounds(0, 0, 22, null),
                    position: new OpenLayers.Pixel(0, -609)
                },
                { //bottom-right
                    size: new OpenLayers.Size(22, 21),
                    anchor: new OpenLayers.Bounds(null, 0, 0, null),
                    position: new OpenLayers.Pixel(-638, -609)
                },
                { // stem
                    size: new OpenLayers.Size(81, 15),
                    anchor: new OpenLayers.Bounds(null, null, 0, 0),
                    position: new OpenLayers.Pixel(-101, -637)
                }
            ]
        },
        "br": {
            'offset': new OpenLayers.Pixel(-44, 12),
            'padding': new OpenLayers.Bounds(8, 9, 8, 20),
            'blocks': [
                { // top-left
                    size: new OpenLayers.Size('auto', 'auto'),
                    anchor: new OpenLayers.Bounds(0, 21, 22, 12),
                    position: new OpenLayers.Pixel(0, 0)
                },
                { //top-right
                    size: new OpenLayers.Size(22, 'auto'),
                    anchor: new OpenLayers.Bounds(null, 21, 0, 12),
                    position: new OpenLayers.Pixel(-638, 0)
                },
                { //bottom-left
                    size: new OpenLayers.Size('auto', 21),
                    anchor: new OpenLayers.Bounds(0, 0, 22, null),
                    position: new OpenLayers.Pixel(0, -609)
                },
                { //bottom-right
                    size: new OpenLayers.Size(22, 21),
                    anchor: new OpenLayers.Bounds(null, 0, 0, null),
                    position: new OpenLayers.Pixel(-638, -609)
                },
                { // stem
                    size: new OpenLayers.Size(81, 15),
                    anchor: new OpenLayers.Bounds(0, null, null, 0),
                    position: new OpenLayers.Pixel(-310, -637)
                }
            ]
        },
        "tt": {
            'offset': new OpenLayers.Pixel(-45, -5),
            'padding': new OpenLayers.Bounds(8, 15, 8, 9),
            'blocks': [
                { // top-left
                    size: new OpenLayers.Size('auto', 'auto'),
                    anchor: new OpenLayers.Bounds(0, 21, 22, 0),
                    position: new OpenLayers.Pixel(0, 0)
                },
                { //top-right
                    size: new OpenLayers.Size(22, 'auto'),
                    anchor: new OpenLayers.Bounds(null, 20, 0, 0),
                    position: new OpenLayers.Pixel(-638, 0)
                },
                { //bottom-left
                    size: new OpenLayers.Size('auto', 22),
                    anchor: new OpenLayers.Bounds(0, 2, 22, null),
                    position: new OpenLayers.Pixel(0, -605)
                },
                { //bottom-right
                    size: new OpenLayers.Size(22, 22),
                    anchor: new OpenLayers.Bounds(null, 2, 0, null),
                    position: new OpenLayers.Pixel(-638, -605)
                },
                { // stem
                    size: new OpenLayers.Size(81, 10),
                    anchor: new OpenLayers.Bounds(0, 0, null, null),
                    position: new OpenLayers.Pixel(-215, -665)
                }
            ]
        }
    },
    /**
     * APIProperty: minSize
     * {<OpenLayers.Size>}
     */
    minSize: new OpenLayers.Size(120, 21),

    /**
     * APIProperty: maxSize
     * {<OpenLayers.Size>}
     */
    maxSize: new OpenLayers.Size(600, 200),
	
	/**
     * APIProperty: posBlockHack
     * {<OpenLayers.Size>}
     */
    posBlockHack: 'tt',

    /** 
     * Constructor: OpenLayers.Popup.Tooltip
     * 
     * Parameters:
     * id - {String}
     * lonlat - {<OpenLayers.LonLat>}
     * contentSize - {<OpenLayers.Size>}
     * contentHTML - {String}
     * anchor - {Object} Object to which we'll anchor the popup. Must expose 
     *     a 'size' (<OpenLayers.Size>) and 'offset' (<OpenLayers.Pixel>) 
     *     (Note that this is generally an <OpenLayers.Icon>).
     * closeBox - {Boolean}
     * closeBoxCallback - {Function} Function to be called on closeBox click.
     */
    initialize:function(id, lonlat, contentSize, contentHTML, anchor, closeBox, 
                        closeBoxCallback) {
        this.imageSrc = OpenLayers.Util.getImagesLocation() + 'cloud-popup-relative-tooltip.png';
        OpenLayers.Popup.Framed.prototype.initialize.apply(this, arguments);
        this.contentDiv.className = this.contentDisplayClass;
    },
	
	calculateRelativePosition : function () {  return this.posBlockHack; },
    /** 
     * APIMethod: destroy
     */
    destroy: function() {
        OpenLayers.Popup.Framed.prototype.destroy.apply(this, arguments);
    },

    CLASS_NAME: "OpenLayers.Popup.Tooltip"
});
