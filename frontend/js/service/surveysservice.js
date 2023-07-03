class SurveysService {
    constructor() {
    }

    findCreated() {
	return $.get(AppConfig.backendServer+'/rest/survey/created');
    }

    findParticipated() {
	return $.get(AppConfig.backendServer + '/rest/survey/participated');
    }

    findSurvey(id) {
	return $.get(AppConfig.backendServer + '/rest/survey/' + id);
    }
    
    saveSurvey(survey) {
	return $.ajax({
	    url: AppConfig.backendServer + '/rest/survey/' + survey.id,
	    method: 'PUT',
	    data: JSON.stringify(survey),
	    contentType: 'application/json'
	});
    }

    addSurvey(survey) {
	return $.ajax({
	    url: AppConfig.backendServer + '/rest/survey',
	    method: 'POST',
	    data: JSON.stringify(survey),
	    contentType: 'application/json'
	});
    }
}
