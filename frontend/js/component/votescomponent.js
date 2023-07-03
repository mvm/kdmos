class VotesComponent extends Fronty.ModelComponent {
	constructor(votesModel, userModel, router, showMode) {
	super(Handlebars.templates.votes, votesModel);
	
	this.votesService = new VotesService();
	this.votesModel = votesModel;
	/* this.addModel('user', userModel); */
	this.router = router;
	this.showMode = showMode;
	
	  
	Handlebars.registerHelper("switch", function(value, options) {
		this._switch_value_ = value;
		var html = options.fn(this); // Process the body of the switch block
		delete this._switch_value_;
		return html;
	});

	Handlebars.registerHelper("case", function(value, options) {
		if (value == this._switch_value_) {
			return options.fn(this);
		}
	});

	}
	
	
	onStart(){
		this.showOptions();
	}
	
	
	showOptions(){
		var votes;
	    var survey;
		var id = new URLSearchParams(window.location.hash.split('?')[1]).get('id');
		votes = this.votesService.findVotes(id);
	    survey = this.votesService.findSurvey(id);
		survey.then( (survey) => {
			this.votesModel.setSurvey(survey);
			});
			votes.then((votes) => {
				this.votesModel.setVotes(votes);
		});
	    
	}

}


