/**
 * 
 * Module's Main controller
 * 
 * 
 * @module Structure
 * @namespace Structure.Controller
 * @class MainController
 * @extends Core.MainController
 * 
 * @author Stefan Meier
 * @version 20120903
 * 
 */
ProtView.Structure.Controller.MainController = ProtView.Core.MainController.extend( {
	/**
	 * Loads the requested resource
	 * 
	 * On loading creates resource controller and view
	 * 
	 * Available resources : peptide, protein, protein-new
	 * 
	 * @method load
	 * @param {String} resource
	 */
	load : function(resource) {
		var controller = null,
		view = null,
		stack = this.stack;

		if (!stack[resource]) {
			switch(resource) {
				case 'peptide' :
					controller = new ProtView.Structure.Controller.PeptideController();
					view = new ProtView.Structure.View.PeptideView({
						el : '#peptide-form',
						templateEl : '#peptide-form-template',
					});
					controller.addView(view);
					break;
				case 'protein' :
					controller = new ProtView.Structure.Controller.ProteinController();
					view = new ProtView.Structure.View.ProteinView({
						el : '#protein-form',
						templateEl : '#protein-form-template',
						bindings : {
								name: '#protein-name',
								species: '#protein-species',
								note: '#protein-note'
							}
					});
					controller.addView(view);
					break;	
				case 'protein-new' :
					controller = new ProtView.Structure.Controller.ProteinController();
					view = new ProtView.Structure.View.NewProteinView({
						el : '#new-protein-form',
						templateEl : '#new-protein-form-template',
						bindings : {
								name: '#new-protein-name',
							}
					});
					controller.addView(view);
				break;
				default :
					console.log('error no resource given or not known');
					break;
			}
			
			stack[resource] = controller;
			this.stack = stack;
		}
	},
	/**
	 * Handles update requests
	 * 
	 * @method update
	 * @param {Object} arguments
	 */
	update : function(arguments) {
		if (arguments.protein) {
			var stack = this.stack;
			for (var el in stack) {
				//dirty fix, because database insert causes update
				//even on dialog close, messages should be more precise
				if (el != 'protein-new')
					stack[el].update(arguments.protein);
			}
		}
	},
	/**
	 * Unloads loaded resources
	 * 
	 * For available resource see load()
	 * 
	 * @method unload
	 * @param {Object} resource
	 */
	unload : function(resource) {
		var stack = this.stack;
		
		if (stack[resource]) {
			stack[resource].unload();
			stack[resource] = null;
			delete stack[resource];
		}
	}
});