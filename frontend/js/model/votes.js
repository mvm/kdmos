class VotesModel extends Fronty.Model{
    constructor() {
	super('VotesModel');
	this.votes = [];
	}

	setVotes(votes){
		this.set((self) => {
			self.votes = votes;
		});
	}
}