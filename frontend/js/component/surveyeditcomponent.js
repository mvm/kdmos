class SurveyEditComponent extends Fronty.ModelComponent {
    constructor(userModel, router) {
	var surveyModel = new SurveyModel();
	super(Handlebars.templates.surveyadd, surveyModel);
	this.surveyModel = surveyModel;
	this.surveysService = new SurveysService();
	this.router = router;
	this.optctr = -1024;

	this.addEventListener('click', "#entry_add_date", () => {
	    this.surveyModel.newOption(++this.optctr);
	    this.surveyModel.added.push(this.optctr);
	    console.log(JSON.stringify(this.surveyModel));
	});

	this.addEventListener("click", "#submitbutton", () => {
	    var data = {};

	    data.id = this.router.getRouteQueryParam('id');
	    data.title = $("#surveytitle").val();
	    data.description = $("#surveydescription").val();
	    data.deleted = this.surveyModel.deleted;

	    data.new = [];
	    this.surveyModel.added.forEach( i => {
		var opt_json = {};

		opt_json.day = $("#date" + i + "_day").val();
		opt_json.start = $("#date" + i + "_start").val();
		opt_json.end = $("#date" + i + "_end").val();

		data.new.push(opt_json);
	    });

	    data.edited = [];
	    this.surveyModel.edited.forEach( i => {
		var opt_json = {};

		opt_json.id = i;
		opt_json.day = $("#date" + i + "_day").val();
		opt_json.start = $("#date" + i + "_start").val();
		opt_json.end = $("#date" + i + "_end").val();

		data.edited.push(opt_json);
	    });
	    
	    this.surveysService.saveSurvey(data)
		.then( () => {
		    this.router.goToPage('created-surveys');
		})
		.fail((xhr, errorThrown, statusText) => {
		    if(xhr.status == 400) {
			this.surveyModel.set(() => {
			    this.surveyModel.error = xhr.responseJSON;
			});
		    } else {
			alert("an error has ocurred during request: " + statusText + "." + xhr.responseText);
		    }
		});
	});
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
	return new OptionComponent(modelItem, this, );
    }
}
