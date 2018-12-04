class SurveyCreatedComponent extends Fronty.ModelComponent {
    constructor(surveysModel, userModel, router, createdMode) {
	super(Handlebars.templates.surveylist, surveysModel);

	this.surveysService = new SurveysService();
	this.surveysModel = surveysModel;
	this.addModel('user', userModel);
	this.router = router;
	this.createdMode = createdMode;
    }

    onStart() {
	this.updateSurveys();
    }
    
    updateSurveys() {
	var surveys;
	if(this.createdMode == true)
	    surveys = this.surveysService.findCreated();
	else
	    surveys = this.surveysService.findParticipated();
	
	surveys.then((data) => {
	    this.surveysModel.setSurveys(
		data.map(
		    (item) => new SurveyModel(item.id, item.title, item.description)
		));
	});
    }

    createChildModelComponent(className, element, id, modelItem) {
	return new SurveyRowComponent(modelItem, this.userModel, this.router, this);
    }
}

class SurveyRowComponent extends Fronty.ModelComponent {
    constructor(surveyModel, userModel, router, surveysComponent) {
	super(Handlebars.templates.surveyrow, surveyModel, null, null);

	this.surveysComponent = surveysComponent;
	this.userModel = userModel;
	this.surveyModel = surveyModel;
	surveyModel.createdMode = surveysComponent.createdMode;
    }
}
