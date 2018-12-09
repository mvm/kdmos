class SurveyEditComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
	var surveyModel = new SurveyModel();
	super(Handlebars.templates.surveyadd, surveyModel);
	this.surveyModel = surveyModel;
	this.surveysService = new SurveysService();
	this.router = router;
    }

    createChildModelComponent(className, element, id, modelItem) {
	return new OptionComponent(modelItem, this);
    }
}
