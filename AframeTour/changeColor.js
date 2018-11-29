AFRAME.registerComponent('change-color', {
	schema: {
		color: {default: '#666'}
	},
	init: function(){
		var data = this.data;
		this.el.addaEventListener('click', function(){
			this.setAttribute('color', data.color);
		})
	}
});