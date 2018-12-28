class SurveyAddComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
	var surveyModel = new SurveyModel();
	
	super(Handlebars.templates.surveyadd, surveyModel);
	this.surveyModel = surveyModel;
	this.surveysService = new SurveysService();
	this.router = router;
	
	this.optctr = -1000;
	this.surveyModel.options = [new OptionModel(-1001)];

	this.addEventListener('click', "#entry_add_date", () => {
	    this.surveyModel.newOption(++this.optctr);
	});

	this.addEventListener('click', "#submitbutton", () => {
	    var survey = {}

	    survey.title = $("#surveytitle").val();
	    survey.description = $("#surveydescription").val();
	    survey.options = [];

	    this.surveyModel.options.forEach( (x) => {
		var opt = {};
		opt.day = $("#date" + x.id + "_day").val();
		opt.start = $("#date" + x.id + "_start").val();
		opt.end = $("#date" + x.id + "_end").val();
		survey.options.push(opt);
	    });

	    this.surveysService.addSurvey(survey)
		.then( () => {
		    this.router.goToPage('created-surveys');
		})
		.fail((xhr, errorThrown, statusText) => {
		    if(xhr.status == 400) {
			this.surveyModel.set(() => {
			    this.surveyModel.errors = xhr.responseJSON;
			});
		    } else {
			alert("an error has occurred during request: " + statusText + "." + xhr.responseText);
		    }
		});
	});
    }

    createChildModelComponent(className, element, id, modelItem) {
	return new OptionComponent(modelItem, this);
    }
}

class OptionComponent extends Fronty.ModelComponent {
    constructor(optionModel, surveyComponent, editMode) {
	super(Handlebars.templates.option, optionModel);
	this.optionModel = optionModel;
	this.surveyComponent = surveyComponent;

	if(editMode && editMode == true)
	    this.editMode = true;
	else
	    this.editMode = false;
    }

    afterRender() {
	var date_id = "date" + this.optionModel.id;
	var id = this.optionModel.id;

	var dayParams = {};
	dayParams.format = 'YYYY-MM-DD';
	if(this.optionModel.day) {
	    dayParams.date = this.optionModel.day;
	}

	var startParams = {};
	startParams.format = 'HH:mm:ss';
	if(this.optionModel.start) {
	    startParams.date = this.optionModel.day + " " + this.optionModel.start;
	    $("#date" + this.optionModel.id + "_start").val( this.optionModel.start);
	}

	var endParams = {};
	endParams.format = 'HH:mm:ss';
	if(this.optionModel.end) {
	    endParams.date = this.optionModel.day + " " + this.optionModel.end;
	}
	
	$("#" + date_id + "_day").datetimepicker(dayParams);
	$("#" + date_id + "_start").datetimepicker(startParams);
	$("#" + date_id + "_start").on("change.datetimepicker",
				       function(e) {
					   $("#" + date_id + "_end").datetimepicker("minDate", e.date);
				       });
	$("#" + date_id + "_end").datetimepicker(endParams);


	this.addEventListener('click', "#" + date_id + "_del", () => {
	    this.surveyComponent.surveyModel.deleteOption(id);
	});
    }
}
