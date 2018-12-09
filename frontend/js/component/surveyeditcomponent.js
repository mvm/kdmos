class SurveyEditComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
	var surveyModel = new SurveyModel();
	super(Handlebars.templates.surveyadd, surveyModel);
	this.surveyModel = surveyModel;
	this.surveysService = new SurveysService();
	this.router = router;
    }

    onStart() {
	var id = this.router.getRouteQueryParam('id');
	if(id != null) {
	    this.surveysService.findSurvey(id)
		.then((survey) => {
		    this.surveyModel.fromJSON(survey);
		});
	}
    }

    createChildModelComponent(className, element, id, modelItem) {
	return new OptionComponent(modelItem, this);
    }
}
