class VotesModel extends Fronty.Model{
    constructor() {
	super('VotesModel');
	this.votes = [];
	this.survey = {};
	}
	
	setSurvey(survey) {
		this.set((self) => {
			self.survey = survey;			
		});
	}
	
	setVotes(votes){
		this.set((self) => {
			self.votes = votes;
		});
	}
}