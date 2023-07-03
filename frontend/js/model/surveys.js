class SurveysModel extends Fronty.Model {
    constructor() {
	super('SurveysModel');
	this.surveys = [];
    }

    setSelectedSurvey(survey) {
	this.set((self) => {
	    self.selectedSurvey = survey;
	});
    }

    setSurveys(surveys) {
	this.set((self) => {
	    self.surveys = surveys;
	});
    }
}
