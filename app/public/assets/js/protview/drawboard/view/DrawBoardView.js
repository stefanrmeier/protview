ProtView.DrawBoard.View.DrawBoardView = Backbone.View.extend({
	el : '#drawBoard',
	initialize : function(args) {
		var self = this;
		self.$el.svg({
			onLoad : function(svg) {
				//hack to overcome the 'this problem' in callback as
				//context cannot be specified for onLoad
				self.drawing = new ProtView.DrawBoard.Utils.Drawing(svg);
			},
			settings: {
				width : "100%",
				height : "800px", 
				xmlns : "http://www.w3.org/2000/svg",
				style : "display:inline; float: left; z-index: 1;"
			}
		});
	},
	events: { 
	},
	setController : function(controller) {
		this.controller = controller;
	},
	setModel : function(model) {
		model.on('change', this.render, this);	
		model.on('reset', this.render, this);	
		this.model = model;
	},
	render : function() {
		this.drawing.paint(this.model);
		/*var json = this.model.toJSON();
		var jsonString = JSON.stringify(json);
		this.$el.html(jsonString);*/
		return this;
	}
});