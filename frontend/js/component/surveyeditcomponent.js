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
		    this.surveyModel.set( (self) => {
			self.id = survey.id;
			self.title = survey.title;
			self.description = survey.description;
		    });
		});
	}
    }

    createChildModelComponent(className, element, id, modelItem) {
	return new OptionComponent(modelItem, this);
    }
}
