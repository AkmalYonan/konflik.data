$(document).ready(function () {
			var s1 = [[2002, 112000], [2003, 122000], [2004, 104000], [2005, 99000], [2006, 121000],
			[2007, 148000], [2008, 114000], [2009, 133000], [2010, 161000], [2011, 173000]];
			var s2 = [[2002, 10200], [2003, 10800], [2004, 11200], [2005, 11800], [2006, 12400],
			[2007, 12800], [2008, 13200], [2009, 12600], [2010, 13100]];
		 
			plot1 = $.jqplot("chart-month", [s2, s1], {
				seriesColors: gcColor,
				grid: {
					background: 'rgba(255,255,255,0.0)',
					drawBorder: false,
					borderWidth:0,
					borderColor:'transparent',
					shadow: false,
					gridLineColor: '#eee',
					gridLineWidth: 1
				},
				legend: {
					renderer: $.jqplot.EnhancedLegendRenderer,
					show: true,
					location:'nw',
					rendererOptions: {
						numberRows:1
					}
				},
				// Turns on animatino for all series in this plot.
				animate: true,
				// Will animate plot on calls to plot1.replot({resetAxes:true})
				animateReplot: true,
				cursor: {
					show: true,
					zoom: true,
					looseZoom: true,
					showTooltip: false
				},
				series:[
					{
						pointLabels: {
							show: false
						},
						renderer: $.jqplot.BarRenderer,
						showHighlight: false,
						yaxis: 'y2axis',
						rendererOptions: {
							// Speed up the animation a little bit.
							// This is a number of milliseconds. 
							// Default for bar series is 3000. 
							animation: {
								speed: 2500
							},
							barWidth: 25,
							barPadding: -15,
							barMargin: 0,
							highlightMouseOver: false,
							barPadding:1,
							shadow:false
						}
					},
					{
						renderer:$.jqplot.LineRenderer,
						shadow:false,
						fill:true,
						fillAndStroke: true,
						breakOnNull:true,
						fillAlpha:0.2,
						lineWidth: 1.5,
						pointLabels: {
							show: true,
							hideZeros: true,
							formatString: "%'d",
							fontSize:10
						},
						rendererOptions: {
							animation: {
								show: (!$.jqplot.use_excanvas)?true:false,
								speed: 2000
							},
						}
					}
				],
				axesDefaults: {
					pad: 0.5
				},
				axes: {
					xaxis: {
						tickInterval: 1,
						drawMajorGridlines: false,
						drawMinorGridlines: true,
						drawMajorTickMarks: false,
						rendererOptions: {
							tickInset: 0.5,
							minorTicks: 1
						}
					},
					yaxis: {
						labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
						borderWidth:0,
						borderColor:'#aaa',
						tickOptions: {
							fontSize:10,
							showMark: false
						},
						rendererOptions: {
							tickDistribution: 'power'
						}
					},
					y2axis: {
						tickOptions: {
							formatString: "$%'d"
						},
						rendererOptions: {
							// align the ticks on the y2 axis with the y axis.
							alignTicks: true,
							forceTickAt0: true,
							tickDistribution: 'power'
						}
					}
				},
				highlighter: {
					show: true,
					showLabel: true,
					tooltipAxes: 'y',
					sizeAdjust: 7.5 , tooltipLocation : 'ne'
				}
			});
		   
		});