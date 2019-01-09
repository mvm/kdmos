class VotesAddComponent extends Fronty.ModelComponent {
	constructor(votesModel, userModel, router) {
	super(Handlebars.templates.votesadd, votesModel);
	
	this.votesService = new VotesService();
	this.votesModel = votesModel;
	this.router = router;
	
	  


		this.addEventListener("click", "#submit", () => {
	    
		var id = new URLSearchParams(window.location.hash.split('?')[1]).get('id');
		var selected_votes = document.getElementsByClassName("custom-select"); 
	    var data = new Array();
		for(var i = 0; i < selected_votes.length; i++){
			data.push(selected_votes[i].options[selected_votes[i].selectedIndex].value);
		} 
	    this.votesService.addVotes(id, data)
		.then( () => {
		    this.router.goToPage('votes?id='+id);
		});
	});
	
	}
	
	
	onStart(){
		var id = this.router.getRouteQueryParam('id');
		if(id != null) {
	    this.votesService.findSurvey(id)
		.then((survey) => {
		    this.votesModel.setSurvey(survey);
		});
	}
	}
	
	
	
	    
	}
