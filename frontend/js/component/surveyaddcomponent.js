class SurveyAddComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
	var surveyModel = new SurveyModel();
	
	super(Handlebars.templates.surveyadd, surveyModel);
	this.surveyModel = surveyModel;
	this.optctr = 1;
	this.surveyModel.options = [new OptionModel(1)];

	this.addEventListener('click', "#entry_add_date", () => {
	    this.surveyModel.newOption(++this.optctr);
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

    afterRender() {
	var date_id = "date" + this.optionModel.id;
	var id = this.optionModel.id;
	
	$("#" + date_id + "_day").datetimepicker({
	    format: 'YYYY-MM-DD'
	});
	$("#" + date_id + "_start").datetimepicker({
	    format: 'HH:mm:00'
	});
	$("#" + date_id + "_start").on("change.datetimepicker", function(e) {
	    $("#" + date_id + "_end").datetimepicker("minDate", e.date);
	});
	$("#" + date_id + "_end").datetimepicker({
	    format: 'HH:mm:00'
	});

	this.addEventListener('click', "#" + date_id + "_del", () => {
	    this.surveyAddComponent.surveyModel.deleteOption(id);
	});
    }
}
