class VoteModel extends Fronty.Model{
	constructor(user, survey_option, value){
		super('VoteModel');
		if(user)
			this.user = user;
		if(survey_option)
			this.survey_option = survey_option;
		if(value)
			this.value = value;
	}
	
	setUser(user) {
	this.set((self) => {
	    self.user = user;
	});
	}
	
	setOption(survey_option) {
	this.set((self) => {
	    self.survey_option = survey_option;
	});
	}
	
	setUser(value) {
	this.set((self) => {
	    self.value = value;
	});
	}
	
	
}