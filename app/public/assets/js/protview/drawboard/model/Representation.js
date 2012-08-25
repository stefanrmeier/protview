ProtView.DrawBoard.Model.Representation = Backbone.RelationalModel.extend({
	relations: [{
        type: Backbone.HasMany,
        key: 'structuralGeometries',
        relatedModel: 'ProtView.DrawBoard.Model.StructuralGeometry',
        collectionType: 'ProtView.DrawBoard.Model.StructuralGeometryCollection',
        reverseRelation: {
            key: 'representation_id',
            // includeInJSON: 'id'
            // 'relatedModel' is automatically set to 'Zoo'; the 'relationType' to 'HasOne'.
        }
    }],
	defaults : {
		id: null,
		title: null,
		description: null,
		params : {},
		contributors : {}
	},
	url : function() {
		var root = Application.ROOTPATH;
		return this.id ? root + 'api/representations/' + this.id + '?details=all' : root + 'api/representations/';
	},
});