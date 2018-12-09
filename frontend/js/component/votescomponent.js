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
	
	
	
	if_compare_option(){
		var args = [].slice.apply(arguments);
		var opts = args.pop();
		if(opts==this.votesModel[0].survey_option.id) return true;
		else return false;		
	};
	
	valor(){
		var total=0;
		var valor = vote.vote;
		switch (valor){
			case "Y": 
				document.write("<i class='fas fa-2x fa-check option'></i>");
				total+=1;
				break;
			case "N":
				document.write("<i class='fas fa-2x fa-times option'></i>");
				break;
			default:
				document.write("<i class='fas fa-2x fa-question option'></i>");		
	}};
	
	
	total(){
	document.getElementById("total").innerHTML = total;}
	
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