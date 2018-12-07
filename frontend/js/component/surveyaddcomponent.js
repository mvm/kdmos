class SurveyAddComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
	var surveyModel = new SurveyModel();
	
	super(Handlebars.templates.surveyadd, surveyModel);
	this.surveyModel = surveyModel;
	this.surveyModel.options = [new OptionModel(1, "2018-01-01"), new OptionModel(2)];
    }

    createChildModelComponent(className, element, id, modelItem) {
	return new OptionComponent(modelItem, this);
    }
}

class OptionComponent extends Fronty.ModelComponent {
    constructor(optionModel, surveyAddComponent) {
	super(Handlebars.templates.option, optionModel);
	this.optionModel = optionModel;
	this.surveyAddComponent = surveyAddComponent;
    }
}
