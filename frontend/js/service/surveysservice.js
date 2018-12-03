class SurveysService {
    constructor() {
    }

    findCreated() {
	return $.get(AppConfig.backendServer+'/rest/survey/created');
    }

    findParticipated() {
	return $.get(AppConfig.backendServer + '/rest/survey/participated');
    }
}
