class VotesComponent extends Fronty.ModelComponent {
	constructor(votesModel, userModel, router, showMode) {
	super(Handlebars.templates.votes, votesModel);
	
	this.votesService = new VotesService();
	this.votesModel = votesModel;
	this.addModel('user', userModel);
	this.router = router;
	this.showMode = showMode;
	
	this.votesService = new VotesService();
	
	this.addEventListener('click', '#votelink', () => {
      this.votesModel.set(() => {
        this.votesModel.showMode = false;
      });
    });
	
	}
	
	onStart(){
		this.showOptions();
	}
	
	showOptions(){
	var votes;
	if(this.showMode == true)
		votes = this.votesService.findVotes();
	
	votes.then((data) => {
		this.votesModel.setVotes(
		data.map(
			(item) => new VoteModel(item.user, item.survey_option, item.vote)
			));
	});
	}
	
}