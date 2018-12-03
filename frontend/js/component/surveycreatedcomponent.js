class SurveyCreatedComponent extends Fronty.ModelComponent {
    constructor(surveysModel, userModel, router) {
	super(Handlebars.templates.surveylist, surveysModel);

	this.surveysService = new SurveysService();
	this.surveysModel = surveysModel;
	this.addModel('user', userModel);
	this.router = router;
    }

    onStart() {
	this.updateSurveys();
    }
    
    updateSurveys() {
	this.surveysService.findCreated().then((data) => {
	    this.surveysModel.setSurveys(
		data.map(
		    (item) => new SurveyModel(item.id, item.title, item.description)
		));
	});
    }
}
