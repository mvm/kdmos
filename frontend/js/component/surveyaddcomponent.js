class SurveyAddComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
	var surveyModel = new SurveyModel();
	
	super(Handlebars.templates.surveyadd, surveyModel);
	this.surveyModel = surveyModel;
	this.optctr = 1;
	this.surveyModel.options = [new OptionModel(1)];
	this.activateDeleteButton(1);

	this.addEventListener('click', "#entry_add_date", () => {
	    this.surveyModel.newOption(++this.optctr);
	    this.activateDeleteButton(this.optctr);
	});
    }

    activateDeleteButton(id) {
	this.addEventListener('click', "#date" + id + "_del", () => {
	    this.surveyModel.deleteOption(id);
	});
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
